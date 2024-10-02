<!-- resources/views/gardens/view.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Gardens') }}
        </h2>
    </x-slot>

    <head>
        
                <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    </head>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($submissions->isEmpty())
                        <p>You haven't submitted any gardens yet.</p>
                    @else
                        @foreach ($submissions as $submission)
                            <div class="border-b border-gray-300 pb-4 mb-6">
                                <h2 class="text-2xl font-bold mb-4">Garden Submission from {{ $submission->created_at->format('d M Y') }}</h2>
                                
                                <!-- Original Garden Image -->
                                <div class="mb-6">
                                    <h2 class="text-lg font-semibold text-gray-900">Original Garden Image:</h2>
                                    <img src="{{ asset('storage/' . $submission->original_garden_image) }}" alt="Original Garden Image" class="w-full h-auto mt-2">
                                </div>

                                <!-- AI Generated Garden Image -->
                                <div class="mb-6">
                                    <h2 class="text-lg font-semibold text-gray-900">AI Generated Garden Image:</h2>
                                    <img src="{{ asset('storage/' . $submission->ai_generated_garden_image) }}" alt="AI Generated Garden Image" class="w-full h-auto mt-2">
                                </div>

                                <!-- Garden Design -->
                                <div class="mb-6">
                                    <h2 class="text-lg font-semibold text-gray-900">Garden Design:</h2>

                                    @php
                                        // Split the design by heading patterns and apply styling
                                        $designText = $submission->garden_design;
                                        $designTextFormatted = preg_replace_callback('/(.*:)/', function($matches) {
                                            return '<strong class="block text-xl mt-4">'.trim($matches[1]).'</strong>';
                                        }, $designText);
                                    @endphp

                                    <p class="mt-2 text-gray-800">{!! nl2br($designTextFormatted) !!}</p>
                                </div>

                                <!-- Garden Items -->
                                <div class="mb-6">
                                    <h2 class="text-lg font-semibold text-gray-900">Garden Items:</h2>
                                    @php
                                        $gardenItems = json_decode($submission->garden_items, true);
                                    @endphp
                                    @if ($gardenItems && is_array($gardenItems))
                                        <ul class="list-disc pl-5 mt-2 text-gray-800">
                                            @foreach ($gardenItems as $item)
                                                <li>{{ $item['name'] }} - €{{ $item['price'] }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No items available.</p>
                                    @endif
                                </div>

                                <!-- Submission Date -->
                                <div class="text-sm text-gray-500">
                                    Submitted on: {{ $submission->created_at->format('d M Y') }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
