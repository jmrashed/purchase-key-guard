@extends('purchase-key-guard::layouts.app')

@section('content')
<div class="container">
    <h1>Purchase Keys</h1>
    <a href="{{ route('admin.purchase-keys.create') }}" class="btn btn-primary">Create Purchase Key</a>
    <table class="table">
        <thead>
            <tr>
                <th>Email</th>
                <th>Domain</th>
                <th>Purchase Code</th>
                <th>Expires At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseKeys as $key)
            <tr>
                <td>{{ $key->email }}</td>
                <td>{{ $key->domain }}</td>
                <td>{{ $key->purchase_code }}</td>
                <td>{{ $key->expires_at }}</td>
                <td>{{ $key->status }}</td>
                <td>
                    <a href="{{ route('admin.purchase-keys.edit', $key) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('admin.purchase-keys.destroy', $key) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    <form action="{{ route('admin.purchase-keys.revoke', $key) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">Revoke</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
