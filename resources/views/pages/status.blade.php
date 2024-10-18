@extends('purchase-key-guard::layouts.app')

@section('title', 'Purchase Key Status')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">{{ __('Purchase Key Status') }}</h1>
        {{-- Display the status --}}
        <div class="bg-white shadow-md rounded p-6 mb-4">
            <h2 class="text-lg font-bold">{{ __('Current Status:') }}</h2>
            <p class="mt-2">
                @if(@$status['isValid'])
                    <span class="text-green-500">✔ {{ __('Valid Purchase Key') }}</span>
                @else
                    <span class="text-red-500">✖ {{ __('Invalid Purchase Key') }}</span>
                @endif
            </p>

            <h2 class="text-lg font-bold mt-4">{{ __('Purchase Key Details:') }}</h2>
            <ul class="list-disc ml-6 mt-2">
                <li><strong>{{ __('Purchase Code:') }}</strong> {{ @$status['purchase_code'] }}</li>
                <li><strong>{{ __('Domain:') }}</strong> {{ @$status['domain'] }}</li>
                <li><strong>{{ __('Expiration Date:') }}</strong> {{ @$status['expiration_date'] }}</li>
                <li><strong>{{ __('Last Validation:') }}</strong> {{ @$status['last_validation'] }}</li>
            </ul>
        </div>

        {{-- Link to revalidation form --}}
        <div class="text-center">
            <a href="{{ route('revalidate.form') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ __('Revalidate Purchase Key') }}
            </a>
        </div>
    </div>
@endsection
