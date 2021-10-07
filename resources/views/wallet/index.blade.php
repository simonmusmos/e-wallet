@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="container">
                <div class="card-deck row">
                    @foreach($wallets as $wallet)
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2 pr-0">
                                        <h5 class="card-text text-success"><i class="fa fa-angle-double-down"></i>&nbsp $ {{ number_format((float)$wallet->transactions->where("is_deleted",0)->where("is_incoming",1)->sum("amount"), 2, '.', ''); }}</h5>
                                        <h5 class="card-text text-danger"><i class="fa fa-angle-double-up"></i>&nbsp $ {{ number_format((float)$wallet->transactions->where("is_deleted",0)->where("is_incoming",0)->sum("amount"), 2, '.', ''); }}</h5>
                                    </div>
                                    <div class="col-6 pl-0">
                                        <h3 class="card-title text-primary mb-0"><a href="{{ route('wallet.view', $wallet->id) }}" class="text-decoration-none">{{ $wallet->name }}</a></h3>
                                        <h6 class="card-text text-secondary">Wallet Address: {{ $wallet->wallet_address }}</h6>
                                    </div>
                                    <div class="col-4 m-auto">
                                        <div class="dropdown float-right">
                                            <button class="btn bg-transparent" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-secondary"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="javascript:void(0)" id="remove-wallet" data-url="{{ route('wallet.remove-wallet', $wallet->id) }}">Delete Wallet</a>
                                                <a class="dropdown-item rename-wallet" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" data-name="{{ $wallet->name }}" data-id="{{ $wallet->id }}">Rename Wallet</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#remove-wallet").on("click", function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $(this).data('url'),
            type: "post",
            dataType: "json",
            data: {

            },
            success: function (data) {
                window.location.replace('{{ route("wallet.get") }}');
            },
            error: function (data) {
                var errors = "";
                $.each(data.responseJSON.errors, function(index, item) {
                    errors += "<li>" + item + "</li>";
                });

                $("#error_fields").html(errors);

                $("#error_body").addClass("d-block");
            }
        });
    });

    $(".wallet_cards").on("click", function(){
        window.location.replace($(this).data("url"));
    });

    
</script>
@endsection
