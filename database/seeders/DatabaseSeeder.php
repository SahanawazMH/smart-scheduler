<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\TeacherUnavailability;
use App\Models\Timetable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Building;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Section;
use App\Models\StudentGroup;
use App\Models\Subject;
use App\Models\Teacher;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // It's good practice to disable foreign key checks while seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data to start fresh
        Timetable::truncate();
        TeacherUnavailability::truncate();
        DB::table('teacher_subjects')->truncate();
        Student::truncate();
        Teacher::truncate();
        Subject::truncate();
        StudentGroup::truncate();
        Section::truncate();
        Course::truncate();
        Classroom::truncate();
        Building::truncate();
        User::truncate();


        // -- 1. Create Buildings --
        $mainBuilding = Building::create(['name' => 'Main Academic Building', 'number' => '2']);
        $techPark = Building::create(['name' => 'Technology Park', 'number' => '3']);

        // -- 2. Create Classrooms --
        Classroom::create(['building_id' => $mainBuilding->id, 'room_number' => '101', 'capacity' => 60, 'type' => 'classroom']);
        Classroom::create(['building_id' => $mainBuilding->id, 'room_number' => '102', 'capacity' => 60, 'type' => 'classroom']);
        Classroom::create(['building_id' => $mainBuilding->id, 'room_number' => '201', 'capacity' => 40, 'type' => 'classroom']);
        Classroom::create(['building_id' => $techPark->id, 'room_number' => 'CSL-1', 'capacity' => 30, 'type' => 'lab']);
        Classroom::create(['building_id' => $techPark->id, 'room_number' => 'CSL-2', 'capacity' => 30, 'type' => 'lab']);
        Classroom::create(['building_id' => $techPark->id, 'room_number' => 'ECL-1', 'capacity' => 30, 'type' => 'lab']);

        // -- 3. Create Courses --
        $courseCS = Course::create(['name' => 'B.Tech in Computer Science', 'code' => 'CSE']);
        $courseEC = Course::create(['name' => 'B.Tech in Electronics', 'code' => 'ECE']);

        // -- 4. Create Sections --
        $sectionCSA = Section::create(['course_id' => $courseCS->id, 'name' => 'Section A']);
        $sectionECA = Section::create(['course_id' => $courseEC->id, 'name' => 'Section A']);

        // -- 5. Create Student Groups --
        StudentGroup::create(['section_id' => $sectionCSA->id, 'name' => 'P1']);
        StudentGroup::create(['section_id' => $sectionCSA->id, 'name' => 'P2']);
        StudentGroup::create(['section_id' => $sectionECA->id, 'name' => 'P1']);
        StudentGroup::create(['section_id' => $sectionECA->id, 'name' => 'P2']);

        // -- 6. Create Subjects --
        // Computer Science Subjects
        $subDS = Subject::create(['course_id' => $courseCS->id, 'name' => 'Data Structures', 'code' => 'CS101', 'weekly_hours' => 4, 'type' => 'lecture']);
        $subAlgo = Subject::create(['course_id' => $courseCS->id, 'name' => 'Algorithms', 'code' => 'CS102', 'weekly_hours' => 4, 'type' => 'lecture']);
        $subDB = Subject::create(['course_id' => $courseCS->id, 'name' => 'Database Systems', 'code' => 'CS103', 'weekly_hours' => 3, 'type' => 'lecture']);
        $subDSLab = Subject::create(['course_id' => $courseCS->id, 'name' => 'Data Structures Lab', 'code' => 'CSL101', 'weekly_hours' => 2, 'type' => 'lab']);
        // Electronics Subjects
        $subSignals = Subject::create(['course_id' => $courseEC->id, 'name' => 'Signals and Systems', 'code' => 'EC101', 'weekly_hours' => 4, 'type' => 'lecture']);
        $subNetworks = Subject::create(['course_id' => $courseEC->id, 'name' => 'Network Theory', 'code' => 'EC102', 'weekly_hours' => 4, 'type' => 'lecture']);
        $subDSP = Subject::create(['course_id' => $courseEC->id, 'name' => 'Digital Signal Processing', 'code' => 'EC103', 'weekly_hours' => 3, 'type' => 'lecture']);
        $subDSPLab = Subject::create(['course_id' => $courseEC->id, 'name' => 'DSP Lab', 'code' => 'ECL103', 'weekly_hours' => 2, 'type' => 'lab']);

        // -- 7. Create Teachers (and their User accounts) --
        $teacher1 = Teacher::create(['user_id' => User::create(['name' => 'Dr. Anjali Sharma', 'email' => 'anjali.s@example.com', 'password' => Hash::make('password'), 'role' => 'teacher'])->id]);
        $teacher2 = Teacher::create(['user_id' => User::create(['name' => 'Prof. Vikram Singh', 'email' => 'vikram.s@example.com', 'password' => Hash::make('password'), 'role' => 'teacher'])->id]);
        $teacher3 = Teacher::create(['user_id' => User::create(['name' => 'Ms. Priya Patel', 'email' => 'priya.p@example.com', 'password' => Hash::make('password'), 'role' => 'teacher'])->id]);
        $teacher4 = Teacher::create(['user_id' => User::create(['name' => 'Mr. Raj Kumar', 'email' => 'raj.k@example.com', 'password' => Hash::make('password'), 'role' => 'teacher'])->id]);
        $teacher5 = Teacher::create(['user_id' => User::create(['name' => 'Dr. Meera Iyer', 'email' => 'meera.i@example.com', 'password' => Hash::make('password'), 'role' => 'teacher'])->id]);

        // Create Admin User
        User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'admin']);

        // -- 8. Assign Subjects to Teachers --
        $teacher1->subjects()->attach([$subDS->id, $subAlgo->id, $subDSLab->id]); // Dr. Sharma teaches CS core
        $teacher2->subjects()->attach([$subDB->id, $subDSLab->id]); // Prof. Singh teaches Databases
        $teacher3->subjects()->attach([$subSignals->id, $subNetworks->id]); // Ms. Patel teaches ECE core
        $teacher4->subjects()->attach([$subDSP->id, $subDSPLab->id]); // Mr. Kumar teaches DSP
        $teacher5->subjects()->attach([$subAlgo->id, $subNetworks->id]); // Dr. Iyer can teach both CS and ECE subjects

        // -- 9. Set Teacher Unavailability --
        // Dr. Sharma is unavailable on Monday mornings
        $teacher1->unavailabilities()->create(['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00']);
        // Mr. Kumar is unavailable on Friday afternoons
        $teacher4->unavailabilities()->create(['day_of_week' => 5, 'start_time' => '13:00:00', 'end_time' => '17:00:00']);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}