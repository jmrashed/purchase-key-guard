@extends('purchase-key-guard::layouts.app')

@section('title', 'Purchase Key Re-Validation')

@section('content')
    <div class="mx-auto p-4 max-w-screen-md">
        <h1 class="text-2xl font-semibold mb-4 text-center">{{ __('Re-Validate Purchase Code') }}</h1>

        <!-- Validation form -->
        <form action="{{ route('revalidate.submit') }}" method="POST" class="bg-white shadow-md rounded p-6">
            @csrf

            <!-- Purchase Code Input -->
            <div class="mb-4">
                <label for="purchase_code" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Purchase Code:') }}</label>
                <input type="text" name="purchase_code" id="purchase_code" value="{{ old('purchase_code') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline
                    @error('purchase_code') is-invalid @enderror">

                @error('purchase_code')
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('purchase_code') }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex text-center justify-end">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ __('Re-Validate Purchase Code') }}
                </button>
            </div>
        </form>
    </div>
@endsection
