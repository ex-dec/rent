<!DOCTYPE html>
<html>

<head>
    <title>Laporan Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">Laporan Inventaris</div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
            <th>Jenis</th>
            <th>Ruang</th>
        </tr>
        @foreach ($inventaris as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ ucfirst($item->kondisi) }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->jenis->nama }}</td>
                <td>{{ $item->ruang->nama }}</td>
            </tr>
        @endforeach
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i:s') }}
    </div>
</body>

</html>
