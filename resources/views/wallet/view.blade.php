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
                                <div class="col-8 m-auto">
                                    <div class="row text-white ml-2">
                                        <div class="col-12 pr-0">
                                            <h1 class="card-text font-weight-normal">{{ $wallet->name }}</h1>
                                        </div>
                                        <div class="col-12 pr-0">
                                            <h4 class="card-text font-weight-light">Wallet Address: {{ $wallet->wallet_address }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 m-auto">
                                    <div class="dropdown float-right">
                                        <button class="btn bg-transparent" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v text-white"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href='{{ route("transaction.add", $wallet->id) }}'>Add Transaction</a>
                                            @if(env('ENABLE_SEND_MONEY'))
                                                <a class="dropdown-item" href='{{ route("wallet.send", $wallet->id) }}'>Send Money</a>
                                            @endif
                                            @if(env('ENABLE_REQUEST_MONEY'))
                                                <a class="dropdown-item" href='{{ route("wallet.request", $wallet->id) }}'>Request Money</a>
                                            @endif
                                            <!-- <a class="dropdown-item" href='{{ route("wallet.request", $wallet->id) }}'>Request Money</a> -->
                                            <a class="dropdown-item rename-wallet" href="javascript:void(0)" data-name="{{ $wallet->name }}" data-id="{{ $wallet->id }}" data-toggle="modal" data-target="#exampleModal">Rename Wallet</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-4 mb-4">
                        <div class="card border-0 shadow bg-secondary mr-0 get-transactions" style="border-radius: 1rem;" data-type="all">
                            <div class="card-body">
                                <div class="row text-white">
                                    <div class="col-12 pr-0">
                                        <h3 class="card-text font-weight-light">Combined Income</h3>
                                    </div>
                                    <div class="col-12 pr-0">
                                        <h3 class="card-text font-weight-light"><i class="fa fa-money"></i>&nbsp ${{ number_format((float)($wallet->transactions->where("is_deleted",0)->where("is_incoming",1)->sum("amount") - $wallet->transactions->where("is_deleted",0)->where("is_incoming",0)->sum("amount")), 2, '.', ''); }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mb-4">
                        <div class="card border-0 shadow bg-c-green mr-0 get-transactions" style="border-radius: 1rem;" data-type="incoming">
                            <div class="card-body">
                                <div class="row text-white">
                                    <div class="col-12 pr-0">
                                        <h3 class="card-text font-weight-light">Total Incoming</h3>
                                    </div>
                                    <div class="col-12 pr-0">
                                        <h3 class="card-text font-weight-light"><i class="fa fa-angle-double-down"></i>&nbsp ${{ number_format((float)$wallet->transactions->where("is_deleted",0)->where("is_incoming",1)->sum("amount"), 2, '.', ''); }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mb-4">
                        <div class="card border-0 shadow bg-c-red ml-0 get-transactions" style="border-radius: 1rem;" data-type="outgoing">
                            <div class="card-body">
                                <div class="row text-white">
                                    <div class="col-12 pr-0">
                                        <h3 class="card-text font-weight-light">Total Outgoing</h3>
                                    </div>
                                    <div class="col-12 pr-0">
                                        <h3 class="card-text font-weight-light"><i class="fa fa-angle-double-up"></i>&nbsp ${{ number_format((float)$wallet->transactions->where("is_deleted",0)->where("is_incoming",0)->sum("amount"), 2, '.', ''); }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow" style="border-radius: 1rem;">
                            <div class="card-body pb-4">
                                <div class="row text-secondary ml-2">
                                    <div class="col-12 pr-0">
                                        <div class="row pb-3 pt-2">
                                            <div class="col-9">
                                                <h3 class="card-text font-weight-normal">Transaction List</h3>
                                            </div>
                                            <!-- <div class="col-3">
                                                <a class="float-right btn btn-success btn-sm mr-3" href='{{ route("transaction.add", $wallet->id) }}'>Add Transaction</a>
                                            </div> -->
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-secondary text-center">
                                                <thead class="text-secondary">
                                                    <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="transaction-table" style="height: 30px; overflow-y: scroll">
                                                    @foreach($transactions as $transaction)
                                                    <tr>
                                                        @if($transaction->is_fraudulent)
                                                            <td scope="row"><i class="fa fa-exclamation text-danger font-weight-light"></i>&nbsp{{ $transaction->id }}</td>
                                                        @else
                                                            <td scope="row">{{ $transaction->id }}</td>
                                                        @endif
                                                        
                                                        <td class="{{ $transaction->is_incoming ? 'text-success' : 'text-danger' }}">${{ number_format((float)$transaction->amount, 2, '.', ''); }}</td>
                                                        <td>{{ date("F d, Y H:i:s", strtotime($transaction->created_at)) }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item remove-transaction" href="javascript:void(0)" data-url="{{ route('transaction.remove-transaction', $transaction->id) }}">Remove Transaction</a>
                                                                    <a class="dropdown-item mark-as-fraudulent" href="javascript:void(0)" data-url="{{ route('transaction.mark-as-fraudulent', $transaction->id) }}">Mark as Fraudulent</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</div>
<script>
    // var removeTransactionURL = "";
    // var markAsFraudulentURL = "";
    var months = ["January", "February", "March","April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $("div").on("click", "a.mark-as-fraudulent", function(){
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
                window.location.replace('{{ route("wallet.view", $wallet->id) }}');
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

    $("div").on("click", "a.remove-transaction", function(){
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
                window.location.replace('{{ route("wallet.view", $wallet->id) }}');
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

    $(".get-transactions").on("click", function(){
        $.ajax({
            url: "{{ route('transaction.get', $wallet->id) }}?type="+$(this).data('type'),
            success:function(data)
            {
                console.log(data);
                var htmlBody = "";
                $.each(data, function(index, item) {
                    var incomingTextCSS = "text-danger";
                    if(item.is_incoming) {
                        incomingTextCSS = "text-success";
                    }

                    var isFraudulent = "&nbsp";
                    if(item.is_fraudulent) {
                        isFraudulent = '<i class="fa fa-exclamation text-danger font-weight-light"></i>&nbsp';
                    }

                    var removeTransactionURL = '{{ route("transaction.remove-transaction", ":id") }}';
                    removeTransactionURL = removeTransactionURL.replace(':id', item.id);
                    var markAsFraudulentURL = '{{ route("transaction.mark-as-fraudulent", ":id") }}';
                    markAsFraudulentURL = markAsFraudulentURL.replace(':id', item.id);

                    var createdDate = new Date(item.created_at);

                    var formattedCreatedDate = months[createdDate.getMonth()] + " " + createdDate.getDate() + ", " + createdDate.getFullYear() + " " + createdDate.getHours() + ":" + createdDate.getMinutes() + ":" + createdDate.getSeconds()

                    htmlBody += "<tr>"+
                                    "<th scope='row'>"+isFraudulent+""+item.id+"</th>"+
                                    "<td class=" + incomingTextCSS + ">$" + item.amount.toFixed(2) + "</td>"+
                                    "<td>" + formattedCreatedDate + "</td>"+
                                    "<td>"+
                                    "<div class='dropdown'>"+
                                    "<button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                    "Action"+
                                    "</button>"+
                                    "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>"+
                                    "<a class='dropdown-item remove-transaction' href='javascript:void(0)' data-url='"+removeTransactionURL+"'>Remove Transaction</a>"+
                                    "<a class='dropdown-item mark-as-fraudulent' href='javascript:void(0)' data-url='"+markAsFraudulentURL+"'>Mark as Fraudulent</a>"+
                                    "</div>"+
                                    "</div>"+
                                    "</td>"+
                                    "</tr>";
                });
                console.log(htmlBody);
                $("#transaction-table").html(htmlBody);
            }
        });
    });

    

    function generateUrlAddress(id, type){
        $.ajax({
            url: "{{ route('reference.get-url') }}?type="+type+"&id="+id,
            success:function(data)
            {
                removeTransactionURL = data;
                console.log(removeTransactionURL);
            }
        });
    }
</script>
@endsection
