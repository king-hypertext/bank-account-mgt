<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Custom PDF</title>
    <style>
        /* Custom CSS */
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
        }

        .content {
            margin: 30px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
    </div>

    <div class="content">
        <p>Hello, {{ $name }}!</p>
        <p>This is a dynamically generated PDF.</p>
        <table border="1" cellpadding="10">
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
            @foreach ($data as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="footer">
        Generated on: {{ date('Y-m-d H:i:s') }}
    </div>
</body>

</html>
