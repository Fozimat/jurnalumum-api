@if (!empty($data['pendapatan']))
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
            @foreach ($data['pendapatan'] as $item)
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

@if (!empty($data['beban']))
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
            @foreach ($data['beban'] as $item)
                <tr>
                    <td>{{ $item['kode_akun'] }}</td>
                    <td>{{ $item['nama_akun'] }}</td>
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
