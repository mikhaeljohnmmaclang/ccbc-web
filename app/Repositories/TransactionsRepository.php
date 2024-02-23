<?php

namespace App\Repositories;

use App\Interfaces\TransactionsRepositoryInterface;
use App\Models\Transactions;

class TransactionsRepository implements TransactionsRepositoryInterface
{
    public function getTransactions($service, $from, $to, $sort)
    {
        if ($sort == "yes") {
            $transactions =  Transactions::with(['offerings' => function ($q) {
                $q->join('ministries', 'ministries.id', 'offerings.ministry_id');
            }])
                ->selectRaw('
                        transactions.id,
                        transactions.date as date,
                        CONCAT(members.last_name, ", " , members.first_name) as member_name,
                        transactions.remarks as remarks
                ')
                ->leftjoin('members', 'members.id', 'transactions.member_id')
                ->where('transactions.service_id', $service)
                ->whereBetween('transactions.date', [$from, $to])
                ->where('transactions.status', '1')
                ->where('members.status', '1')
                ->orderby('member_name')
                ->get();
        }else{
            $transactions =  Transactions::with(['offerings' => function ($q) {
                $q->join('ministries', 'ministries.id', 'offerings.ministry_id');
            }])
                ->selectRaw('
                        transactions.id,
                        transactions.date as date,
                        CONCAT(members.last_name, ", " , members.first_name) as member_name,
                        transactions.remarks as remarks
                ')
                ->leftjoin('members', 'members.id', 'transactions.member_id')
                ->where('transactions.service_id', $service)
                ->whereBetween('transactions.date', [$from, $to])
                ->where('transactions.status', '1')
                ->where('members.status', '1')
                ->get();
        }

        return $transactions;
    }
}
