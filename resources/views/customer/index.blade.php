@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Manage Customers') }}

                <a class="float-right btn btn-success btn-sm" href="{{ route('customer.add') }}">Add Customer</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Country</th>
                            <th scope="col">State</th>
                            <th scope="col">City</th>
                            <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                            <th scope="row">{{ $customer->id }}</th>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->country->name }}</td>
                            <td>{{ $customer->state->name }}</td>
                            <td>{{ $customer->city->name }}</td>
                            <!-- <td><a class="btn btn-success btn-sm" href="{{ route('customer.edit', $customer->id) }}">Edit Customer</a></td> -->
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
