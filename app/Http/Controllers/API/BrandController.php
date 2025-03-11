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
    )
    {
    }

    public function index()
    {
        $brands = $this->brandRepository->getAll();
        return new BrandCollection($brands);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        // TODO Validate update brand

        $this->brandRepository->update([
            'name' => $request->get('name'),
        ], $brand->id);

        return new BrandResource($brand->refresh());
    }

    public function destroy(Brand $brand)
    {
        $this->brandRepository->delete($brand->id);
    }
}
