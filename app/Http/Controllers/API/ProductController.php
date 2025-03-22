<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {}


    public function index()
    {
        $products = $this->productRepository->getAll();
        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //TODO Validate store product

        $imagePaths = [];
        if ($request->hasFile('image_paths')) {
            foreach ($request->file('image_paths') as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $imagePaths[] = $path; // Store the path for each uploaded image
            }
        }

        $product = $this->productRepository->create([
            'category_id' => $request->get('category_id'),
            'brand_id' => $request->get('brand_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'image_paths' => json_encode($imagePaths),
            'rating' => $request->get('rating'),
            'accessibility' => $request->get('accessibility'),
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //TODO Gate update product
        //TODO Validate update product

//        if ($request->hasFile('image_paths')) {
//            foreach ($request->file('image_paths') as $file) {
//                $filename = time() . '-' . $file->getClientOriginalName();
//                $path = $file->storeAs('products', $filename, 'public');
//                $imagePaths[] = $path; // Add new image path to the array
//            }
//        }

        $this->productRepository->update([
            'category_id' => $request->get('category_id'),
            'brand_id' => $request->get('brand_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'accessibility' => $request->get('accessibility'),
        ], $product->id);

        return new ProductResource($product->refresh());
    }

    public function destroy(int $id)
    {
        $product = $this->productRepository->isExists($id);
        if(!$product){
            return response()->json([
                "message" => 'Product not found'
            ], 404);
        }

        //TODO Delete product when is not used in order
        $this->productRepository->delete($id);
        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = $this->productRepository->filterByName($query);
        return new ProductCollection($products);
    }
}
