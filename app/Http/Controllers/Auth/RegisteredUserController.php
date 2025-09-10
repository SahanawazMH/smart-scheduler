<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('register');
    }
    // public function volunteerRegister(): View
    // {
    //     return view('volunteer-register');
    // }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'digits_between:8,15', 'unique:users,phone'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5048'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        if ($request->file('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));

            $img->toPng()->save(public_path('upload/profile/' . $name_gen));
            $save_url = 'upload/profile/' . $name_gen;

            $user->update([
                'image' => $save_url,
            ]);
        }


        Membership::create([
            'user_id' => $user->id,

        ]);

        event(new Registered($user));

        Auth::login($user);

        $userRole = $user->role;

        $notification = [
            'message' => 'Registration Successful',
            'alert-type' => 'success',
        ];

        return redirect("/{$userRole}/dashboard")->with($notification);
    }
    // public function volunteerStore(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //         'address' => ['required', 'string', 'max:255'],
    //         'phone' => ['required', 'numeric', 'digits_between:8,15'],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role' => 'member',
    //         'address' => $request->address,
    //         'phone' => $request->phone,
    //     ]);

    //     Membership::create([
    //         'user_id' => $user->id,
    //     ]);

    //     event(new Registered($user));



    //     Auth::login($user);

    //     $userRole = $user->role;

    //     return redirect("/{$userRole}/dashboard");
    // }
}
