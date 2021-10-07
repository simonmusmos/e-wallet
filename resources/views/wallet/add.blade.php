@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Wallet') }}</div>

                <div class="card-body">
                <form id="add_customer_form">
                    {{ csrf_field() }}
                    <span class="invalid-feedback" id="error_body">
                        <strong>
                            <ul id="error_fields">
                            </ul>
                        </strong>
                    </span>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#add_customer_form').on('submit', function(e){
        e.preventDefault();

        $("#error_body").removeClass("d-block");

        var url = "{{ route('wallet.create') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // $.post(url, function(data){
        //     console.log(data);
        // });

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {
                "name": $('#name').val(),
            },
            success: function (data) {
                window.location.replace('{{ route("wallet.get") }}')
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
