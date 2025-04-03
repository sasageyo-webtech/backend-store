<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ImageProduct;
use App\Models\Product;
use App\Repositories\ImageProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageProductController extends Controller
{
    public function __construct(
        private ImageProductRepository $imageProductRepository
    ){}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg', // Validates that file is an image and max size 2MB
            'product_id' => 'required|exists:products,id', // Ensure product_id exists
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity
        }

        // If validation passes, continue with file upload logic
        $file = $request->file('image_file');
        $filename = time() . '-' . $file->getClientOriginalName();
        $path = $file->storeAs('products', $filename, 'public');

        // Store the image path in the database
        $this->imageProductRepository->create([
            'product_id' => $request->input('product_id'),
            'image_path' => $path,
        ]);

        return response()->json([
            'message' => 'Image stored successfully',
        ]);
    }

    public function destroy(int $image_product_id)
    {
        // If the image product doesn't exist, return a custom error message
        if (!$this->imageProductRepository->isExists($image_product_id)) {
            return response()->json([
                'message' => 'Image not found',
                'errors' => [
                    'image' => 'Image not found',
                ]
            ], 404);
        }

        $imageProduct = $this->imageProductRepository->getById($image_product_id);
        $filePath = $imageProduct->image_path;

        if (Storage::disk('public')->exists($filePath)) Storage::disk('public')->delete($filePath);

        // Delete the image record from the database
        $this->imageProductRepository->delete($imageProduct->id);

        // Return success response
        return response()->json([
            'message' => 'Image deleted successfully',
        ]);
    }

}
