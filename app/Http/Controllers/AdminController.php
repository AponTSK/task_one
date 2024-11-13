<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.dashboard', compact('categories', 'brands'));
    }

    public function changePass()
    {
        return view('admin.auth.changepassword');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->current_password, $user->password))
        {
            return back()->withErrors(['current_password' => 'The current password does not match.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password updated successfully!');
    }
}
