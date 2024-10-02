<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        // Log the beginning of the request
        Log::info('Starting submission process.', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        // Log the validation attempt
        Log::info('Validating request data.');

        // Validate the incoming request
        $validatedData = $request->validate([
            'original_garden_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ai_generated_garden_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'garden_design' => 'required|string',
            'garden_items' => 'required|array', 
            'garden_items.*.name' => 'required|string',
            'garden_items.*.type' => 'required|string',
            'garden_items.*.price' => 'required|numeric',
            'garden_items.*.supplier' => 'required|string',
        ]);

        // Log the success of validation
        Log::info('Request data successfully validated.', [
            'validated_data' => $validatedData
        ]);

        try {
            // Store the original garden image
            Log::info('Storing original garden image.');
            $originalImagePath = $request->file('original_garden_image')->store('garden_images', 'public');
            Log::info('Original garden image stored successfully.', ['path' => $originalImagePath]);

            // Store the AI-generated garden image
            Log::info('Storing AI-generated garden image.');
            $aiImagePath = $request->file('ai_generated_garden_image')->store('garden_images', 'public');
            Log::info('AI-generated garden image stored successfully.', ['path' => $aiImagePath]);

            // Create a new Submission entry in the database
            $submission = new Submission();
            $submission->user_id = Auth::id(); // Assign the currently logged-in user

            // Log image paths and user ID
            Log::info('Assigning submission data.', [
                'user_id' => $submission->user_id,
                'original_garden_image' => $originalImagePath,
                'ai_generated_garden_image' => $aiImagePath
            ]);

            // Store the paths to the images
            $submission->original_garden_image = $originalImagePath;
            $submission->ai_generated_garden_image = $aiImagePath;

            // Log garden design
            Log::info('Storing garden design text.');
            $submission->garden_design = $request->input('garden_design');

            // Store the garden items as JSON
            Log::info('Storing garden items as JSON.', [
                'garden_items' => $request->input('garden_items')
            ]);
            $submission->garden_items = json_encode($request->input('garden_items'));

            // Log the save attempt
            Log::info('Attempting to save submission.');

            // Save the submission
            $submission->save();

            // Log success
            Log::info('Submission saved successfully.', ['submission_id' => $submission->id]);

            return redirect()->back()->with('status', 'Submission created successfully!');
        } catch (\Exception $e) {
            // Log any exceptions that occur
            Log::error('Error occurred while processing submission.', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to create submission. Please try again.');
        }
    }
}

