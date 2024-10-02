<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Gardens</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .garden {
            margin-bottom: 20px;
        }
        .garden img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h1>Your Gardens</h1>

    @forelse($gardens as $garden)
        <div class="garden">
            <h3>Garden Saved on: {{ $garden->created_at->format('F j, Y') }}</h3>

            @if($garden->garden_image1)
                <div>
                    <img src="{{ public_path('storage/'.$garden->garden_image1) }}" alt="Garden Image 1">
                </div>
            @endif

            @if($garden->garden_image2)
                <div style="margin-top: 10px;">
                    <img src="{{ public_path('storage/'.$garden->garden_image2) }}" alt="Garden Image 2">
                </div>
            @endif
        </div>
    @empty
        <p>No saved gardens found.</p>
    @endforelse
</body>
</html>
