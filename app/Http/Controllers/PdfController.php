<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use App\Models\PaymentType;
use Carbon\Traits\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function exportPDF(Request $request) {
        $date = $request['invoice-date'];
        $date = explode('/', $date);
        $date = join('-', $date);
        Invoice::create([
            'customer_id' => $request['customer-id'],
            'payment_type_id' => $request['payment-type'],
            'generator' => $request['generator'],
            'currency' => $request['currency'],
            'total' => $request['total-float'],
            'date' => Carbon::createFromFormat('d-m-Y', $date)
        ]);

        if (isset($request['unit-code'])) {
            for ($i=0;$i<count($request['unit-code']);$i++) {
                $item_id = Item::where('code', $request['unit-code'][$i])->first()->id;
                InvoiceItem::create([
                    'invoice_id' => $request['invoice-no'],
                    'item_id' => $item_id,
                    'quantity' => $request['unit-quantity'][$i],
                ]);
            }
        }

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_invoice_to_html($request->all()));
        return $pdf->stream();
    }

    public function convert_invoice_to_html($content) {
        $output = "
<!DOCTYPE html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
    <link href='https://cdn.usebootstrap.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>

</head>
<body>
<div class='my-container' style=''>
            <div class='row' style='padding-left: 3rem'>
                <div class='col-xs-9'>
                    <h1>Generator and Marine Services</h1>
                </div>
                <div class='col-xs-2'>
                    <h5>Invoice No. <span style='color: red'>". $content['invoice-no'] ."</span></h5>
                </div>
            </div>

            <div style='font-size: 16px'>
                <p>Kfardebian 76-230313 03-113456 03-123112</p>
                <a style='margin-top: 0'>eliobteich115@gmail.com</a>
                <p style='margin-bottom: 0'>Mof: #1123314 Rc: #2124341 Baabda</p>
            </div>

            <div class='row align-items-end' style='padding-bottom: 10px'>
                <div class='col-xs-9' style='position: relative'>
                    <hr class='my-hr'>
                </div>
                <div class='col-xs-2' style='position: absolute; margin: 0; padding: 0; top: 125px; right: 100px'>
                    <h1>Invoice</h1>
                </div>
            </div>

            <div class='row' style='border: yellow 1px solid; height: 100px; width: 95.5%; margin-bottom: 35px'>
                    <div class='col-xs-7'>
                        <div id='customer-table' style='position: relative; border: #dee2e6 solid 1px'>
                            <div class='customer-table-header' style='font-weight: bold'>Customer</div>
                            <div class='customer-table-body' style='position: absolute; top: 38.5px'>
                                <div class='customer-table-keys' style='width: 30%; display: inline-block; border: #dee2e6 solid 1px; margin-right: 0'>
                                    <div class='customer-table-row' style='padding-left: 3px'>Name</div>
                                    <div class='customer-table-row' style='padding-left: 3px'>Address</div>
                                    <div class='customer-table-row' style='padding-left: 3px'>MOF</div>
                                    <div class='customer-table-row' style='padding-left: 3px'>Phone</div>
                                </div>
                                <div class='customer-table-values' style='width: 68.5%; display: inline-block; margin-left: 0'>
                                    <div class='customer-table-row' style='padding-left: 3px'>". $content['customer-name'] ."</div>
                                    <div class='customer-table-row' style='padding-left: 3px'>". $content['customer-address'] ."</div>
                                    <div class='customer-table-row' style='padding-left: 3px'>". '#'.$content['customer-mof'] ."</div>
                                    <div class='customer-table-row' style='padding-left: 3px'>". $content['customer-phone'] ."</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-xs-5'>
                        <div id='misc-table'>
                            <div class='misc-table-header' style='font-weight: bold'>Misc</div>
                            <div class='misc-table-body' style='position: absolute; top: 34px'>
                                <div class='misc-table-keys' style='width: 30%; display: inline-block; border: #dee2e6 solid 1px; margin-right: 0'>
                                    <div class='misc-table-row' style='padding-left: 3px'>Date</div>
                                    <div class='misc-table-row' style='padding-left: 3px'>Generator</div>
                                    <div class='misc-table-row' style='padding-left: 3px'>ID#</div>
                                </div>
                                <div class='misc-table-values' style='width: 68.5%; display: inline-block; margin-left: 0'>
                                    <div class='misc-table-row' style='padding-left: 3px'>". $content['invoice-date'] ."</div>
                                    <div class='misc-table-row' style='padding-left: 3px'>". $content['generator'] ."</div>
                                    <div class='misc-table-row' style='padding-left: 3px'>". $content['customer-id'] ."</div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class='row my-4'>
                <div class='col-xs-12'>
                    <div class='table-wrapper w-100'>
                        <table class='my-table w-100'>
                            <thead>
                            <tr>
                                <th width='8%'>Code</th>
                                <th width='5%'>Qty</th>
                                <th width='47%'>Description</th>
                                <th width='20%'>Unit Price</th>
                                <th width='20%'>TOTAL</th>
                            </tr>
                            </thead>
                            <tbody>";
                            if (isset($content['unit-code'])) {
                                for ($i = 0; $i < count($content['unit-code']); $i++) {
                                    $output .= "<tr>
                                    <td style='text-align: center'>" . $content['unit-code'][$i] . "</td>
                                    <td style='text-align: center'>" . $content['unit-quantity'][$i] . "</td>
                                    <td style='padding-left: 3px'>" . $content['unit-description'][$i] . "</td>
                                    <td style='padding-left: 3px'>" . $content['unit-price'][$i] . "</td>
                                    <td style='padding-left: 3px'>" . $content['total-price'][$i] . "</td>
                                </tr>";
                                }
                            }
                            $output .= "

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class='row' style='width: 95.5%'>
                <div class='col-xs-7'>
                    <div class='payment-explained'>
                        <div class='payment-title'>
                            Payment
                        </div>
                        <div class='payment-body'>
                            ". $content['total-in-words'] ."
                        </div>
                    </div>
                    <div class='payment-type' style='margin-top: 5px'>
                        Payment Type: ". PaymentType::where('id', $content['payment-type'])->first()->description  ."
                    </div>
                </div>
                <div class='col-xs-5'>
                    <div class='calculation'>
                        <div class='calculation-keys'>
                            <div class='calculation-row'>SubTotal</div>
                            <div class='calculation-row'>VAT 11%</div>
                            <div class='calculation-row'>C/V</div>
                            <div class='calculation-row'>Discount</div>
                            <div class='calculation-row' style='border: none'>TOTAL TTC</div>
                        </div>
                        <div class='calculation-values'>
                            <div class='calculation-row'>". $content['subtotal'] ."</div>
                            <div class='calculation-row'>". $content['vat'] ."</div>
                            <div class='calculation-row'>". $content['cv'] ."</div>
                            <div class='calculation-row'>". $content['discount'] ."</div>
                            <div class='calculation-row' style='border: none'>". $content['total'] ."</div>
                        </div>
                    </div>
                </div>
            </div>
     </div>
</body>

<style>

.calculation-keys .calculation-row {
    font-weight: bold;
}

.calculation-values .calculation-row {
    padding-left: 3px;
}

.payment-explained {
    width: 100%;
    border: black solid 1px;
    height: 60px;
}

.payment-title {
    text-align: center;
    width: 20%;
    height: 50px;
    padding-top: 35px;
    display: inline-block;
    font-weight: bold;
}

.payment-body {
    width: 80%;
    height: 60px;
    padding-top: 15px;
    display: inline-block;
}

.calculation {
    width: 97%;
    margin-top: 21px;
}

.calculation-keys {
    width: 50%;
    border: black 1px solid;
    display: inline-block;
    text-align: center;
}

.calculation-values {
    display: inline-block;
    border: black solid 1px;
    width: 50%;
}

.calculation-row {
    border-bottom: black solid 1px;
    height: 20px;
}

.justify-content-between{-ms-flex-pack:justify!important;justify-content:space-between!important}
.my-container {
    margin: 0 10px 0 10px;
}

#customer-table {
    border: #dee2e6 solid 1px;
}

