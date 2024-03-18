@extends('layout')

@section('content')
    <div id="home">
        <h1>Welcome to <br>Generator and Marine Services</h1>

        <div class="row w-100">
            <div class="col-3 offset-3">
                <a href="{{ url('add-customer') }}">
                    <div class="block">
                        <h2>Add Customer</h2>
                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ url('invoice') }}">
                    <div class="block">
                        <h2>Create Invoice</h2>
                    </div>
                </a>
            </div>
        </div>
        @if(Session::has('success'))
            <div class="alert mt-5" style="width: 30%; margin: auto; background: rgba(0,255,0,0.09)">
                {{ Session::get('success') }}
            </div>
        @endif
    </div>
@endsection
