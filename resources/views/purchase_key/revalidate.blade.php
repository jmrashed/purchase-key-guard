{{-- /Users/rashedzaman/purchase-key-guard/resources/views/purchase_key/revalidate.blade.php --}}

@extends('purchase-key-guard::layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Revalidate Purchase Key</h1>

        {{-- Display validation errors --}}
        @if(optional($errors)->any())
            <div class="mb-4 text-red-500 text-center">
                <ul>
                    @foreach(optional($errors)->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Revalidation form --}}
        <form action="{{ url('purchase-key.revalidate.submit') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label for="purchase_code" class="block text-gray-700 text-sm font-bold mb-2">Purchase Code:</label>
                <input type="text" id="purchase_code" name="purchase_code" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       value="{{ old('purchase_code') }}" required>
            </div>

            <div class="mb-4">
                <label for="item_code" class="block text-gray-700 text-sm font-bold mb-2">Item Code:</label>
                <input type="text" id="item_code" name="item_code" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       value="{{ old('item_code') }}" required>
            </div>

            <div class="mb-4">
                <label for="domain" class="block text-gray-700 text-sm font-bold mb-2">Domain:</label>
                <input type="url" id="domain" name="domain" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       value="{{ old('domain') }}" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Revalidate
                </button>
            </div>
        </form>
        
        {{-- Link to installation form if not installed --}}
        <div class="mt-6 text-center">
            <a href="{{ url('purchase-key.install.form') }}" 
               class="text-blue-500 hover:text-blue-700">
                Go to Installation
            </a>
        </div>
    </div>
@endsection
