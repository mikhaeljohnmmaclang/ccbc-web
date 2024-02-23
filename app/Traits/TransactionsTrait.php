<?php

namespace App\Traits;

use App\Models\Transactions;
use Illuminate\Support\Facades\DB;
use App\Models\Offerings;
use App\Models\Ministries;

trait TransactionsTrait
{

    public function getTransactionSummary($service, $from, $to, $sort)
    {
        //check if alphabetical order is checked
        if ($sort == "yes") {
            //check if service filter == ALL
            if ($service == "ALL") {
                $transactions_data = Transactions::selectRaw('
                            transactions.id,
                            transactions.date as date,
                            CONCAT(members.last_name, ", " , members.first_name) as member_name,
                            transactions.remarks as remarks
                        ')
                    ->leftjoin('members', 'transactions.member_id', 'members.id')
                    ->whereBetween('transactions.date', [$from, $to])
                    ->where('transactions.status', '1')
                    ->where('members.status', '1')
                    ->orderBy('member_name')
                    ->get();

                $ministries = Ministries::all();

                $transactions = [];

                foreach ($transactions_data as $transaction) {
                    $transactionArray = [
                        'id' => $transaction->id,
                        'date' => $transaction->date,
                        'member_name' => $transaction->member_name,
                        'remarks' => $transaction->remarks,
                        'amount' => [],  // Initialize the 'amount' array for this transaction
                    ];

                    foreach ($ministries as $ministry) {
                        $offering = Offerings::where('transaction_id', $transaction->id)
                            ->where('ministry_id', $ministry->id)
                            ->first();

                        $transactionArray['amount'][] = $offering ? $offering->amount : 0;
                    }

                    $transactions[] = $transactionArray;
                }
            } else {
                //service has filter
                $transactions_data = Transactions::selectRaw('
                            transactions.id,
                            transactions.date as date,
                            CONCAT(members.last_name, ", " , members.first_name) as member_name,
                            transactions.remarks as remarks
                        ')
                    ->leftjoin('members', 'transactions.member_id', 'members.id')
                    ->whereBetween('transactions.date', [$from, $to])
                    ->where('transactions.service_id', $service)
                    ->where('transactions.status', '1')
                    ->where('members.status', '1')
                    ->orderBy('member_name')
                    ->get();

                $ministries = Ministries::all();

                $transactions = [];

                foreach ($transactions_data as $transaction) {
                    $transactionArray = [
                        'id' => $transaction->id,
                        'date' => $transaction->date,
                        'member_name' => $transaction->member_name,
                        'remarks' => $transaction->remarks,
                        'amount' => [],  // Initialize the 'amount' array for this transaction
                    ];

                    foreach ($ministries as $ministry) {
                        $offering = Offerings::where('transaction_id', $transaction->id)
                            ->where('ministry_id', $ministry->id)
                            ->first();

                        $transactionArray['amount'][] = $offering ? $offering->amount : 0;
                    }

                    $transactions[] = $transactionArray;
                }
            }
        } else {
            //check if service filter == ALL
            if ($service == "ALL") {
                $transactions_data = Transactions::selectRaw('
                            transactions.id,
                            transactions.date as date,
                            CONCAT(members.last_name, ", " , members.first_name) as member_name,
                            transactions.remarks as remarks
                        ')
                    ->leftjoin('members', 'transactions.member_id', 'members.id')
                    ->whereBetween('transactions.date', [$from, $to])
                    ->where('transactions.status', '1')
                    ->where('members.status', '1')
                    ->orderby('transactions.id')
                    ->get();

                $ministries = Ministries::all();

                $transactions = [];

                foreach ($transactions_data as $transaction) {
                    $transactionArray = [
                        'id' => $transaction->id,
                        'date' => $transaction->date,
                        'member_name' => $transaction->member_name,
                        'remarks' => $transaction->remarks,
                        'amount' => [],  // Initialize the 'amount' array for this transaction
                    ];

                    foreach ($ministries as $ministry) {
                        $offering = Offerings::where('transaction_id', $transaction->id)
                            ->where('ministry_id', $ministry->id)
                            ->first();

                        $transactionArray['amount'][] = $offering ? $offering->amount : 0;
                    }

                    $transactions[] = $transactionArray;
                }
            } else {
                //service has filter
                $transactions_data = Transactions::selectRaw('
                            transactions.id,
                            transactions.date as date,
                            CONCAT(members.last_name, ", " , members.first_name) as member_name,
                            transactions.remarks as remarks
                        ')
                    ->leftjoin('members', 'transactions.member_id', 'members.id')
                    ->whereBetween('transactions.date', [$from, $to])
                    ->where('transactions.service_id', $service)
                    ->where('transactions.status', '1')
                    ->where('members.status', '1')
                    ->orderby('transactions.id')
                    ->get();

                $ministries = Ministries::all();

                $transactions = [];

                foreach ($transactions_data as $transaction) {
                    $transactionArray = [
                        'id' => $transaction->id,
                        'date' => $transaction->date,
                        'member_name' => $transaction->member_name,
                        'remarks' => $transaction->remarks,
                        'amount' => [],  // Initialize the 'amount' array for this transaction
                    ];

                    foreach ($ministries as $ministry) {
                        $offering = Offerings::where('transaction_id', $transaction->id)
                            ->where('ministry_id', $ministry->id)
                            ->first();

                        $transactionArray['amount'][] = $offering ? $offering->amount : 0;
                    }

                    $transactions[] = $transactionArray;
                }
            }
        }

        return $transactions;
    }


    public function getTotalOfferings($service, $from, $to)
    {
        if ($service == "ALL") {
            $total_offerings = DB::select("
            SELECT 
                SUM(COALESCE(o.amount, 0)) AS amount
            FROM ministries AS m
            LEFT JOIN offerings AS o ON o.ministry_id = m.id
            LEFT JOIN transactions ON transactions.id = o.transaction_id
            WHERE transactions.date BETWEEN '" . $from . "' AND '" . $to . "'
                AND transactions.status = '1'
            GROUP BY m.id;
            ");
            // $total_offerings = DB::table('ministries as m')
            //     ->leftJoin('offerings as o', function ($join) use ($from, $to) {
            //         $join->on('o.ministry_id', '=', 'm.id')
            //             ->leftJoin('transactions', 'transactions.id', '=', 'o.transaction_id')
            //             ->whereBetween('transactions.date', [$from, $to])
            //             ->where('transactions.status', '1');
            //     })
            //     ->groupBy('m.id')
            //     ->selectRaw('m.id, COALESCE(SUM(o.amount), 0) as amount')
            //     ->get();

            // $total_offerings = Ministries::leftJoin('offerings', function ($join) use ($from, $to) {
            //     $join->on('ministries.id', '=', 'offerings.ministry_id')
            //         ->leftJoin('transactions', function ($join) use ($from, $to) {
            //             $join->on('transactions.id', '=', 'offerings.transaction_id')
            //                 ->whereBetween('transactions.date', [$from, $to])
            //                 ->where('transactions.status', '1');
            //         });
            // })
            //     ->groupBy('ministries.id')
            //     ->selectRaw('ministries.id, COALESCE(SUM(offerings.amount), 0) as amount')
            //     ->get();


            //  dd( $total_offerings);


        } else {
            // $total_offerings = DB::select("
            // SELECT COALESCE(offerings.total_amount, 0) AS amount
            // FROM ministries AS ministries
            // LEFT JOIN (
            // SELECT 
            // transaction_id,
            // ministry_id,
            //         SUM(amount) AS total_amount
            //     FROM offerings
            //     LEFT JOIN transactions ON transactions.`id` = offerings.`transaction_id`
            //     WHERE 
            //     transactions.service_id = '" . $service . "'
            //     AND
            //     transactions.date BETWEEN '" . $from . "' AND '" . $to . "'
            //     AND
            //     transactions.status = '1'
            // GROUP BY ministry_id
            // ) AS offerings ON offerings.ministry_id = ministries.id

            // ORDER BY ministries.id
            // ");
            $total_offerings = DB::table('ministries as m')
                ->leftJoin('offerings as o', 'o.ministry_id', '=', 'm.id')
                ->leftJoin('transactions', 'transactions.id', '=', 'o.transaction_id')
                ->whereBetween('transactions.date', [$from, $to])
                ->where('transactions.service_id', $service)
                ->where('transactions.status', '1')
                ->groupBy('m.id')
                ->selectRaw('SUM(COALESCE(o.amount, 0)) as amount')
                ->get();
        }

        return $total_offerings;
    }
}
