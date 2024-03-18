@extends('layout')

@section('content')

    <div id="customers">
        <div class="container">
            <div class="input-group">
                <input type="search" name="customer-search" id="form1" class="form-control" placeholder="Search" />
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="customers-table m-auto">
                <div class="customers-table-head">
                    <table class="table w-100" style="margin-bottom: 0">
                        <thead>
                            <tr>
                                <td width="50%">Name</td>
                                <td width="50%">Action</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="customers-table-body">
                    <table class="table w-100">
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td width="50%">{{ $customer->name }}</td>
                                <td width="50%" style="text-align: center">
                                    <button class="delete-btn">
                                        <i class="material-icons delete-icon">delete</i>
                                    </button>
                                    <button class="edit-btn">
                                        <i class="material-icons edit-icon">edit</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
