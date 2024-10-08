<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Submission;
use OpenAI;
use Illuminate\Support\Facades\DB;

class GardenController extends Controller
{
    public function generateGarden(Request $request)
    {
        Log::info('Received request to generate garden design.', ['request_data' => $request->all()]);


        try {
            // Validate the request data
            $validatedData = $request->validate([
                'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Increase the file size limit to 5MB
                'dimensions' => 'required|string',
                'type' => 'required|string',
                'statues' => 'nullable', // We will handle conversion below
                'flowering' => 'required|string',
                'water_features' => 'nullable', // We will handle conversion below
                'maintainability' => 'required|integer|min:1|max:10',
                'supplier' => 'required|string',
            ]);

            // Convert "on" to 1, and ensure unchecked boxes are 0
            $validatedData['statues'] = $request->input('statues') === 'on' ? 1 : 0;
            $validatedData['water_features'] = $request->input('water_features') === 'on' ? 1 : 0;

            Log::info('Request data validated successfully.');

            // Continue with the rest of your logic...
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Log any other exception
            Log::error('An error occurred during request processing', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }



        Log::info('Request data validated successfully.');

        if ($request->hasFile('photo')) {
            try {
                Log::info('Photo file detected.');

                // Store the uploaded image
                $photo = $request->file('photo');
                $originalImagePath = $photo->store('garden_images', 'public');

                $aiGeneratedImagePath='mam_new_garden_2.jpg';

                Log::info('Original garden image stored successfully.', ['path' => $originalImagePath]);

                // Initialize OpenAI client for GPT-4
                $apiKey = config('app.openai_api_key');

                $client = OpenAI::client($apiKey);
                Log::info('OpenAI client initialized successfully.');

                // Construct the prompt for GPT-4
                $prompt = "I have a garden with dimensions {$validatedData['dimensions']}, type: {$validatedData['type']}. 
                           I want a {$validatedData['flowering']} garden with statues: {$validatedData['statues']}, 
                           water features: {$validatedData['water_features']}, and maintainability: {$validatedData['maintainability']}. 
                           Please generate a detailed garden design plan along with a cost breakdown and list the garden items from supplier {$validatedData['supplier']} https://www.jonesgc.com/.";

                Log::info('Sending prompt to GPT-4.', ['prompt' => $prompt]);

                // Simulate GPT-4 completion using the correct chat-based model
                $response = $client->chat()->create([
                    'model' => 'gpt-4',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful assistant that generates detailed garden design plans with cost breakdowns and item lists.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 2000,
                    'temperature' => 0.7,
                ]);

                // Extract the response text from the chat model response
                $gardenDesign = $response['choices'][0]['message']['content'];
                Log::info('Garden design generated by GPT-4.', ['gardenDesign' => $gardenDesign]);

                // Simulated cost breakdown and items for the garden (Replace with AI-generated data if needed)
                $costBreakdown = '€3250'; 
                $items = [
                    ['name' => 'Greek Statue', 'price' => '€200'],
                    ['name' => 'Bench', 'price' => '€150'],
                    ['name' => 'Flowering Plant', 'price' => '€15 each'],
                ];

                Log::info('Cost breakdown and items initialized.', ['costBreakdown' => $costBreakdown, 'items' => $items]);

                // Get authenticated user
                $user = Auth::user();
                if (!$user) {
                    Log::error('Failed to retrieve authenticated user.');
                    return response()->json(['error' => 'User not authenticated.'], 401);
                }
                Log::info('Authenticated user retrieved.', ['user_id' => $user->id]);

                // Save the submission to the database using transaction
                DB::transaction(function () use ($user, $originalImagePath, $gardenDesign, $costBreakdown, $items, $request) {
                    $submission = new Submission();
                    $submission->user_id = $user->id;  // Store user ID

                    // Store paths to the images
                    $submission->original_garden_image = $originalImagePath;
                    $submission->ai_generated_garden_image = 'ai_generated_placeholder.png'; // Placeholder, adjust as necessary

                    // Store the garden design text
                    $submission->garden_design = $gardenDesign;

                    // Store the garden items as JSON
                    $submission->garden_items = json_encode($items);

                    // Save the submission
                    $submission->save();

                    Log::info('Submission saved to the database.', ['submission_id' => $submission->id]);
                });

                // Return the garden design, cost breakdown, items, and illustration to the user

                return view('garden', [
                    'gardenDesign' => [
                        'name' => 'My Garden Design',
                        'original_image' => $originalImagePath, // Path to the original image
                        'design' => $gardenDesign, // The design text
                    ],
                    'costBreakdown' => $costBreakdown,
                    'items' => $items,
                    'illustration' => asset('storage/images/' . $aiGeneratedImagePath) // AI-generated image
                ]);



            } catch (\Exception $e) {
                Log::error('Error occurred during garden generation.', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Failed to generate garden designs.'], 500);
            }
        }

        Log::warning('Photo upload failed. No file found in the request.');
        return response()->json(['error' => 'Photo upload failed.'], 400);
    }



    public function viewGardens()
    {
        Log::info('Fetching gardens for the user.', ['user_id' => Auth::id()]);

        // Retrieve submissions for the authenticated user
        $submissions = Submission::where('user_id', Auth::id())->get();

        if ($submissions->isEmpty()) {
            Log::info('No gardens found for the user.', ['user_id' => Auth::id()]);
        } else {
            Log::info('Gardens retrieved successfully.', ['user_id' => Auth::id(), 'submission_count' => $submissions->count()]);
        }

        // Pass the submissions to the view
        return view('gardens.view', ['submissions' => $submissions]);
    }

}
