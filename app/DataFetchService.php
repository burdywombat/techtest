<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Category;

class DataFetchService
{

	protected $siteDomain = 'https://dummyjson.com';

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    	 
    }

    public function run() {
    	$apiData = $this->fetchProductsData();    	

    	if ($apiData) {

    		$productSaveStatuses = [
	    		'saved' => [],
	    		'failed' => [],
	    	];

    		foreach ($apiData['products'] as $data) {
    			$category = Category::firstOrCreate(['name' => $data['category']]);

    			if (!$category) {
					array_push($productSaveStatuses['failed'], $data['id']);
    				continue;
    			} 

    			$product = Product::updateOrCreate([
    				'title' => $data['title'],
		            'description' => $data['description'],
		            'site_category' => $data['category'],
		            'category_id' => $category->id,
    			],[
    				'price' => $data['price'],
		            'stock' => $data['stock'],
    			]);

    			if (!$product) {
    				array_push($productSaveStatuses['failed'], $data['id']);
    				continue;
    			}
    			array_push($productSaveStatuses['saved'], $product->id);
    			
    		}

    		$saveCount = count($productSaveStatuses['saved']);
    		$failedCount = count($productSaveStatuses['failed']);
    		$message = "Successfully saved " . $saveCount . " items.";

    		if ($failedCount > 0) {
    			$failedList = implode(", ", $productSaveStatuses['failed']);
    			$message .= " " . $failedCount . " failed to save - IDs: " .  $failedList;
    		}

    		Log::info($message);
    		return 0;
    	}

    	return 1;
    }

    protected function fetchProductsData() {

    	try {
    		$response = Http::get($this->siteDomain . '/products');

    		if (!$response->successful()) {
    			$message = "Failed to retrieve products from the external API. Retrieved status code - " . $response->getStatusCode();
    			throw new Exception($message);
    		}

    		$responseData = $response->json();

    		if (is_null($responseData)) {
    			$message = "Failed to retrieve products from the external API. Site didn't return JSON";
    			throw new Exception($message);
    		}

    		return $responseData;

    	} catch(Exception $e) {
    		Log::error($e->getMessage());
    		return false;
    	}
    	Log::error("Fell out of try and catch.");
    	return false;
    }
}
