@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="container">
                <div class="card-deck row">
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow" style="border-radius: 1rem;">
                            <div class="card-body pb-4">
                                <div class="row text-secondary px-2">
                                    <div class="col-12">
                                        <div class="row pb-3">
                                            <div class="col-9">
                                                <h3 class="card-text font-weight-normal">Request Money</h3>
                                            </div>
                                        </div>
                                        <form id="add_customer_form">
                                            {{ csrf_field() }}
                                            <span class="invalid-feedback" id="error_body">
                                                <strong>
                                                    <ul id="error_fields">
                                                    </ul>
                                                </strong>
                                            </span>
                                            <div class="form-group">
                                                <label for="amount">Amount:</label>
                                                <input type="number" id="amount" step="0.01" class="form-control">
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </form>
                                        <div class="alert alert-success d-none" id="success-alert">
                                            Indicates a successful or positive action.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#add_customer_form').on('submit', function(e){
        e.preventDefault();

        $("#error_body").removeClass("d-block");

        var url = "{{ route('wallet.generate-request', $wallet->id) }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {
                "amount": $('#amount').val(),
                "address": $('#receiver').val()
            },
            success: function (data) {
                console.log(data);
                $("#success-alert").html("Please copy this link: " + data.link);
                $("#add_customer_form").addClass("d-none");
                $("#success-alert").removeClass("d-none");
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
</script>
@endsection
