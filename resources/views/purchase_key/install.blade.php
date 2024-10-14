@extends('purchase-key-guard::layouts.app')

@section('title', 'Install Purchase Key')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Install Your Purchase Key</h2>

    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('purchase-key.install.form') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label for="purchase_code" class="block text-sm font-medium text-gray-700">Purchase Code</label>
            <input type="text" name="purchase_code" id="purchase_code" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="item_code" class="block text-sm font-medium text-gray-700">Item Code</label>
            <input type="text" name="item_code" id="item_code" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="domain" class="block text-sm font-medium text-gray-700">Domain</label>
            <input type="text" name="domain" id="domain" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="installation_date" class="block text-sm font-medium text-gray-700">Installation Date</label>
            <input type="date" name="installation_date" id="installation_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Install Purchase Key</button>
    </form>
@endsection
