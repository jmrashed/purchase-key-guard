@extends('purchase-key-guard::layouts.app')

@section('title', 'Revalidate Purchase Key')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Revalidation Result</h2>

    @if($result['status'] === 'valid')
        <div class="bg-green-500 text-white p-4 rounded mb-4">{{ $result['message'] }}</div>
    @else
        <div class="bg-red-500 text-white p-4 rounded mb-4">{{ $result['message'] }}</div>
    @endif

    <a href="{{ route('purchase-key.status') }}" class="inline-block mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Check Status</a>
@endsection
