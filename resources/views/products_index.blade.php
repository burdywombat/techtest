<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    @foreach ($productData as $product)
	    <div class="py-12">
	        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
	            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

	                <div class="p-6 text-gray-900 dark:text-gray-100">
	                    <h3>Title: {{ $product['title'] }}</h3>
	                    <p>Category: {{ $product['category']['name'] }}<p>
                    	<p>Description: {{ $product['description'] }}<p>
                		<p>Stock: {{ $product['stock'] }}<p>
                		<p>Price: £{{ $product['price'] }}<p>
	                </div>
	            </div>
	        </div>
	    </div>
	@endforeach
</x-app-layout>
