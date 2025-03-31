<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function __construct(
        private BrandRepository $brandRepository
    ){}

    public function index()
    {
        $brands = $this->brandRepository->getAll();
        return new BrandCollection($brands);
    }

    public function store(CreateBrandRequest $request)
    {
        $request->validated();

        $name = $request->input('name');

        $brand = $this->brandRepository->create([
            'name' => $name
        ]);

        return response()->json([
            'message' => 'Brand successfully created',
            'brand' => new BrandResource($brand)
        ], 201);

    }

    public function show(int $brand_id)
    {
        if(!$this->brandRepository->isExists($brand_id)){
            return response()->json([
                'message' => 'Brand not found',
                'errors' => [
                    'brand_id' => 'Brand not found'
                ]
            ], 404);
        }
        $brand = $this->brandRepository->getById($brand_id);
        return new BrandResource($brand);
    }

    public function update(UpdateBrandRequest $request, int $brand_id)
    {
        $request->validated();

        if(!$this->brandRepository->isExists($brand_id)){
            return response()->json([
                'message' => 'Brand not found',
                'errors' => [
                    'brand_id' => 'Brand not found'
                ]
            ], 404);
        }

        $brand = $this->brandRepository->getById($brand_id);

        $this->brandRepository->update([
            'name' => $request->input('name', $brand->name),
        ], $brand->id);

        return new BrandResource($brand->refresh());
    }

    public function destroy(int $brand_id)
    {
        if(!$this->brandRepository->isExists($brand_id)){
            return response()->json([
                'message' => 'Brand not found',
                'errors' => [
                    'brand_id' => 'Brand not found'
                ]
            ], 404);
        }

        $brand = $this->brandRepository->getById($brand_id);

        if($brand->products->count())
            return response()->json([
                'message' => 'Brand has products associated with it',
            ], 422);


        $this->brandRepository->delete($brand->id);

        return response()->json([
            'message' => 'Brand successfully deleted',
        ], 200);
    }


}
