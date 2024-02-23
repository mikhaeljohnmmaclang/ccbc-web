<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details</title>
    <link rel="stylesheet" href="{{ public_path().'/vendor/bootstrap/bootstrap.min.css' }}">
    <script src="{{ public_path().'/vendor/bootstrap/jquery-3.3.1.slim.min.js' }}"></script>
    <script src="{{ public_path().'/vendor/bootstrap/bootstrap.min.js' }}"></script>

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
        }

        .tbl-contents {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }


        .tbl-contents th {
            font-size: 11px;
            padding: 1px 4px;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid black;
        }

        .tbl-contents td {
            font-size: 11px !important;
            padding: 2px 4px;
            vertical-align: top;
            border: 1px solid black;
        }

        .sub-title {
            font-family: 'Courier New', Courier, monospace;
            font-size: 15px;
            line-height: 1px !important;
            text-align: left;
        }

        .d-inline {
            display: inline;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right !important;
        }
        .text-left {
            text-align: left !important;
        }

        .text-italic {
            font-style: italic !important;
        }

        .text-red {
            color: red !important;
        }

        .text-blue {
            color: #04194D;
        }

        .tbl-col-1 {
            width: 33% !important;
        }

        .tbl-col-2 {
            width: 4% !important;
            font-size: 5px;
        }

        .tbl-col-3 {
            width: 20% !important;
            font-size: 5px;
        }
    </style>

</head>

<body>



    <div style="position: relative; margin: 0 auto; width: 100%; font-family: sans-serif">
        <div>
            <label class="text-bold">CHRISTIAN BAPTIST CHURCH OF CANIOGAN CALUMPIT</label><br>
            <label class="sub-title">Transaction Report</label>
        </div>
        <div style="position:relative; left: 650px; top: -30; text-align:left;">
            <label class="sub-title">
                Date:
                @if($from == $to)
                {{ date('F d, Y', strtotime($from)) }}
                @else
                {{ date('M d, Y', strtotime($from)) }} - {{ date('M d, Y', strtotime($to)) }}
                @endif
            </label><br>
            <label class="sub-title">Filter: {{ $service }}</label>
        </div>


        <!-- table 2 -->
        <table class="tbl-contents" style="position: relative; margin: -30px 0 0 0 !important; border: 1px solid black !important; font-size: 9px;">
            <thead>
                <tr>
                    <th class="tbl-col-1 text-left">Name</th>
                    @foreach($ministries as $m)
                    <th class="tbl-col-2">{{ $m->name}}</th>
                    @endforeach
                    <th class="tbl-col-2">Remarks</th>
                    <th class="tbl-col-3 text-italic">Total</th>
                </tr>
            </thead>
            <tbody style="height: 700px;">
                @php
                $total = 0;
                $total_ministry = 0;
                @endphp
                @foreach($transactions as $t)
                <tr>
                    <td>{{strtoupper($t->member_name)}}</td>
                    @foreach($t->offerings as $o)
                    <td>{{$o->amount}}</td>
                    @php
                    $total = $total + $o->amount;
                    @endphp
                    @endforeach
                    <td class="text-bold">
                        @if($t->remarks)
                        {{$t->remarks}}
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="text-bold">{{number_format($total, 2, '.', ',')}}</td>
                    <!-- reset total member offering computation -->
                    @php
                    $total = 0;
                    @endphp
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    @if(!$total_offerings == null)
                    @foreach($total_offerings as $m_total)
                    <td class="text-bold">{{ number_format($m_total->amount, 2, '.', ',') }}</td>
                    @php
                    $total_ministry = $total_ministry + $m_total->amount;
                    @endphp
                    @endforeach
                    <td colspan="2" class="text-bold">
                        <label class="text-bold text-italic text-blue">TOTAL: </label> 
                        {{ number_format($total_ministry, 2, '.', ',') }}</td>
                    @else
                        @for($x=0; $x<$ministries_count+2; $x++)
                        <td class="text-bold">0</td>
                        @endfor
                    @endif
                </tr>
            </tbody>
        </table>



    </div>


</body>

</html>