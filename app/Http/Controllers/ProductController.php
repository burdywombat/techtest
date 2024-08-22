<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\DataFetchService;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display the products.
     */
    public function index(Request $request): View
    {
    	$query = Product::with(['category']);

    	if ($request->has('category')) {
    		$category = $request->query('category');
    		$query->whereHas('category', function ($query) use ($category) {
			    return $query->where('name', $category);
			});
    	}

    	$productData = $query->get();

    	return view('products_index')->with('productData', $productData);

    }

    public function runImport() {
    	$service = new DataFetchService;

    	//Working off exit codes, so 0 is success.
        $status = $service->run();

        $message = "Data Fetch Service Failure";
        if (!$status) {
        	$message = "Data Fetch Service Success";
        }

        return view('data_service_status', compact('message'));
    }

}