.customer-table-header {
    border: #dee2e6 solid 1px;
    height: 20px;
    color: black;
}

.customer-table-row {
    border: #dee2e6 solid 1px;
    height: 20px;
}

.misc-table-row {
    border: #dee2e6 solid 1px;
    height: 20px;
}

#misc-table {
    border:  #dee2e6 solid 1px;
}

.my-hr {
    height: 3px;
    width: 100%;
    margin-left: 0;
    background: black;
}

.input-info {
    width: 100%;
    background: none;
    border: none;
    outline: none;
}

.my-table thead {
    width: 100%;
}

.table-wrapper {
    position: relative;
    max-height: 450px;
    overflow-y: auto;
}

td input {
    background: none;
    border: none;
    width: 100%;
}

.my-table {
    border: black 1px solid;
}

.my-table td{
    border-right: black 1px solid;
    border-left: black 1px solid;
}

.my-table thead th {
    text-align: center;
    border: black solid 1px;
}
.my-table tbody td:first-child {
    text-align: center;
}

.total-table-wrapper {
    padding: 0 15px;
    flex-direction: row;
    width: calc(30% + 21px);
}

.total-table {
    border: black solid 1px;
    width: 100%;
}

.total-table tr {
    border: black 1px solid;
}

.total-table th {
    text-align: center;
    border-right: black 1px solid;
}

/* Chrome, Safari, Edge, Opera */
.my-table input::-webkit-outer-spin-button,
.my-table input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
.my-table input[type=number] {
    -moz-appearance: textfield;
}

</style>

</html>
";
        return $output;
    }
}
