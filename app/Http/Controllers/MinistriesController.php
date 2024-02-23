<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Ministries;

class MinistriesController extends Controller
{
    //ministries
    public function ministries(){
        return view('ministries');
    }

     // Get list of ministries
     public function getMinistries()
     {

        //  $query = DB::select('
        //  SELECT ministries.id, ministries.name, COALESCE(offerings.total_amount, 0) AS funds, ministries.status
        //  FROM ministries AS ministries
        //  LEFT JOIN (
        //    SELECT ministry_id,
        //           SUM(amount) AS total_amount
        //    FROM offerings
        //    GROUP BY ministry_id
        //  )AS offerings ON offerings.ministry_id = ministries.id
        //  ORDER BY ID asc
        //  ');

        $query = Ministries::where('status','1')->get();
         
         return DataTables::of($query)->make(true);
     }

}
