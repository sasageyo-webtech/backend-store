<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ImageProduct;
use App\Models\Product;
use App\Repositories\ImageProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageProductController extends Controller
{
    public function __construct(
        private ImageProductRepository $imageProductRepository
    ){}

    public function store(Request $request)
    {
        if(!$request->hasFile('image_file')) return response()->json(['message' => 'image_file not found'], 404);

        $file = $request->file('image_file');
        $filename = time() . '-' .$file->getClientOriginalName();
        $path = $file->storeAs('products', $filename, 'public');

        $this->imageProductRepository->create([
            'product_id' => $request->input('product_id'),
            'image_path' => $path,
        ]);

        return response()->json([
            'message' => 'image stored',
        ]);
    }

    public function destroy(ImageProduct $imageProduct)
    {
        if(!$this->imageProductRepository->isExists($imageProduct->id)){
            return response()->json([
                'message' => 'image not found',
            ]);
        }

        $filePath = $imageProduct->image_path;

        // ลบไฟล์จาก storage
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $this->imageProductRepository->delete($imageProduct->id);
        return response()->json([
            'message' => 'image deleted',
        ]);
    }
}
