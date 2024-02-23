<table>
    <tr>
        <td>Christian Baptist Church of Caniogan Calumpit</td>
    </tr>
    <tr>
        <td>Date: {{ date('M d, Y', strtotime($from)) }} - {{ date('M d, Y', strtotime($to)) }} </td>
    </tr>
    <tr>
        <td>Service: {{ $service }}</td>
    </tr>
</table>
<table>
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
            <td>{{strtoupper($t['member_name'])}}</td>
            @foreach($t['amount'] as $o)
            <td>{{ $o === null || $o === '' ? 0 : $o }}</td>
            @php
            $total = $total + $o;
            @endphp
            @endforeach
            <td class="text-bold">
                @if($t['remarks'])
                {{$t['remarks']}}
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
            <td></td>
            <td colspan="2" class="text-bold">
                <label class="text-bold text-italic text-blue">TOTAL:&nbsp;</label>
                {{ number_format($total_ministry, 2, '.', ',') }}
            </td>
            @else
            @for($x=0; $x<$ministries_count+2; $x++) <td class="text-bold">0</td>
                @endfor
                @endif
        </tr>
    </tbody>
</table>