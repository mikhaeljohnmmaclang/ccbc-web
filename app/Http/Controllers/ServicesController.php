<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServicesController extends Controller
{
    //services
    public function services(){
        return view('services');
    }

     // Get list of services
     public function getServices()
     {
         $query = DB::table('services')->where('status','1')->get();
         return DataTables::of($query)->make(true);
     }

      // Check Unique Name
    public function checkUniqueServiceName(Request $request)
    {
        $count = DB::table('services')
            ->where('name', $request->name)
            ->where('status', '1')
            ->count();

        return ($count == 0) ? 'true' : 'false';
    }

    // Check Unique Name - Edit
    public function checkUniqueServiceNameEdit(Request $request)
    {
        $count = DB::table('services')
            ->where('id', '!=', $request->id)
            ->where('name', $request->name)
            ->where('status', '1')
            ->count();

        return ($count == 0) ? 'true' : 'false';
    }
}
