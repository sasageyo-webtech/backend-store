<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}

    public function index()
    {
        $categories = $this->categoryRepository->getAll();
        return new CategoryCollection($categories);
    }

    public function store(CreateBrandRequest $request)
    {
        $request->validated();

        $name = $request->input('name');

        $category = $this->categoryRepository->create([
            'name' => $name,
        ]);

        return response()->json([
            'message' => 'Successfully created Category!',
            'category' => new CategoryResource($category),
        ]);
    }

    public function show(int $category_id)
    {
        if(!$this->categoryRepository->isExists($category_id)){
            return response()->json([
                'message' => 'Category not found',
                'errors' => [
                    'category_id' => 'Category not found'
                ]
            ], 404);
        }
        $category= $this->categoryRepository->getById($category_id);
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, int $category_id)
    {
        $request->validated();

        $name = $request->input('name');
        $category = $this->categoryRepository->getById($category_id);

        $this->categoryRepository->update([
            'name' => $name,
        ], $category->id);

        return new CategoryResource($category->refresh());
    }

    public function destroy(int $category_id)
    {
        if(!$this->categoryRepository->isExists($category_id)){
            return response()->json([
                'message' => 'Category not found',
                'errors' => [
                    'category_id' => 'Category not found'
                ]
            ], 404);
        }

        $category = $this->categoryRepository->getById($category_id);
        if($category->products->count()) {
            return response()->json([
                'message' => 'Category has products associated with it',
                'errors' => [
                    'category_id' => 'Category has products associated with it'
                ]
            ], 422);
        }

        $this->categoryRepository->delete($category->id);

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
