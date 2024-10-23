<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('home');
    }

    public function products()
    {
        return view('products');
    }
    public function profilePictureUpload(Request $request)
    {
        $validated = $request->validate([
            'profile_picture' => 'file|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Find the authenticated user
        $user = User::where('id', Auth::user()->id);
        // Check if a profile picture was uploaded

        if ($request->file('profile_picture')) {
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $filename = "image-" . time() . "." . $extension;
            $path = $request->file('profile_picture')->storeAs('public/images', $filename);
            $user->update([
                'profile_picture' => $path,
            ]);
        }

        return response()->json(['success' => 'Data inserted successfully']);
    }
}
