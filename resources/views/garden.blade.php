<!-- resources/views/garden.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Garden Design') }}
        </h2>
    </x-slot>

    <head>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- If garden data is present -->
                    @if (isset($gardenDesign))
                        <!-- Garden Design Name -->
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold mb-4">Garden Design: {{ $gardenDesign['name'] }}</h2>
                        </div>

                        <!-- Submission Date -->
                        <div class="text-sm text-gray-500 mb-6">
                            Submission Date: {{ \Carbon\Carbon::now()->format('d M Y') }}
                        </div>

                        <!-- Original Garden Image -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-900">Original Garden Image:</h2>
                            <img src="{{ asset('storage/' . $gardenDesign['original_image']) }}" alt="Original Garden Image" class="w-full h-auto mt-2">
                        </div>

                        <!-- AI Generated Garden Image -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-900">AI Generated Garden Image:</h2>
                            <img src="{{ $illustration }}" alt="AI Generated Garden Image" class="w-full h-auto mt-2">
                        </div>

                        <!-- Garden Design Text -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-900">Garden Design:</h2>

                            @php
                                // Format the garden design text
                                $designTextFormatted = preg_replace_callback('/(.*:)/', function($matches) {
                                    return '<strong class="block text-xl mt-4">'.trim($matches[1]).'</strong>';
                                }, $gardenDesign['design']);
                            @endphp

                            <p class="mt-2 text-gray-800">{!! nl2br($designTextFormatted) !!}</p>
                        </div>

                        <!-- Cost Breakdown -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-900">Cost Breakdown:</h2>
                            <p class="mt-2 text-gray-800">{{ $costBreakdown }}</p>
                        </div>

                        <!-- Garden Items -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-900">Garden Items:</h2>
                            <ul class="list-disc pl-5 mt-2 text-gray-800">
                                @foreach($items as $item)
                                    <li>{{ $item['name'] }} - €{{ $item['price'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p>No garden design data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
