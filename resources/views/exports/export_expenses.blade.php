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
            border-collapse: collapse;
            border: 1px solid #000;
        }


        .tbl-contents th {
            font-size: 11px;
            padding: 10px;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid black;
        }

        .tbl-contents td {
            font-size: 11px !important;
            padding: 10px;
            vertical-align: top;
        }

        .tbl-contents td+td {
            border-left: 1px solid black;
        }

        .tbl-col-1 {
            width: 2%;
        }

        .tbl-col-2 {
            width: 20%;
        }

        .tbl-col-3 {
            width: 10%;
        }

        .signatures label {
            font-size: 13px;
        }

        .signatures .heading {
            margin-bottom: 30px;
            font-style: italic;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-red {
            color: red !important;
        }

        .top-table label {
            font-size: 14px !important;
        }
    </style>

</head>

<body>



    <div style="position: relative; margin: 0 auto; width: 100%; font-family: sans-serif">
        <div style="position: relative; text-align:center; width: 100%; margin: 0 auto;">
            <img style="display:inline-block; margin-left: 0px; margin-right: 5px;" src="{{ public_path('images/logo.png') }}" width="4%" alt="">
            <div style="display:inline-block; margin-bottom: 7px;">
                <label style="font-size: 16px; font-weight:800;">CHRISTIAN BAPTIST CHURCH OF CANIOGAN CALUMPIT</span></label>
            </div>
            <div style="display:block; text-align:center; margin-top: -10px;">
                <label style="font-size: 10px; line-height: 1px; font-weight:bold;">McArthur Highway, Caniogan, Calumpit, Bulacan, Philippines, 3003</label> <br>
                <label style="font-size: 11px; line-height: 1px; margin-top: -5px;">TEL.NO.: 0933 864 2461 </label>
            </div>
        </div>
        <div style="position: relative; width: 100%; text-align: center; margin-top: 30px;">
            <label style="font-size: 17px; font-family:Sans serif; font-weight: 900; text-decoration: underline;">TRANSACTION DETAILS</label>
        </div>

        <table class="top-table" style="margin:5px 0 0 0; border:none; width: 100% !important; margin-top: 30px;">
            <tbody>
                <tr>
                    <td>
                        <div style="text-align:left;">
                            <div style="display:inline; width: 140px !important;">
                                <label class="text-bold">Transaction No: &nbsp;</label>
                            </div>
                            <div style="display:inline;  width: 100px !important;">
                                <label class="text-red"> {{ $transactions->id }}</label>
                            </div>
                        </div>
                        <div style="text-align:left;">
                            <div style="display:inline;  width: 100px !important;">
                                <label class="text-bold">Name: &nbsp;</label>
                            </div>
                            <div style="display:inline;  width: 100px !important;">
                                <label> {{ $transactions->member_name }}</label>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 0">
                        <div style="text-align:left; ; padding: 3px; margin-left: 300px; margin-top: 15px;">
                            <label class="text-bold">Date: &nbsp;</label>
                            <label> {{ date('F j, Y', strtotime($transactions->date)) }}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- table 2 -->
        <table class="tbl-contents" style="position: relative; margin: 10px 0 0 0 !important; border: 1px solid black !important; font-size: 9px;">
            <thead>
                <tr>
                    <th class="tbl-col-1">No</th>
                    <th class="tbl-col-2">Expenses</th>
                    <th class="tbl-col-3">Amount</th>
                </tr>
            </thead>
            <tbody style="height: 700px;">
                <tr>
                    @php
                    $x = 1;
                    $total = 0;
                    @endphp
                    <td>
                        @foreach ($transactions->offerings as $offerings)
                        <div style="padding: 8px;  text-align:center">
                            <label style="font-size: 13px">{{ $x }} </label>
                        </div>
                        @php
                        $x++;
                        @endphp
                        @endforeach
                    </td>
                    <td style="height: 500px;">
                        @foreach($transactions->offerings as $offerings)
                        <div style="padding: 8px;  text-align:center">
                            <label style="font-size: 13px"> {{ $offerings->name }} </label>
                        </div>
                        @endforeach

                        <div style="text-align:center; margin-top: 30px;">
                            <label style="font-size: 13px;">**** NOTHING FOLLOWS ****</label> <br>
                        </div>

                    </td>
                    <td>
                        @foreach($transactions->offerings as $offerings)
                        <div style="padding: 8px; text-align:center">
                            <label style="font-size: 13px">{{ number_format($offerings->amount, 2, '.', ',') }} </label>
                        </div>
                        @php
                        $total = $total + ($offerings->amount);
                        @endphp
                        @endforeach

                        <div style="position: relative; text-align:left; margin-top: 80px; font-size: 14px;">
                            <label style="font-weight: 900">TOTAL: Php {{ number_format($total, 2, '.', ',') }} </label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>


        <div class="signatures" style="text-align:center; margin-top: 30px;">
            <div style="position: relative; float:left; width: 33.33%;">
                <div style="text-align: left; margin: 0 30px;">
                    <label class="text-bold heading">Authorized By:</label><br>
                </div>
                <div style="border-top: 1px solid black; margin: 60px 30px;">
                    <label>Ms. Grace Lingo</label>
                </div>
            </div>
            <div style="position: relative;  float:left; width: 33.33%;">
                <div style="text-align: left; margin: 0 30px;">
                    <label class="text-bold heading">&nbsp;</label><br>
                </div>
                <div style="border-top: 1px solid black; margin: 60px 30px;">
                    <label>Ms. Malou Espiritu</label>
                </div>
            </div>
            <div style="position: relative; float:left; width: 33.33%;">
                <div style="text-align: left; margin: 0 30px;">
                    <label class="text-bold heading">&nbsp;</label><br>
                </div>
                <div style="border-top: 1px solid black; margin: 60px 30px;">
                    <label>Rev. Kenneth Lagman</label>
                </div>

            </div>
        </div>

    </div>


</body>

</html>