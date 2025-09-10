<?php

namespace App\Services;

use App\Models\Classroom;
use App\Models\Section;
use App\Models\StudentGroup;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Timetable;
use Illuminate\Support\Facades\DB;

class TimetableService
{
    // --- CONFIGURATION ---
    private $daysOfWeek = [1, 2, 3, 4, 5]; // 1=Monday, 5=Friday
    private $timeSlots = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00'];
    private $breakWindow = ['12:00:00', '13:00:00', '14:00:00']; 
    private $maxContinuousHours = 4;

    // --- INTERNAL STATE ---
    private $timetableGrid;
    private $teachers;
    private $classrooms;
    private $classPool = [];
    private $conflictReport = [];


    /**
     * Main method to generate the timetable.
     */
    public function generate()
    {
        $this->initialize();

        $this->createClassPool();

        $this->runPlacementEngine();

        $this->saveTimetable();

        return [
            'timetable' => Timetable::all(),
            'conflict_report' => $this->conflictReport,
        ];
    }

    /**
     * Step 1: Load all necessary data from DB into memory.
     */
    private function initialize()
    {
        Timetable::query()->delete(); // Clear the existing timetable
        $this->timetableGrid = [];
        $this->conflictReport = [];
        $this->classPool = [];

        // Eager load relationships for efficiency
        $this->teachers = Teacher::with(['unavailabilities', 'subjects'])->get();
        $this->classrooms = Classroom::all();
    }

    /**
     * Step 2: Build a master list of every 1-hour session to be scheduled.
     */
    private function createClassPool()
    {
        $subjects = Subject::with('course.sections.studentGroups')->get();

        foreach ($subjects as $subject) {
            foreach ($subject->course->sections as $section) {
                // Determine if this is a group subject (e.g., lab) or for the whole section
                $isGroupSubject = ($subject->type === 'lab'); // Assuming a 'type' column on subjects table

                if ($isGroupSubject && $section->studentGroups->count() > 0) {
                    foreach ($section->studentGroups as $group) {
                        for ($i = 0; $i < $subject->weekly_hours; $i++) {
                            $this->classPool[] = new \ArrayObject([
                                'subject' => $subject,
                                'section' => $section,
                                'student_group' => $group,
                            ]);
                        }
                    }
                } else {
                    for ($i = 0; $i < $subject->weekly_hours; $i++) {
                        $this->classPool[] = new \ArrayObject([
                            'subject' => $subject,
                            'section' => $section,
                            'student_group' => null, // This class is for the whole section
                        ]);
                    }
                }
            }
        }
        // Shuffle the pool to avoid bias in scheduling order
        shuffle($this->classPool);
    }

    /**
     * Step 3: The main algorithm to place classes from the pool into the grid.
     */
    private function runPlacementEngine()
    {
        foreach ($this->classPool as $classToSchedule) {
            $isPlaced = false;

            foreach ($this->daysOfWeek as $day) {
                foreach ($this->timeSlots as $time) {
                    // Find teachers qualified for this subject
                    $qualifiedTeachers = $this->teachers->filter(function ($teacher) use ($classToSchedule) {
                        return $teacher->subjects->contains($classToSchedule['subject']);
                    });

                    foreach ($qualifiedTeachers as $teacher) {
                        foreach ($this->classrooms as $classroom) {
                            
                            // --- RUN ALL VALIDATION CHECKS ---
                            if ($this->isValidSlot($day, $time, $teacher, $classToSchedule['section'], $classroom)) {
                                
                                // --- SUCCESS! PLACE THE CLASS ---
                                $this->placeClassInGrid($day, $time, $teacher, $classroom, $classToSchedule);
                                $isPlaced = true;
                                break 4; // Break out of all loops for this class
                            }
                        }
                    }
                }
            }

            if (!$isPlaced) {
                $this->conflictReport[] = $classToSchedule;
            }
        }
    }

