<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman</title>
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

        .sub-header {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
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
    <div class="header">Laporan Peminjaman Inventaris</div>
    <div class="sub-header">Periode: {{ request()->input('start_date', '-') }} - {{ request()->input('end_date', '-') }}
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Tanggal Pinjam</th>
            <th>Status</th>
        </tr>
        @foreach ($peminjaman as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ ucfirst($item->status_peminjaman) }}</td>
            </tr>
        @endforeach
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i:s') }}
    </div>
</body>

</html>
