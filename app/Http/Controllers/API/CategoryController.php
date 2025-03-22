<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        $category = $this->categoryRepository->findByName($name);
        if($category){
            return response()->json([
                'message' => 'Category was created',
            ], 400);
        }

        $category = $this->categoryRepository->create([
            'name' => $name,
        ]);

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // TODO Validate update category
        $name = $request->input('name');
        $tmp = $this->categoryRepository->findByName($name);
        if($tmp) {
            return response()->json([
                'message' => 'Category was created',
            ], 400);
        }

        $this->categoryRepository->update([
            'name' => $request->get('name')
        ], $category->id);

        return new CategoryResource($category->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $tmp = $this->categoryRepository->isExists($category->id);
        if(!$tmp){
            return response()->json([
                "message" => 'Category not found'
            ], 404);
        }

        $this->categoryRepository->delete($category->id);
        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
