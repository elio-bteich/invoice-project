@extends('layout')

@section('content')
        <div class="my-container">
            <form method="post" action="{{ route('pdf') }}">
                @csrf
                <input type="hidden" name="currency">
            <div class="row align-items-center pl-5">
                <div class="col-9">
                    <h1>Generator and Marine Services</h1>
                </div>
                <div class="col-2">
                    <h5 class="">Invoice No. <span style="color: red">{{ $invoice_no }}</span></h5>
                    <input type="hidden" name="invoice-no" value="{{ $invoice_no }}">
                </div>
            </div>

            <div style="font-size: 16px">
                <p>Kfardebian 76-323441 03-345521 03-225331</p>
                <a href="mailto:eliobteich115@gmail.com" class="mt-0">eliobteich115@gmail.com</a>
                <p class="mb-0">Mof: #3323135 Rc: #1063466 Baabda</p>
            </div>

            <div class="row align-items-end pb-3">
                <div class="col-10">
                    <hr class="my-hr">
                </div>
                <div class="col-2">
                    <h1>Invoice</h1>
                </div>
            </div>

            <div class="row my-3 justify-content-between">
                <div class="col-7">
                    <table class="table-bordered w-100">
                        <thead>
                            <tr>
                                <th colspan="2">Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>
                                    <input type="text" class="input-info" name="customer-name" required>
                                    <div id="customers-list"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><input type="text" class="input-info" name="customer-address" required></td>
                            </tr>
                            <tr>
                                <td>MOF</td>
                                <td><input type="text" class="input-info" name="customer-mof" required></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td><input type="text" class="input-info" name="customer-phone" required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <table class="table-bordered w-100">
                        <thead>
                            <tr>
                                <th colspan="2">Misc</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Date</td>
                                <td><input data-format="dd/mm/yyyy" type="text" class="input-info" name="invoice-date" id="invoice-date" required></td>

                            </tr>
                            <tr>
                                <td>Generator</td>
                                <td><input type="text" class="input-info" name="generator" required></td>
                            </tr>
                            <tr>
                                <td>ID#</td>
                                <td><input type="text" class="input-info" name="customer-id" required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <div class="table-wrapper">
                        <table class="my-table w-100">
                            <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="10%">Code</th>
                                <th width="5%">Qty</th>
                                <th width="50%">Description</th>
                                <th width="15%">Unit Price</th>
                                <th width="15%">TOTAL</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-6">
                    <table style="border: solid 1px black" class="w-100">
                        <tr>
                            <th height="75.2px" width="20.5%" style="border: black solid 1px" class="text-center">Payment</th>
                            <td id="price-in-words"></td>
                            <input type="hidden" name="total-in-words">
                        </tr>
                    </table>
                    <select name="payment-type" id="payment-type" style="width: 20.5%; background: none; cursor: pointer">
                        @foreach($payment_types as $payment_type)
                            <option value="{{ $payment_type->id }}">{{ $payment_type->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="total-table-wrapper">
                    <table class="total-table">
                        <tr>
                            <th width="50%">SubTotal</th>
                            <td id="subtotal" width="50%"><input type="text" name="subtotal"></td>
                        </tr>
                        <tr>
                            <th>VAT 11%</th>
                            <td id="vat"><input type="text" name="vat"></td>
                        </tr>
                        <tr>
                            <th>C/V</th>
                            <td id="cv"><input type="text" name="cv"></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td id="discount"><input type="text" name="discount"></td>
                        </tr>
                        <tr>
                            <th>TOTAL TTC</th>
                            <td id="total"><input type="text" name="total"></td>
                            <input type="hidden" name="total-float">
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row my-3">
                <div class="m-auto d-flex flex-column">
                    <button type="button" class="btn btn-primary add-item-btn mb-2" style="background: #404040; border: none">Add Item</button>
                    <button type="submit" class="btn btn-primary" style="background: #404040; border: none">Convert to PDF</button>
                </div>
            </div>
            </form>
        </div>

        <script>
            $(document).ready(function () {
                $('input[name=customer-name]').keyup(function () {
                    let query = $(this).val()
                    if (query !== '') {
                        $.ajax({
                            url: '/autocomplete/customer/' + query,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                if (data['message'] !== 'empty') {
                                    $('#customers-list').fadeIn()
                                    $('#customers-list').html(data['customers_list'])
                                } else {
                                    $('#customers-list').hide()
                                }
                            }
                        })
                    }else {
                        $('#customers-list').hide()
                    }
                })
                $(document).on('keyup', '.item-row', function(e) {
                    console.log(e.target.name)
                    if (e.target.name == "unit-description[]") {
                        let query = e.target.value
                        $.ajax({
                            url: '/autocomplete/item/' + query,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                console.log(data)
                                if (data['message'] !== 'empty') {
                                    $('#items-list').fadeIn()
                                    $('#items-list').html(data['items_list'])
                                } else {
                                    $('#items-list').hide()
                                }
                            }
                        })
                    }
                })
            })
        </script>
@endsection
