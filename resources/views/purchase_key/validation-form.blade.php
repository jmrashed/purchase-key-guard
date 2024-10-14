{{-- /Users/rashedzaman/purchase-key-guard/resources/views/purchase_key/validation-form.blade.php --}}

@extends('purchase-key-guard::layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Validate Purchase Key</h1>



        {{-- Validation form --}}
        <form action="{{ url('purchase-key.validate.submit') }}" method="POST" class="bg-white shadow-md rounded p-6">
            @csrf
            <div class="mb-4">
                <label for="purchase_code" class="block text-gray-700 text-sm font-bold mb-2">Purchase Code:</label>
                <input type="text" name="purchase_code" id="purchase_code" value="{{ old('purchase_code') }}" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" 
                       required>
            </div>

            <div class="mb-6">
                <label for="domain" class="block text-gray-700 text-sm font-bold mb-2">Domain:</label>
                <input type="text" name="domain" id="domain" value="{{ old('domain') }}" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" 
                       required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Validate Purchase Key
                </button>
            </div>
        </form>
    </div>
@endsection
