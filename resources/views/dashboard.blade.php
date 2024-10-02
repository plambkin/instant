<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Instant Garden Dashboard') }}
        </h2>
    </x-slot>

    <head>
        <!-- Include Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script>
            // Function to preview the image once it's uploaded
            function previewImage(event) {
                const reader = new FileReader();
                const file = event.target.files[0];

                if (file) {
                    reader.onload = function() {
                        const image = document.getElementById('uploadedImage');
                        image.src = reader.result;
                        image.style.display = 'block'; // Show the image
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Function to show the loading wheel when "Generate Garden" button is pressed
            function showLoading() {
                const loader = document.getElementById('loadingSpinner');
                loader.style.display = 'block'; // Show the loading spinner
            }
        </script>
    </head>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">

                <!-- Garden Specifications Section -->
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Garden Specifications</h2>

                    <!-- Form for submitting garden data -->
                    <form action="{{ route('generate.garden') }}" method="POST" enctype="multipart/form-data" onsubmit="showLoading()">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Dimensions Input -->
                            <div>
                                <label class="block font-medium text-gray-700">Dimensions (e.g., 20x8 meters)</label>
                                <input type="text" name="dimensions" class="mt-1 block w-full border-2 p-2 rounded" placeholder="Enter dimensions" required>
                            </div>

                            <!-- Garden Type Input -->
                            <div>
                                <label class="block font-medium text-gray-700">Type</label>
                                <select name="type" class="mt-1 block w-full border-2 p-2 rounded" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="Balcony">Balcony</option>
                                    <option value="Outside Garden">Outside Garden</option>
                                </select>
                            </div>

                            <!-- Flowering Input -->
                            <div>
                                <label class="block font-medium text-gray-700">All-Year Flowering</label>
                                <select name="flowering" class="mt-1 block w-full border-2 p-2 rounded" required>
                                    <option value="" disabled selected>Select Flowering</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <!-- Maintainability Input -->
                            <div>
                                <label class="block font-medium text-gray-700">Maintainability (1-10)</label>
                                <input type="number" name="maintainability" class="mt-1 block w-full border-2 p-2 rounded" min="1" max="10" required>
                            </div>

                            <!-- Include Statues Input -->
                            <div>
                                <label class="block font-medium text-gray-700">Include Statues?</label>
                                <input type="checkbox" name="statues" class="mt-1">
                            </div>

                            <!-- Include Water Features Input -->
                            <div>
                                <label class="block font-medium text-gray-700">Include Water Features?</label>
                                <input type="checkbox" name="water_features" class="mt-1">
                            </div>

                            <!-- Supplier Dropdown -->
                            <div class="col-span-2">
                                <label class="block font-medium text-gray-700">Supplier</label>
                                <select name="supplier" class="mt-1 block w-full border-2 p-2 rounded" required>
                                    <option value="" disabled selected>Select Supplier</option>
                                    <option value="Jones Garden Centre">Jones Garden Centre https://www.jonesgc.com/</option>
                                    <option value="IKEA Dublin">IKEA Dublin</option>
                                </select>
                            </div>
                        </div>

                        <!-- Upload Photo Section -->
                        <div class="p-6 bg-gray-50 border-b border-gray-200 mt-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Upload Garden Photo</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="relative">
                                    <input type="file" name="photo" accept="image/*" class="border-2 border-blue-500 rounded w-full p-4 shadow-sm" onchange="previewImage(event)" required>
                                    <!-- Display uploaded image -->
                                    <img id="uploadedImage" src="" alt="Uploaded Garden" class="w-full h-auto border rounded mt-4" style="display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button and Loading Spinner -->
                        <div class="mt-6 text-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Generate Garden Design
                            </button>

                            <!-- Loading spinner (hidden initially) -->
                            <div id="loadingSpinner" class="mt-4" style="display: none;">
                                <svg class="animate-spin h-8 w-8 text-gray-900 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                                <p class="text-gray-700 mt-2">Generating...</p>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Display Garden Information after submission -->
                @if (session('gardenDesign'))
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Generated Garden Design</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <img src="{{ session('illustration') }}" alt="Generated Garden Design" class="border rounded w-full p-4 mb-4">
                            </div>
                        </div>

                        <!-- Display Garden Design Details -->
                        <h3 class="text-lg font-semibold text-gray-800">Garden Design</h3>
                        <p>{{ session('gardenDesign') }}</p>

                        <!-- Display Cost Breakdown -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-4">Cost Breakdown</h3>
                        <p>{{ session('costBreakdown') }}</p>

                        <!-- Display Garden Items -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-4">Items</h3>
                        <ul>
                            @foreach (session('items') as $item)
                                <li>{{ $item['name'] }} - {{ $item['price'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
