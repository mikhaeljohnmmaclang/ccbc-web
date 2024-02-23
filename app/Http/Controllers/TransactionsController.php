<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Offerings;
use PDF;
use App\Models\Ministries;
use App\Models\Services;
use App\Traits\TransactionsTrait;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTransactionCsv;


class TransactionsController extends Controller
{

    use TransactionsTrait;

    //transactions
    public function transactions()
    {
        $ministries = DB::table('ministries')->where('status', '1')
            ->orderBy('id')
            ->get();

        $services = DB::table('services')->where('status', '1')
            ->get();

        return view('transactions')
            ->with('services', $services)
            ->with('ministries', $ministries)
            ->with('msg', '');
    }

    public function exportTransaction($id)
    {
        $transactions =  Transactions::with(['offerings' => function ($q) {
            $q->leftjoin('ministries', 'ministries.id', 'offerings.ministry_id');
        }])
            ->selectRaw('
                transactions.id,
                transactions.date as date,
                CONCAT(members.first_name, " " , members.last_name)  as member_name
        ')
            ->leftjoin('members', 'members.id', 'transactions.member_id')
            ->where('transactions.id', $id)
            ->where('transactions.status', '1')
            ->first();


        $pdf = PDF::loadView('exports.export_transactions', array('transactions' =>  $transactions))
            ->setPaper('a4', 'portrait');

        return $pdf->stream(date('F-d-Y') . "-Transaction-" . $transactions->id . "-" . $transactions->member_name . ".pdf");
    }


    public function generateSummaryReports($date, $service, $sort)
    {

        //get dates
        $date_replaced = strtr($date, '-', '/');
        $from = date("Y-m-d", strtotime(substr($date_replaced, 0, 10)));
        $to =   date("Y-m-d", strtotime(substr($date_replaced, 14, 23)));

        //get ministries
        $ministries = Ministries::all();


        //get services
        $service_name = "";

        if ($service == "ALL") {
            $service_name = "ALL SERVICES";
        } else {
            $service_info = Services::select('name')->where('id', $service)->first();
            $service_name =  $service_info->name;
        }

        //get transactions
        $transactions = $this->getTransactionSummary($service, $from, $to, $sort);

        //get total transactions of ministries
        $total_offerings = $this->getTotalOfferings($service, $from, $to);

        try {
            //check if has transactions
            if (count($transactions) > 0) {
                $pdf = PDF::loadView(
                    'exports.export_transaction_summary',
                    array(
                        'transactions' =>  $transactions,
                        'ministries' => $ministries,
                        'service' =>  $service_name,
                        'from' =>  $from,
                        'to' =>  $to,
                        'total_offerings' =>  $total_offerings,
                        'ministries_count' =>  $ministries->count()
                    )
                )
                    ->setPaper('a4', 'landscape');

                // return $pdf->stream(date('F-d-Y') . "-CBCTransactions-". $transactions->date . ".pdf");
                return $pdf->stream();
            } else {
                $ministries = DB::table('ministries')->where('status', '1')
                    ->orderByDesc('id')
                    ->get();

                $services = DB::table('services')->where('status', '1')
                    ->get();

                return view('transactions')
                    ->with('services', $services)
                    ->with('ministries', $ministries)
                    ->with('msg', 'No Data Fetch, Please Try Again');
            }
        } catch (\Throwable $error) {
            $ministries = DB::table('ministries')->where('status', '1')
                ->orderByDesc('id')
                ->get();

            $services = DB::table('services')->where('status', '1')
                ->get();

            return view('transactions')
                ->with('services', $services)
                ->with('ministries', $ministries)
                ->with('msg', 'No Data Fetch, Please Try Again');
        }
    }



    public function export_users_from_view($date, $service, $sort)
    {

        $service_name = "";

        if ($service == "ALL") {
            $service_name = "All_Service";
        } else {
            $data = Services::select('name')->where('id', $service)->where('status', '1')->first();
            if ($data) {
                $service_name = $data->name;
            } else {
                $service_name = "Undefined";
            }
        }

        //get dates
        $date_replaced = strtr($date, '-', '/');
        $from = date("Y-m-d", strtotime(substr($date_replaced, 0, 10)));
        $to =   date("Y-m-d", strtotime(substr($date_replaced, 14, 23)));

        $transactions = $this->getTransactionSummary($service, $from, $to, $sort);

        if (count($transactions) > 0) {
            return Excel::download(new ExportTransactionCsv($date, $service, $sort), 'CBCC_Collection_Reports-' . $service_name . '-' . $date . '.xlsx');
        } else {
            $ministries = DB::table('ministries')->where('status', '1')
                ->orderByDesc('id')
                ->get();

            $services = DB::table('services')->where('status', '1')
                ->get();

            return view('transactions')
                ->with('services', $services)
                ->with('ministries', $ministries)
                ->with('msg', 'No Data Fetch, Please Try Again');
        }
    }


    // Get list of transactions
    public function getTransactions()
    {
        $query =  Transactions::selectRaw('
         transactions.id,
         transactions.date as transaction_date,
         DATE_FORMAT(transactions.date,"%M %e, %Y") as formatted_transaction_date,
         CONCAT(members.last_name  , ", "  ,members.first_name  ) as member_name,
         services.id as service_id,
         services.name as service_name,
         transactions.remarks as remarks,
         transactions.status
         ')
            ->leftjoin('members', 'members.id', 'transactions.member_id')
            ->leftjoin('services', 'services.id', 'transactions.service_id')
            ->whereYear('transactions.date', DATE('Y'))
            ->where('transactions.status', '1')
            ->groupby('transactions.id')
            ->orderByDesc('transactions.id')
            ->get();

        return DataTables::of($query)->make(true);
    }

    public function getTransactionOfferings($id)
    {
        $query =  Transactions::with(['offerings' => function ($q) {
            $q->leftjoin('ministries', 'ministries.id', 'offerings.ministry_id');
        }])
            ->where('transactions.id', $id)
            ->where('transactions.status', '1')
            ->first();
        return json_encode($query);
    }

    public function editTransaction(Request $request)
    {
        DB::beginTransaction();

        Offerings::where('transaction_id', $request->transaction_id)->delete();
        Transactions::where('id', $request->transaction_id)->update([
            'service_id' => $request->service,
            'remarks' => $request->remarks,
            'date' => $request->date,
        ]);

        $ministries = DB::table('ministries')->where('status', '1')->count();

        for ($x = 0; $x < $ministries; $x++) {
            if ($request->amount[$x] >= 0) {
                $o = new Offerings();
                $o->transaction_id = $request->transaction_id;
                $o->ministry_id = $request->m_id[$x];
                $o->amount = $request->amount[$x];
                $o->save();

                // if ($request->amount[$x] > 0) {
                //     //Add Logs 
                //     $logs = new Activity_Logs();
                //     $logs->user_id = Auth::user()->id;
                //     $logs->description = 
                //         "Edited Transaction No" + $request->transaction_id +
                //         "&#8369; " . number_format($request->amount[$x]) .
                //         " to " . $ministry->name .
                //         " for " . $member->first_name . " " . $member->last_name .
                //         " at " . $service->name;
                //     $logs->save();
                // }
            }

            $ministry = Ministries::select('funds')->where('id', $request->m_id[$x])->first();

            //subtract the existing amount
            $subtracted_amount = $ministry->funds - $request->ref_amount[$x];

            //add the new amount
            $new_balance = $subtracted_amount + $request->amount[$x];

            //save new balance
            Ministries::where('id', $request->m_id[$x])
                ->update([
                    'funds' => $new_balance,
                ]);
                
        }

        DB::commit();

        return myReturn('success', 'Transaction Successfully Updated!');
    }
}
