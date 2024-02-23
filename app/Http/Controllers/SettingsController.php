<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function settings()
    {
        return view('change_password');
    }

    //Change Password
    public function changePassword(Request $request)
    {
        try {
      
            $user_data = DB::table('users')->where('id', Auth::id())->first();
        

            if (Hash::check($request->old_password, $user_data->password)){

                updateForm('users', auth()->user()->id, [], [
                    'password'   => Hash::make($request->input('new_password')),
                    'updated_at' => date_now()
                ]);

                return myReturn('success', 'Password has been successfully updated.');
            } else {
                return myReturn('error', "Old password doesn't match");
            }
        } catch (\Throwable $th) {
            return myReturn('error', 'Failed changing password.');
        }
    }


    public function checkPassword(Request $request) {
        $password = Auth::user()->password;
        return (Hash::check($request->old_password, $password) ? 'true' : 'false');
    }
}
