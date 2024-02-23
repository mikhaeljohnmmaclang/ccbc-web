<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Activity_Logs;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function dashboard()
    {
        // firstfruits
        $firstfruits = DB::table("commitments")
            ->selectRaw('id,year,SUM(amount) as amount')
            ->where('name', 'firstfruit')
            ->where('year', date('Y'))
            ->first();

        // firstfruit collection
        $total_ff_collection = DB::table("transactions")
            ->selectRaw('SUM(offerings.amount) AS amount, ministries.name')
            ->leftjoin('offerings', 'offerings.transaction_id', 'transactions.id')
            ->leftjoin('ministries', 'ministries.id', 'offerings.ministry_id')
            ->where('ministries.name', 'Firstfruits')
            ->whereYear('transactions.date', date('Y'))
            ->where('transactions.status', '1')
            ->where('ministries.status', '1')
            ->first();

        // Member count
        $church_funds = DB::table("transactions")
            ->join('offerings', 'offerings.transaction_id', 'transactions.id')
            ->whereYear('transactions.date', date('Y'))
            ->sum('offerings.amount');



        if ($church_funds == null) {
            $church_funds = 0;
        }


        // Member count
        $member_count = DB::table("members")
            ->where('status', '1')
            ->count();

        return view('dashboard')
            ->with('firstfruits_year', $firstfruits->year)
            ->with('firstfruits', $firstfruits->amount)
            ->with('church_funds', number_format($church_funds))
            ->with('total_ff_collection', $total_ff_collection->amount)
            ->with('member_count', $member_count);
    }

    public function getMinistriesReport()
    {
        $ministries_report  = DB::select('
    SELECT ministries.id, ministries.name, COALESCE(offerings.total_amount, 0) AS funds, ministries.status
    FROM ministries AS ministries
    LEFT JOIN (
      SELECT ministry_id,
             SUM(amount) AS total_amount
      FROM offerings
      GROUP BY ministry_id
    )AS offerings ON offerings.ministry_id = ministries.id
    ');
        return $ministries_report;
    }

    public function getExpensesReport()
    {
        $expenses_report = DB::select('SELECT DATE_FORMAT(transactions.DATE, "%a") AS date ,COALESCE(SUM(offerings.amount),0) AS amount
        FROM   transactions
        LEFT JOIN offerings on offerings.transaction_id = transactions.id
        WHERE DATE >= DATE(NOW() - INTERVAL 7 DAY)
        GROUP BY DAY(DATE)');

        return $expenses_report;
    }


    public function getMonthlyOfferingsReport()
    {
        $monthly_offerings = DB::select("
        SELECT 
        SUM(IF(MONTH = 'Jan', total, 0)) AS 'Jan',
        SUM(IF(MONTH = 'Feb', total, 0)) AS 'Feb',
        SUM(IF(MONTH = 'Mar', total, 0)) AS 'Mar',
        SUM(IF(MONTH = 'Apr', total, 0)) AS 'Apr',
        SUM(IF(MONTH = 'May', total, 0)) AS 'May',
        SUM(IF(MONTH = 'Jun', total, 0)) AS 'Jun',
        SUM(IF(MONTH = 'Jul', total, 0)) AS 'Jul',
        SUM(IF(MONTH = 'Aug', total, 0)) AS 'Aug',
        SUM(IF(MONTH = 'Sep', total, 0)) AS 'Sep',
        SUM(IF(MONTH = 'Oct', total, 0)) AS 'Oct',
        SUM(IF(MONTH = 'Nov', total, 0)) AS 'Nov',
        SUM(IF(MONTH = 'Dec', total, 0)) AS 'Dec'
        FROM (
    SELECT DATE_FORMAT(t.date , '%b') AS MONTH, SUM(offerings.`amount`) AS total
    FROM offerings
         LEFT JOIN transactions AS t ON t.id = offerings.`transaction_id`
    WHERE t.date <= NOW() AND t.date  >= DATE_ADD(NOW(),INTERVAL - 12 MONTH)
    GROUP BY DATE_FORMAT(t.date , '%m-%Y')) AS sub");

        return $monthly_offerings;
    }

    public function getActivityLogs()
    {
        $startDate = Carbon::now()->subDays(7)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $logs = Activity_Logs::selectRaw("admin_name, description, status, DATE_FORMAT(created_at, '%b %d, %Y %h:%i %p') AS date, created_at")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        return json_encode($logs);
    }
}
