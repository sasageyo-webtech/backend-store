<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCustomerCollection;
use App\Http\Resources\AddressCustomerResource;
use App\Models\AddressCustomer;
use App\Repositories\AddressCustomerRepository;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AddressCustomerController extends Controller
{
    public function __construct(
        private AddressCustomerRepository $addressCustomerRepository
    ){}

    public function index(Request $request){
        try {
            $customer_id = $request->query('customer_id');
            if (!$customer_id) return response()->json(['error' => 'Customer ID is required'], 400);
            $addressCustomers = $this->addressCustomerRepository->getByCustomerId($customer_id);
            return new AddressCustomerCollection($addressCustomers);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve addresses', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'customer_id' => 'required|integer|exists:customers,id',
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

            $addressCustomer = $this->addressCustomerRepository->create($validatedData);
            return new AddressCustomerResource($addressCustomer);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create address', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(AddressCustomer $addressCustomer)
    {
        return new AddressCustomerResource($addressCustomer);
    }

    public function update(Request $request, AddressCustomer $addressCustomer)
    {
       try {
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

           $this->addressCustomerRepository->update($validatedData, $addressCustomer->id);
           return new AddressCustomerResource($addressCustomer->refresh());
       } catch (ValidationException $e) {
           return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
       } catch (Exception $e) {
           return response()->json(['error' => 'Failed to update address', 'message' => $e->getMessage()], 500);
       }
    }

    public function destroy(AddressCustomer $addressCustomer)
    {
        try {
            if (!$this->addressCustomerRepository->isExists($addressCustomer->id)) {
                return response()->json(['error' => 'Address not found'], 404);
            }
            $this->addressCustomerRepository->delete($addressCustomer->id);
            return response()->json(['message' => 'Address deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete address', 'message' => $e->getMessage()], 500);
        }
    }
}
