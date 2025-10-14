@extends('purchase-key-guard::layouts.app')

@section('content')
<div class="container">
    <h1>Edit Purchase Key</h1>
    <form action="{{ route('admin.purchase-keys.update', $purchaseKey) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $purchaseKey->email }}" required>
        </div>
        <div class="form-group">
            <label for="domain">Domain</label>
            <input type="text" name="domain" id="domain" class="form-control" value="{{ $purchaseKey->domain }}" required>
        </div>
        <div class="form-group">
            <label for="purchase_code">Purchase Code</label>
            <input type="text" name="purchase_code" id="purchase_code" class="form-control" value="{{ $purchaseKey->purchase_code }}" required>
        </div>
        <div class="form-group">
            <label for="expires_at">Expires At</label>
            <input type="date" name="expires_at" id="expires_at" class="form-control" value="{{ $purchaseKey->expires_at ? \Carbon\Carbon::parse($purchaseKey->expires_at)->format('Y-m-d') : '' }}">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="active" {{ $purchaseKey->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $purchaseKey->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
