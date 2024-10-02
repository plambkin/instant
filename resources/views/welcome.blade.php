<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instant Garden</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .hero-bg-old {
            background-image: url('/images/mams_old_garden.jpg');
            background-size: cover;
            background-position: center;
            min-height: 60vh;
        }

                .hero-bg-old-2 {
            background-color: #28a745;
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

                .hero-bg {
            background-image: url('https://example.com/your-background-image.jpg');
            background-size: cover;
            background-position: center;
            min-height: 60vh; /* Further reduced the height */
        }

        .transition-section {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .transition-section img {
            max-width: 40%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .transition-arrow {
            font-size: 40px;
            color: white;
            margin: 0 20px;
            transform: rotate(90deg);
        }

        .squiggly-arrow {
            width: 100px;
            height: 100px;
            position: relative;
            margin: 0 20px;
        }

        .squiggly-arrow::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/d/d7/Squiggly_Arrow_Right.svg'); /* A squiggly arrow image */
            background-size: contain;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <!-- Hero Section -->
    <div class="hero-bg relative flex items-center justify-center text-center text-white">

        <div class="bg-black bg-opacity-50 p-12 rounded-lg">

            <h1 class="text-4xl font-extrabold">View YOUR New Beautiful Garden in Minutes</h1>
            <p class="mt-4 text-lg">Instant Garden helps you transform your garden, balcony or outdoor space into a mindful, beautiful oasis in minutes.</p>

            <!-- Transition Section with Garden Images -->
            <div class="transition-section">
                <!-- Old Garden -->
                <img src="{{ asset('images/mams_old_garden.jpg') }}" alt="Old Garden">
                <!-- Squiggly Arrow -->
                <div class="squiggly-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                        <path d="M19.428,11.162c0.5-0.357,1.157-0.383,1.665-0.068c0.51,0.316,0.778,0.912,0.683,1.497c-0.25,1.496-1.158,2.692-2.37,3.565
                            c-0.916,0.65-1.982,1.049-3.127,1.184c-1.678,0.2-3.353-0.17-4.893-1.051c-0.885-0.513-1.67-1.164-2.365-1.893
                            c-1.598-1.616-2.681-3.572-3.656-5.586c-0.47-0.951-0.91-1.919-1.495-2.818c-0.483-0.743-1.087-1.441-1.86-1.867
                            C2.378,3.644,1.335,3.531,0.5,4.028c-0.462,0.278-0.666,0.872-0.461,1.396c0.207,0.524,0.74,0.783,1.231,0.582
                            c0.492-0.201,0.775-0.759,0.918-1.266C2.444,4.406,2.591,4.116,2.749,3.836c0.254-0.442,0.738-0.784,1.252-0.799
                            c0.514-0.015,1.019,0.317,1.41,0.729c0.811,0.844,1.353,1.947,1.828,3.026c1.122,2.496,2.265,4.995,3.773,7.284
                            c0.697,1.084,1.606,2.111,2.686,2.88c1.513,1.04,3.408,1.427,5.187,0.97c1.09-0.281,2.105-0.856,2.916-1.666
                            c0.543-0.54,1.015-1.182,1.357-1.872C20.081,12.213,20.1,11.482,19.428,11.162z"/>
                    </svg>
                </div>
                <!-- New Garden -->
                <img src="{{ asset('images/mam_new_garden_2.jpg') }}" alt="New Garden">
            </div>

            @if (Route::has('login'))
            <div class="mt-8">
                @auth
                <a href="{{ url('/dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Log in</a>
                <a href="{{ route('register') }}" class="ml-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Register</a>
                @endauth
            </div>
            @endif
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="container mx-auto mt-6 py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">About Instant Garden</h2>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Instant Garden is an app designed to help you create a mindful, beautiful garden in no time. Whether you have a garden, patio, or balcony, Instant Garden gives you the tools to visualize and design your ideal outdoor space. Within minutes, we can give you a list and costings of plants, benches, water features and even statues to transform your garden.
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Benefits of a Beautiful Garden</h2>
                    <ul class="mt-4 text-gray-600 dark:text-gray-400 list-disc pl-6">
                        <li>Promotes mindfulness and relaxation</li>
                        <li>Enhances the beauty of your home</li>
                        <li>Boosts property value</li>
                        <li>Encourages outdoor activity and health</li>
                        <li>Supports local biodiversity</li>
                    </ul>
                </div>
            </div>
        </div>

<!-- Detailed Section with Call to Action -->
<div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Services Offered Section -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Services Offered</h2>
            <ul class="mt-4 text-gray-600 dark:text-gray-400 list-disc pl-6">
                <li>High-quality image of your transformed garden</li>
                <li>Project costings for the garden design</li>
                <li>Access to garden centers for plants and materials</li>
                <li>Option to engage with a trusted landscaper</li>
            </ul>
        </div>
    </div>

    <!-- Prices From Section -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">How Pricing Works</h2>
            <ul class="mt-4 text-gray-600 dark:text-gray-400 list-disc pl-6">
                <li>Basic Garden Design: To be decided</li>
                <li>Advanced Garden with Features (e.g., water features, benches): </li>
                <li>Complete Garden Package (Design + Landscaping): </li>
                <li>Custom Landscape Architecture: Starting at </li>
            </ul>
        </div>
    </div>
</div>

<!-- Call to Action Button Centered -->
<div class="mt-8 text-center">
    <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
        Get Started with Instant Garden
    </a>
</div>


    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-900 text-gray-400 py-6">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; {{ date('Y') }} Instant Garden. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
