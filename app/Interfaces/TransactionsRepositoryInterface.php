<?php
namespace App\Interfaces;

interface TransactionsRepositoryInterface
{
    public function getTransactions($service, $from, $to, $sort);
}
