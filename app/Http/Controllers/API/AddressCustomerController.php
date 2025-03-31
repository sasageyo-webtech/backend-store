<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAddressCustomerRequest;
use App\Http\Requests\UpdateAddressCustomerRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\AddressCustomerCollection;
use App\Http\Resources\AddressCustomerResource;
use App\Models\AddressCustomer;
use App\Repositories\AddressCustomerRepository;
use App\Repositories\CustomerRepository;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AddressCustomerController extends Controller
{
    public function __construct(
        private AddressCustomerRepository $addressCustomerRepository,
        private CustomerRepository $customerRepository
    ){}

    public function index(Request $request){
        $customer_id = $request->input('customer_id');
        if(!$this->customerRepository->isExists($customer_id)) {
            return response()->json([
                'message' => 'Customer not found',
                'errors' => [
                    'customer_id' => [
                        'Customer not found.'
                    ]
                ]
            ], 404);
        }

        $address_customers = $this->addressCustomerRepository->getByCustomerId($customer_id);
        return new AddressCustomerCollection($address_customers);
    }

    public function show(int $address_customer_id)
    {
        if(!$this->addressCustomerRepository->isExists($address_customer_id)) {
            return response()->json([
                'message' => 'Address customer not found',
                'errors' => [
                    '$address_customer_id' => 'Address customer not found.'
                ]
            ], 404);
        }
        $address_customer = $this->addressCustomerRepository->getById($address_customer_id);
        return new AddressCustomerResource($address_customer);
    }

    public function store(CreateAddressCustomerRequest $request)
    {
        // Data ผ่านการ validate แล้ว
        $validatedData = $request->validated(); // ดึงข้อมูลที่ validated แล้ว

        // สร้าง AddressCustomer
        $addressCustomer = $this->addressCustomerRepository->create($validatedData);

        // คืนค่า AddressCustomerResource
        return new AddressCustomerResource($addressCustomer);

    }

    public function update(UpdateAddressCustomerRequest $request, int $address_customer_id)
    {
        $request->validated();

        if(!$this->addressCustomerRepository->isExists($address_customer_id)) {
            return response()->json([
                'message' => 'Address Customer not found',
                'errors' => [
                    '$address_customer_id' => 'Address Customer not found.'
                ]
            ]);
        }
        $address_customer = $this->addressCustomerRepository->getById($address_customer_id);


        $this->addressCustomerRepository->update([
           "name" => $request->input('name', $address_customer->name),
           "phone_number" => $request->input('phone_number', $address_customer->phone_number),
           "house_number" => $request->input('house_number', $address_customer->house_number),
           "building" => $request->input('building', $address_customer->building),
           "street" => $request->input('street', $address_customer->street),
           "sub_district" => $request->input('sub_district', $address_customer->sub_district),
           "district" => $request->input('district', $address_customer->district),
           "province" => $request->input('province', $address_customer->province),
           "country" => $request->input('country', $address_customer->country),
           "postal_code" => $request->input('postal_code', $address_customer->postal_code),
           "detail_address" => $request->input('detail_address', $address_customer->detail_address),
        ], $address_customer->id);

        return new AddressCustomerResource($address_customer->refresh());
    }

    public function destroy(int $address_customer_id)
    {
        if (!$this->addressCustomerRepository->isExists($address_customer_id)) {
            return response()->json([
                'message' => 'Address Customer not found',
                'errors' => [
                    '$address_customer_id' => 'Address Customer not found.'
                ]
            ]);
        }

        $this->addressCustomerRepository->delete($address_customer_id);
        return response()->json([
            'message' => 'Address deleted successfully'
        ], 200);
    }
}
