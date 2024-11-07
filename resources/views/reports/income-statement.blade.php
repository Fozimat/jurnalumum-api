@if (!empty($data['income']))
    <h5>Pendapatan </h5>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nomor</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalIncome = 0;
            @endphp
            @foreach ($data['income'] as $item)
                <tr>
                    <td>{{ $item['account_code'] }}</td>
                    <td>{{ $item['account_name'] }}</td>
                    <td>{{ \App\Helpers\ResponseHelper::currency($item['total'], 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalIncome += $item['total'];
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td>Total Pendapatan</td>
                <td>{{ \App\Helpers\ResponseHelper::currency($totalIncome, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
@endif

@if (!empty($data['expense']))
    <h5>Beban </h5>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Akun</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalExpense = 0;
            @endphp
            @foreach ($data['expense'] as $item)
                <tr>
                    <td>{{ $item['account_code'] }}</td>
                    <td>{{ $item['account_name'] }}</td>
                    <td>{{ \App\Helpers\ResponseHelper::currency($item['total'], 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalExpense += $item['total'];
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td>Total Beban</td>
                <td>Rp. {{ \App\Helpers\ResponseHelper::currency($totalExpense, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
@endif
