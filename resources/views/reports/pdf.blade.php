<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports PDF</title>
    <style>
        /* Basic styling for PDF */
        body {
            font-family: "DejaVu Sans", sans-serif;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #808080;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 18px;
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            color: #333;
        }

        .total-row td {
            font-weight: bold;
        }

        .chart-placeholder {
            width: 100%;
            height: 200px;
            background-color: #f5f5f5;
            text-align: center;
            line-height: 200px;
            color: #aaa;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Finance Reports</h1>
        <p>Period: {{ $period }}</p>
        <p>Date: {{ $date }}</p>
    </div>

    <!-- Task Summary -->
    <div class="section">
        <h2>Task Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Completed</th>
                    <th>Pending</th>
                    <th>Overdue</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $completedCount }}</td>
                    <td>{{ $pendingCount }}</td>
                    <td>{{ $overdueCount }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Task Distribution -->
    <div class="section">
        <h2>Task Distribution by Label</h2>
        @if(count($taskLabels) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Task Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taskLabels as $index => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td>{{ $taskCounts[$index] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No data available for the selected period.</p>
        @endif
    </div>

    <!-- Expense Summary -->
    <div class="section">
        <h2>Expense Summary</h2>
        @if(count($expenseSummary) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Expense Type</th>
                        <th>Amount Spent</th>
                        <th>Percentage of Category Budget</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenseSummary as $item)
                        <tr>
                            <td>{{ $item['category'] }}</td>
                            <td>${{ number_format($item['amount_spent'], 2) }}</td>
                            <td>
                                @if($item['percentage_of_budget'] > 100)
                                    <span style="color: red;">{{ number_format($item['percentage_of_budget'], 2) }}%</span>
                                @else
                                    <span style="color: green;">{{ number_format($item['percentage_of_budget'], 2) }}%</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total Budget:</strong> ${{ number_format($totalBudget, 2) }}</p>
            <p><strong>Total Spent:</strong> ${{ number_format($totalSpent, 2) }}</p>
        @else
            <p>No expenses found for the selected period.</p>
        @endif
    </div>

    <!-- Income Overview -->
    <div class="section">
        <h2>Income Overview</h2>
        @if(count($incomeSummary) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Income Source</th>
                        <th>Amount Received</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomeSummary as $item)
                        <tr>
                            <td>{{ $item['source_name'] }}</td>
                            <td>${{ number_format($item['amount_received'], 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total Income</td>
                        <td>${{ number_format($totalIncome, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p>No income records found for the selected period.</p>
        @endif
    </div>

    <!-- Budget Progress Report -->
    <div class="section">
        <h2>Budget Progress Report</h2>
        @if(count($budgetProgress) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Budget Category</th>
                        <th>Allocated Budget</th>
                        <th>Amount Spent</th>
                        <th>Remaining Budget</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($budgetProgress as $item)
                        <tr>
                            <td>{{ $item['category'] }}</td>
                            <td>${{ number_format($item['allocated_budget'], 2) }}</td>
                            <td>${{ number_format($item['amount_spent'], 2) }}</td>
                            <td>
                                @if($item['remaining_budget'] <= 0)
                                    <span style="color: red;">${{ number_format($item['remaining_budget'], 2) }}</span>
                                @else
                                    <span style="color: green;">${{ number_format($item['remaining_budget'], 2) }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No budget records found for the selected period.</p>
        @endif
    </div>
</body>
</html>
