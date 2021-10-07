@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Customer') }}</div>

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
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Country:</label>
                        <select name="country" id="country" class="custom-select">
                            <option selected disabled>Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pwd">State:</label>
                        <select name="state" id="state" class="custom-select">
                            <option selected disabled>Select State</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pwd">City:</label>
                        <select name="city" id="city" class="custom-select">
                            <option selected disabled>Select City</option>
                        </select>
                    </div>
                    
<!--                     
                    <div class="checkbox">
                        <label><input type="checkbox"> Remember me</label>
                    </div> -->
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#country').on('change', function() {
        var url = "/references/state/" + this.value;
        $.get( url , function( data ) {
            var html = "<option selected disabled>Select State</option>";
            $.each(data, function(index, item) {
                html += "<option value='" + item.id + "'>" + item.name + "</option>";
            });

            
            $("#state").html(html);
        });
    });

    $('#state').on('change', function() {
        var url = "/references/city/" + this.value;
        $.get( url , function( data ) {
            var html = "<option selected disabled>Select City</option>";
            $.each(data, function(index, item) {
                html += "<option value='" + item.id + "'>" + item.name + "</option>";
            });

            
            $("#city").html(html);
        });
    });

    $('#add_customer_form').on('submit', function(e){
        e.preventDefault();

        $("#error_body").removeClass("d-block");

        var url = "{{ route('customer.create') }}";
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
                "address": $('#address').val(),
                "phone": $('#phone').val(),
                "email": $('#email').val(),
                "country": $('#country').val(),
                "city": $('#city').val(),
                "state": $('#state').val(),
            },
            success: function (data) {
                window.location.replace('{{ route("customer.get") }}')
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
