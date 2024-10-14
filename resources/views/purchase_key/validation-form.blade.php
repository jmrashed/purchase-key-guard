@extends('layouts.app')

@section('title', 'Purchase Key Validation')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md dark:bg-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-white">Purchase Key Validation</h1>

        @if (session('status'))
            <div class="mb-4 text-green-500 text-center">
                {{ session('status') }}
            </div>
        @endif

        @if (optional($errors)->any())
            <div class="mb-4 text-red-500 text-center">
                <ul>
                    @foreach (optional($errors)->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('purchase.key.validate') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="purchase_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase
                    Code</label>
                <input type="text" name="purchase_code" id="purchase_code" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Enter your purchase code">
            </div>

            <div class="mb-4">
                <label for="item_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item Code</label>
                <input type="text" name="item_code" id="item_code" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Enter your item code">
            </div>

            <div class="mb-4">
                <label for="domain"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website/Domain</label>
                <input type="text" name="domain" id="domain" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Enter your website or domain">
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Validate Purchase Key
                </button>
            </div>
        </form>
    </div>
@endsection
