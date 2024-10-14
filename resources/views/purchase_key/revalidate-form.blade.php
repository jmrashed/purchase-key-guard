@extends('layouts.app')

@section('title', 'Revalidate Purchase Key')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Revalidate Your Purchase Key</h2>

    <form action="{{ route('purchase-key.revalidate') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label for="purchase_code" class="block text-sm font-medium text-gray-700">Purchase Code</label>
            <input type="text" name="purchase_code" id="purchase_code" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Revalidate Purchase Key</button>
    </form>
@endsection
