<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <title>Account Summary Statement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary p {
            margin: 5px 0;
        }

        .transactions {
            margin-top: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <h1>Account Summary Statement - {{ strtoupper($account->name . ' (' . $account->accountLocation->name . ')') }}</h1>
    <div class="summary">
        <p><strong>Currency:</strong> Ghana Cedi (GHS)</p>
        <p><strong>Total Credit:</strong> GHS {{ number_format($totalCredit, 2) }}</p>
        <p><strong>Total Debit:</strong> GHS {{ number_format($totalDebit, 2) }}</p>
        {{-- <p><strong>Uncleared Effects:</strong> GHS 0.00</p> --}}
    </div>
    <div class="transactions">
        <h2>Transaction Details
            ({{ now()->parse($startDate)->format('M d, Y') }} -
            {{ now()->parse($endDate)->format('M d, Y') }})</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Value Date</th>
                    <th>Debit (GHS)</th>
                    <th>Credit (GHS)</th>
                    <th>Balance (GHS)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $balance = 0;
                @endphp
                @forelse ($statements as $statement)
                    @php
                        if ($statement->entry_type_id == 'debit') {
                            // Assuming entry_type_id 2 is for debits
                            $balance -= $statement->amount;
                            $debit = $statement->amount;
                            $credit = '';
                        } else {
                            $balance += $statement->amount;
                            $debit = '';
                            $credit = $statement->amount;
                        }
                    @endphp
                    <tr>
                        <td>{{ $statement->date->format('d-M-Y') }}</td>
                        <td>{{ $statement->description }}</td>
                        <td>{{ $statement->value_date->format('d-M-Y') }}</td>
                        <td>
                            @if ($statement->entryType->type === 'debit')
                                {{ $statement->amount }}
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            @if ($statement->entryType->type === 'credit')
                                {{ $statement->amount }}
                            @else
                                --
                            @endif
                        </td>
                        <td>{{ number_format($balance, 2) }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="footer">
        Generated on: {{ date('Y-m-d H:i:s') }}
    </div>
    <div class="page-break"></div>
</body>

</html>
