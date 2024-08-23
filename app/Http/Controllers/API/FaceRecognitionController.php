<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaceRecognitionController extends Controller
{

    public function detectFaces(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // Path to your service account key file
            $serviceAccountPath = base_path('bhoodimap-3d8bcf1a9b52.json');

            // Set the environment variable for authentication
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $serviceAccountPath);

            $request->validate([
                'image' => 'required|image',
            ]);

            $imagePath = $request->file('image')->getPathname();

            // Create a new ImageAnnotatorClient
            $imageAnnotator = new ImageAnnotatorClient();

            // Read the image file
            $imageData = file_get_contents($imagePath);

            // Perform face detection on the image file
            $response = $imageAnnotator->faceDetection($imageData);
            $faces = $response->getFaceAnnotations();

            $hasFace = count($faces) > 0;

            $imageAnnotator->close();

            if ($hasFace == true) {
                $user_id = $this->loggedInUser->id;
                User::where(['id' => $user_id])->update(['user_verified' => 1]);
            }

            return response()->json(['hasFace' => $hasFace]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
