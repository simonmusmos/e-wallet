@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="container">
                <div class="card-deck row">
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow bg-c-blue" style="border-radius: 1rem;">
                            <div class="card-body pb-4 row">
                                <div class="col-8">
                                    <div class="row text-white">
                                        <div class="col-12 pr-0">
                                            <h3 class="card-text font-weight-normal">Request From:</h3>
                                        </div>
                                        <div class="col-12 pr-0">
                                            <h5 class="card-text font-weight-light">Wallet Name: {{ $token->wallet->name }}</h5>
                                        </div>
                                        <div class="col-12 pr-0">
                                            <h5 class="card-text font-weight-light">Wallet Address: {{ $token->wallet->wallet_address }}</h5>
                                        </div>
                                        <div class="col-12 pr-0">
                                            <h5 class="card-text font-weight-light">Amount: ${{ number_format($token->amount, 2, '.', ''); }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
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
                                        <h3 class="card-title text-primary mb-0 wallet-list" data-id="{{$wallet->id}}"><a href="javascript:void(0)" class="text-decoration-none">{{ $wallet->name }}</a></h3>
                                        <h6 class="card-text text-secondary">Wallet Address: {{ $wallet->wallet_address }}</h6>
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
    $(".remove-wallet").on("click", function(){
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

    $(".wallet-list").on("click", function(){
        $("#process-request-confirmation-yes").attr("data-id", $(this).data("id"));
        $("#process-request-confirmation-modal").modal("show");
    });

  
</script>
@endsection
