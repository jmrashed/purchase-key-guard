@extends('purchase-key-guard::layouts.app')

@section('title', __('Purchase Key Validation'))

@section('content')
    <div class=" mx-auto p-4 max-w-screen-md">
        <h1 class="text-2xl font-semibold mb-4 text-center">{{ __('Validate Purchase Key') }}</h1>

        <!-- Validation form -->
        <form action="{{ route('validate.submit') }}" method="POST" class="bg-white shadow-md rounded p-6">
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

            <!-- Domain Input -->
            <div class="mb-6">
                <label for="domain" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Domain:') }}</label>
                <input type="text" name="domain" id="domain" value="{{ old('domain') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline
                    @error('domain') is-invalid @enderror">

                @error('domain')
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('domain') }}</p>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email:') }}</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline
                    @error('email') is-invalid @enderror">

                 @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex text-center justify-end">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ __('Validate Purchase Key') }}
                </button>
            </div>
        </form>
    </div>
@endsection
