@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Unauthorized') }}</div>

                <div class="card-body">
                    Sorry, but you do not have access to this page.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
