<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCustomerCollection;
use App\Http\Resources\AddressCustomerResource;
use App\Models\AddressCustomer;
use App\Repositories\AddressCustomerRepository;
use Illuminate\Http\Request;

class AddressCustomerController extends Controller
{
    public function __construct(
        private AddressCustomerRepository $addressCustomerRepository
    ){}

    public function index(Request $request){
        $customer_id = $request->input('customer_id');
        $addressCustomers = $this->addressCustomerRepository->getByCustomerId($customer_id);
        return new AddressCustomerCollection($addressCustomers);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'house_number' => 'required|string|max:50',
            'building' => 'nullable|string|max:100',
            'street' => 'required|string|max:100',
            'sub_district' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:10',
            'detail_address' => 'nullable|string|max:255',
        ]);

        $addressCustomer = $this->addressCustomerRepository->create([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'house_number' => $request->input('house_number'),
            'building' => $request->input('building'),
            'street' => $request->input('street'),
            'sub_district' => $request->input('sub_district'),
            'district' => $request->input('district'),
            'province' => $request->input('province'),
            'country' => $request->input('country'),
            'postal_code' => $request->input('postal_code'),
            'detail_address' => $request->input('detail_address'),
            'customer_id' => $request->input('customer_id'),
        ]);

        return new AddressCustomerResource($addressCustomer);
    }

    public function show(AddressCustomer $addressCustomer)
    {
        return new AddressCustomerResource($addressCustomer);
    }

    public function update(Request $request, AddressCustomer $addressCustomer)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20',
            'house_number' => 'sometimes|required|string|max:50',
            'building' => 'nullable|string|max:100',
            'street' => 'sometimes|required|string|max:100',
            'sub_district' => 'sometimes|required|string|max:100',
            'district' => 'sometimes|required|string|max:100',
            'province' => 'sometimes|required|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'sometimes|required|string|max:10',
            'detail_address' => 'nullable|string|max:255',
        ]);

        $this->addressCustomerRepository->update([
            'name' => $request->input('name', $addressCustomer->name),
            'phone_number' => $request->input('phone_number', $addressCustomer->phone_number),
            'house_number' => $request->input('house_number', $addressCustomer->house_number),
            'building' => $request->input('building'),
            'street' => $request->input('street', $addressCustomer->street),
            'sub_district' => $request->input('sub_district', $addressCustomer->sub_district),
            'district' => $request->input('district', $addressCustomer->district),
            'province' => $request->input('province', $addressCustomer->province),
            'country' => $request->input('country', $addressCustomer->country),
            'postal_code' => $request->input('postal_code', $addressCustomer->postal_code),
            'detail_address' => $request->input('detail_address'),
        ], $addressCustomer->id);

        return new AddressCustomerResource($addressCustomer->refresh());
    }

    public function destroy(AddressCustomer $addressCustomer)
    {
        if(!$this->addressCustomerRepository->isExists($addressCustomer->id)) {
            return response()->json([
                'message' => 'Address Customer not found',
        ], 404);}

        $this->addressCustomerRepository->delete($addressCustomer->id);
        return response()->json([
            'message' => 'Address Customer deleted successfully',
        ], 200);
    }
}
