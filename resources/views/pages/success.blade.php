@extends('purchase-key-guard::layouts.app')

@section('title', 'Re Validation Success')

@section('content')
    <div class="flex justify-center items-start min-h-screen pt-12">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 rounded-lg shadow-md max-w-md w-full flex items-center">
            <!-- Circle with Checkmark Icon -->
            <svg class="w-8 h-8 text-white bg-green-500 p-1 rounded-full mr-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" xmlns:xlink="http://www.w3.org/1999/xlink">
                <circle cx="10" cy="10" r="9" class="text-green-500" stroke="currentColor" stroke-width="2" fill="none"/>
                <path fill="currentColor" d="M15.293 5.293a1 1 0 00-1.414 0L8 10.586 5.121 7.707a1 1 0 10-1.414 1.414l3.5 3.5a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/>
            </svg>

            <!-- Success message -->
            <div>
                @if(session('success'))
                    <p class="font-medium">{{ session('success') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
