<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Gross Sales</th>
                <th>Net Sales</th>
                <th>Net Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $date => $totalSales)
                <tr>
                    <td>{{ $date }}</td>
                    <td>{{ $dailyTotalSales[$date] }}</td>
                    <td>{{ $dailySubTotalSales[$date] }}</td>
                    <td>{{ $dailyTotalSales[$date] - $dailySubTotalSales[$date] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Gross Sales: {{ $gross_sales }}</p>
    <p>Net Sales: {{ $net_sales }}</p>
</body>
</html>
