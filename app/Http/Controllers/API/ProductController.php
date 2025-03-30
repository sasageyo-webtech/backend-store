<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepository $productRepository,
        private BrandRepository $brandRepository,
        private CategoryRepository $categoryRepository,
    ) {}


    public function index()
    {
        $products = $this->productRepository->get(20);
        return new ProductCollection($products);
    }

    public function store(CreateProductRequest $request)
    {
        $request->validated();

        $product = $this->productRepository->create([
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        return new ProductResource($product->refresh());
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $request->validated();

        $this->productRepository->update([
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'accessibility' => $request->input('accessibility'),
        ], $product->id);

        return new ProductResource($product->refresh());
    }


    public function destroy(int $id)
    {
        // ตรวจสอบว่าผลิตภัณฑ์มีอยู่ในระบบหรือไม่
        $product = $this->productRepository->isExists($id);
        if(!$product){
            return response()->json([
                "message" => 'Product not found',
                "errors" => [
                    "product" => [
                        "Product not found"
                    ]
                ]
            ], 404);
        }

        // ตรวจสอบว่าผลิตภัณฑ์นี้ถูกใช้ในคำสั่งซื้อหรือไม่
        $isUsedInOrder = $this->productRepository->isUsedInOrder($id);
        if ($isUsedInOrder) {
            return response()->json([
                'message' => 'Product cannot be deleted because it is used in an order.',
                'errors' => [
                    "product" => [
                        'Product cannot be deleted because it is used in an order.'
                    ]
                ]
            ], 400); // Response 400 Bad Request
        }

        // ลบผลิตภัณฑ์
        $this->productRepository->delete($id);

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = $this->productRepository->filterByName($query, 20);
        return new ProductCollection($products);
    }

    public function addStock(Request $request, Product $product){

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity
        }

        $product = $this->productRepository->getById($product->id);
        if (!$product) {
            return response()->json([
                "message" => 'Product not found',
                "errors" => [
                    "product" => [
                        "Product not found"
                    ]
                ]
            ], 404); // Not Found
        }

        $amount = $request->input('amount');
        // Update stock
        $this->productRepository->update([
            'stock' => $product->stock + $amount
        ], $product->id);

        return new ProductResource($product->refresh());
    }

    public function getProductByCategoryId(Category $category){
        if(!$this->categoryRepository->isExists($category->id)) return response()->json([
            'message' => 'Category not found',
            'errors' => [
                "category" => [
                    "Category not found"
                ]
            ]
        ]);
        $products = $this->productRepository->getByCategoryId($category->id, 20);
        return new ProductCollection($products);
    }

    public function getProductByBrandId(Brand $brand){
        if(!$this->brandRepository->isExists($brand->id)) return response()->json([
            'message' => 'Brand not found',
            'errors' => [
                "brand" => [
                    "Brand not found"
                ]
            ]
        ]);
        $products = $this->productRepository->getByBrandId($brand->id, 20);
        return new ProductCollection($products);
    }
}
