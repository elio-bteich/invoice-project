@extends('layout')

@section('content')
    <div id="add-customer">
        <div class="window">
            <div class="row justify-content-between">
                <div class="col-4">
                    <img src="/profile-logo.png" class="w-100" id="customer-img">
                </div>
                <div class="col-7 text-center">
                    <h1 class="mb-4">Add Customer</h1>
                    <form action="{{ route('add-customer') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name" name="name" required>
                            <input type="text" class="form-control" placeholder="Address" name="address" required>
                            <input type="text" class="form-control" placeholder="MOF#" name="mof" required>
                            <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" required>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
