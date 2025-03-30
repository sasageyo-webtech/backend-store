<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepository $productRepository,
        private BrandRepository $brandRepository,
        private CategoryRepository $categoryRepository,
    ) {}


    public function index()
    {
        $products = $this->productRepository->getAll() ;
        return new ProductCollection($products);
    }

    public function store(Request $request)
    {
        $product = $this->productRepository->create([
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'rating' => $request->input('rating'),
            'accessibility' => $request->input('accessibility'),
        ]);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $this->productRepository->update([
            'category_id' => $request->get('category_id'),
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
        $query = Strtolower($query);
        $products = $this->productRepository->filterByName($query);
        return new ProductCollection($products);
    }

    public function addStock(Request $request, Product $product){
        $product = $this->productRepository->getById($product->id);
        if(!$product){
            return response()->json([
                "message" => 'Product not found'
            ], 400);
        }

        $amount = $request->input('amount');
        $this->productRepository->update([
            'stock' => $product->stock + $amount
        ], $product->id);

        return new ProductResource($product->refresh());
    }

    public function getProductByCategoryId(Category $category){
        if(!$this->categoryRepository->isExists($category->id)) return response()->json([
            'message' => 'Category not found'
        ]);
        $products = $this->productRepository->getByCategoryId($category->id);
        return new ProductCollection($products);
    }

    public function getProductByBrandId(Brand $brand){
        if(!$this->brandRepository->isExists($brand->id)) return response()->json([
            'message' => 'Brand not found'
        ]);
        $products = $this->productRepository->getByBrandId($brand->id);
        return new ProductCollection($products);
    }
}
