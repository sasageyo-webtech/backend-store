<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $name = $request->input('name');
        $brand = $this->brandRepository->findByName($name);
        if($brand) {
            return response()->json([
                'message' => 'Brand already exists',
            ], 400);
        }

        $brand = $this->brandRepository->create([
            'name' => $name
        ]);

        return response()->json([
            'message' => 'Brand successfully created',
        ], 201);
    }

    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    public function update(Request $request, Brand $brand)
    {
        // TODO Validate update brand

        $name = $request->input('name');
        $tmp = $this->brandRepository->findByName($name);
        if($tmp) {
            return response()->json([
                'message' => 'Brand already exists',
            ], 400);
        }

        $this->brandRepository->update([
            'name' => $request->input('name'),
        ], $brand->id);

        return new BrandResource($brand->refresh());
    }

    public function destroy(Brand $brand)
    {
        if($brand->products()->count()) {
            return response()->json([
                'message' => 'Brand has products associated with it',
            ], 400);
        }
        $this->brandRepository->delete($brand->id);
        return response()->json([
            'message' => 'Brand successfully deleted',
        ], 200);
    }


}
