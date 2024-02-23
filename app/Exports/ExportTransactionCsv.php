<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Ministries;
use App\Models\Services;
use App\Traits\TransactionsTrait;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ExportTransactionCsv implements FromView, WithStyles
{
    use TransactionsTrait;
    protected $date, $service, $sort;

    function __construct($date, $service, $sort)
    {
        $this->date = $date;
        $this->sort = $sort;
        $this->service = $service;
    }

    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //         '.text-bold' => ['font' => ['bold' => true]],
    //     ];
    // }



    public function view(): View
    {
        //get dates
        $date_replaced = strtr($this->date, '-', '/');
        $from = date("Y-m-d", strtotime(substr($date_replaced, 0, 10)));
        $to =   date("Y-m-d", strtotime(substr($date_replaced, 14, 23)));

        //get ministries
        $ministries = Ministries::all();


        //get services
        $service_name = "";

        if ($this->service == "ALL") {
            $service_name = "ALL SERVICES";
        } else {
            $service_info = Services::select('name')->where('id', $this->service)->first();
            $service_name =  $service_info->name;
        }

        //get transactions
        $transactions = $this->getTransactionSummary($this->service, $from, $to, $this->sort);

        //get total transactions of ministries
        $total_offerings = $this->getTotalOfferings($this->service, $from, $to);

        try {
            //check if has transactions
            if (count($transactions) > 0) {
                return view('exports.export_transaction_summary_csv', [
                    'transactions' =>  $transactions,
                    'ministries' => $ministries,
                    'service' =>  $service_name,
                    'from' =>  $from,
                    'to' =>  $to,
                    'total_offerings' =>  $total_offerings,
                    'ministries_count' =>  $ministries->count()
                ]);
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


    public function styles(Worksheet $sheet)
    {
        // Set the column widths
        foreach (range('A', 'Z') as $column) {
            if ($column != 'A') {
                $sheet->getColumnDimension($column)->setWidth(14);
            } else {
                $sheet->getColumnDimension($column)->setWidth(50);
            }
        }

        // Set the horizontal alignment of all cells to left
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('1:1')->getFont()->setBold(true);
        $sheet->getStyle('5:5')->getFont()->setBold(true);
    }
}
