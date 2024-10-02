<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Garden Design</title>
    <style>
        /* Add any styles you want for the PDF */
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Your Garden Design</h1>

    @foreach ($gardens as $garden)
        <h2>Garden Design: {{ $garden->design_text }}</h2>
        <p><strong>Cost Breakdown:</strong> {{ $garden->cost_breakdown }}</p>

        <!-- Add any additional garden information here, e.g., items -->
    @endforeach
</body>
</html>
