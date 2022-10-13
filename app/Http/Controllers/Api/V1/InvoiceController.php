<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Filters\V1\InvoicesFilter;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request);
        
        if(is_countable($queryItems) && count($queryItems) == 0)
        {
            return new InvoiceCollection(Invoice::paginate());
        }else
        {
            return new InvoiceCollection(Invoice::where($queryItems)->paginate());
        }

    }

    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }
}