    /**
     * Checks if a specific slot is valid for a given class combination.
     */
    private function isValidSlot($day, $time, $teacher, $section, $classroom)
    {
        // Basic Availability Check
        if (isset($this->timetableGrid[$day][$time]['teacher'][$teacher->id])) return false;
        if (isset($this->timetableGrid[$day][$time]['section'][$section->id])) return false;
        if (isset($this->timetableGrid[$day][$time]['classroom'][$classroom->id])) return false;
        
        // Check for Teacher Unavailability from DB
        foreach ($teacher->unavailabilities as $slot) {
            if ($slot->day_of_week == $day && $time >= $slot->start_time && $time < $slot->end_time) {
                return false;
            }
        }

        // Continuous Class Check
        if ($this->calculateContinuousHours($day, $time, 'teacher', $teacher->id) >= $this->maxContinuousHours) return false;
        if ($this->calculateContinuousHours($day, $time, 'section', $section->id) >= $this->maxContinuousHours) return false;

        // Protected Break Window Check
        if ($this->violatesBreakWindow($day, $time, 'teacher', $teacher->id)) return false;
        if ($this->violatesBreakWindow($day, $time, 'section', $section->id)) return false;

        return true;
    }

    /**
     * Places a class into the timetable grid data structure.
     */
    private function placeClassInGrid($day, $time, $teacher, $classroom, $classData)
    {
        $this->timetableGrid[$day][$time]['teacher'][$teacher->id] = true;
        $this->timetableGrid[$day][$time]['section'][$classData['section']->id] = true;
        $this->timetableGrid[$day][$time]['classroom'][$classroom->id] = true;

        // Store the full class data for saving later
        $this->timetableGrid[$day][$time]['data'][] = [
            'teacher_id' => $teacher->id,
            'subject_id' => $classData['subject']->id,
            'classroom_id' => $classroom->id,
            'section_id' => $classData['section']->id,
            'student_group_id' => $classData['student_group'] ? $classData['student_group']->id : null,
        ];
    }
    
    /**
     * Helper to check for max continuous classes.
     */
    private function calculateContinuousHours($day, $time, $type, $id)
    {
        $count = 0;
        $currentTimeIndex = array_search($time, $this->timeSlots);
        // Look backwards from the current time
        for ($i = $currentTimeIndex - 1; $i >= 0; $i--) {
            $prevTime = $this->timeSlots[$i];
            if (isset($this->timetableGrid[$day][$prevTime][$type][$id])) {
                $count++;
            } else {
                break; // Streak is broken
            }
        }
        return $count + 1; // +1 for the current class being considered
    }

    /**
     * Helper to check if placing a class would remove the last possible break.
     */
    private function violatesBreakWindow($day, $time, $type, $id)
    {
        // Only check if the current time is within the break window
        if (!in_array($time, $this->breakWindow)) {
            return false;
        }

        $possibleBreakSlots = count($this->breakWindow);
        $occupiedBreakSlots = 0;

        foreach ($this->breakWindow as $breakTime) {
            if (isset($this->timetableGrid[$day][$breakTime][$type][$id])) {
                $occupiedBreakSlots++;
            }
        }
        
        // If placing this class would occupy the last available break slot, it violates the rule
        return ($occupiedBreakSlots + 1) >= $possibleBreakSlots;
    }


    /**
     * Step 4: Persist the generated grid to the database.
     */
    private function saveTimetable()
    {
        $dataToInsert = [];
        foreach ($this->timetableGrid as $day => $dayData) {
            foreach ($dayData as $time => $timeData) {
                if (isset($timeData['data'])) {
                    foreach ($timeData['data'] as $classEntry) {
                        $endTime = date('H:i:s', strtotime($time . ' +1 hour'));
                        $dataToInsert[] = array_merge($classEntry, [
                            'day_of_week' => $day,
                            'start_time' => $time,
                            'end_time' => $endTime,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
        // Use a single query for massive performance improvement
        Timetable::insert($dataToInsert);
    }
}

