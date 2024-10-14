@extends('layouts.app')

@section('title', 'Purchase Key Status')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Current Purchase Key Status</h2>

    @if($currentStatus)
        <div class="bg-white p-6 rounded shadow-md">
            <h3 class="text-lg font-semibold">Purchase Code: {{ $currentStatus->purchase_code }}</h3>
            <p><strong>Item Code:</strong> {{ $currentStatus->item_code }}</p>
            <p><strong>Domain:</strong> {{ $currentStatus->domain }}</p>
            <p><strong>Installation Date:</strong> {{ $currentStatus->installation_date }}</p>
            <p><strong>Status:</strong> Valid</p>
        </div>
    @else
        <div class="bg-white p-6 rounded shadow-md">
            <p>No purchase key installed.</p>
        </div>
    @endif
@endsection
