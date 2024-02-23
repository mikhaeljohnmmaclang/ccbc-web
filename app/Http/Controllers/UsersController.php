<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //users
    public function users(){
        return view('users');
    }

     // Get list of users
     public function getUsers()
     {
         $query = DB::table('users')
         ->where('role','!=','Admin')
         ->where('status','1')
         ->get();
         return DataTables::of($query)->make(true);
     }

      // Add User
    public function addUser(Request $request)
    {
        try {
            $data = [
                'status'     => '1',
                'password'   => Hash::make('123456'),
                'created_at' => date_now()
            ];
            insertForm('users', $request->all(), $data);

            return myReturn('success', 'User has been successfully created.');
        } catch (\Throwable $th) {
            dd($th);
            return myReturn('error', 'Failed creating user.');
        }
        $query = DB::table('users');
    }


      // Reset Password
    public function resetPassword(Request $request)
    {
        try {
            $id   = $request->id;
            if (!empty($id)) {
                updateData('users', $id, ['password' => Hash::make('123456'), 'updated_at' => date('Y-m-d H:i:s')]);
                return myReturn('success', 'Password has been successfully reset.');
            }
        } catch (\Throwable $th) {
            dd($th);
            return myReturn('error', 'Failed resetting password.');
        }
    }

    // Check Unique Email
    public function checkUniqueEmail(Request $request) {
        $count = DB::table('users')
                    ->where('email', $request->email)
                    ->where('status','1')
                    ->count();

        return ($count == 0) ? 'true' : 'false';
    }
    
    // Check Unique Email - Edit
    public function checkUniqueEmailEdit(Request $request) {
        $count = DB::table('users')
                    ->where('id', '!=', $request->id)
                    ->where('email', $request->email)
                    ->where('status','1')
                    ->count();

        return ($count == 0) ? 'true' : 'false';
    }
}
