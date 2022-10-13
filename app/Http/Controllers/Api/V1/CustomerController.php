<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Filters\V1\CustomersFilter;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $filter = new CustomersFilter();
        $queryItems = $filter->transform($request);

        if(is_countable($queryItems) && count($queryItems) == 0)
        {
            return new CustomerCollection(Customer::paginate());
        }else
        {
            $customers = Customer::where($queryItems)->paginate();
            return new CustomerCollection($customers->appends($request->query()));
        }

    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }
}   