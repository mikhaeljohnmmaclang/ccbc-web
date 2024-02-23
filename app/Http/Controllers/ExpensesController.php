<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Expenses;
use App\Models\Ministries;

class ExpensesController extends Controller
{
  //
  //expenses
  public function expenses()
  {
    $ministries = DB::table('ministries')
      ->where('status', '1')
      ->orderBy('id')
      ->get();
    return view('expenses')->with('ministries', $ministries);
  }

  // Get list of expenses
  public function getExpenses()
  {
    $query = DB::table('expenses as e')
      ->selectRaw("
         e.id,
         e.voucher_number, 
         m.name as ministry_name, 
         e.name, 
         IFNULL(e.descriptions,'N/A') as descriptions, 
         DATE_FORMAT(e.date, '%M %e, %Y') as expense_date, 
         e.date as date, 
         e.amount, 
         e.status, 
         users.name as recorded_by")
      ->join('users', 'users.id', 'e.recorded_by')
      ->join('ministries as m', 'm.id', 'e.ministry_id')
      ->where('e.status', '1')
      ->get();
    return DataTables::of($query)->make(true);
  }

  public function addExpense(Request $request)
  {

    DB::beginTransaction();

    $e = new Expenses;
    $e->voucher_number = $request->voucher_number;
    $e->ministry_id = $request->ministries;
    $e->name = $request->name;
    $e->descriptions = $request->descriptions;
    $e->amount = $request->amount;
    $e->recorded_by = $request->recorded_by;
    $e->date = date('Y-m-d');
    $e->status = '1';
    $e->save();

    $ministry = Ministries::where('id',$request->ministries)->first();
    if($ministry->funds >= $request->amount){

      $new_balance = $ministry->funds - $request->amount;
      Ministries::where('id',$request->ministries)->update([
        'funds' => $new_balance,
      ]);

    }else{
      return myReturn('error', 'Insufficient Funds! '.$ministry->name.' Ministry have only &#8369; '.number_format($ministry->funds, 2, '.', ',').' left.');
    }
 
    DB::commit();

    return myReturn('success', '&#8369; '.number_format($request->amount, 2, '.', ',').' successfully deducted from '.$ministry->name.' ministry');
  }
}
