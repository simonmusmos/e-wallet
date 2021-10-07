@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Manage Supplier') }}

                <a class="float-right btn btn-success btn-sm" href="{{ route('supplier.add') }}">Add Supplier</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Supplier Code</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Country</th>
                            <th scope="col">State</th>
                            <th scope="col">City</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                            <tr>
                            <th scope="row">{{ $supplier->id }}</th>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->supplier_code }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->country->name }}</td>
                            <td>{{ $supplier->state->name }}</td>
                            <td>{{ $supplier->city->name }}</td>
                            <td><a class="btn btn-success btn-sm" href="{{ route('supplier.edit', $supplier->id) }}">Edit Supplier</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
