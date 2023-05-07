<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Penjualan</title>
</head>

<body>
    <div style="text-align: center;">
        <font size="5"><b>LAPORAN DATA PENJUALAN</b></font><br>
    </div>

    <br>
    <div class="w-50 float-left mt-10">
    </div>
    <div style="clear: both;"></div>
    <br>
    <table border="1" cellspacing="0" width="100%">
        <thead style="background-color: #f5b2bb; text-align: center;">
            <tr>
                <th>No</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th>Profit</th>

                @php
                    // $total_akhir = 0;
                    $no = 1;
                @endphp
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $t)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $t->jenis_barang }}</td>
                    <td>{{ $t->nama }}</td>
                    <td>@currency($t->harga_beli)</td>
                    <td>@currency($t->harga_jual)</td>
                    <td>@currency($t->harga_jual - $t->harga_beli)</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
