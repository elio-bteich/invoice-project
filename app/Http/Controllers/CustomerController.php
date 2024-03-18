<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::all();
        return view('customers', compact('customers'));
    }

    public function create(Request $request) {
        Customer::create([
            'name' => $request['name'],
            'address' => $request['address'],
            'mof' => $request['mof'],
            'phone_number' => $request['phone_number']
        ]);

        return redirect('/')->with('success', 'Customer registered successfully');
    }

    public function search($query = '') {
        if ($query != '') {
            $customers = Customer::select('name', 'id')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(7)
                ->get();
            $customers_list = '<ul>';
            if (count($customers) > 0) {
                foreach ($customers as $customer) {
                    $customers_list .= '<li class="customers-list-item" value="'.$customer->id.'">' . $customer->name . '</li>';
                }
                $message = 'not empty';
            }else{
                $message = 'empty';
            }
            $customers_list .= '</ul>';
        }
        return response()->json([
            'customers_list' => $customers_list,
            'message' => $message,
        ]);
    }

    public function fetch(Customer $customer) {
        return response()->json([
            'customer' => $customer
        ]);
    }

    public function getCustomersByName($query) {
        if (trim($query) != '') {
            $customers = Customer::where('name', 'LIKE', '%'.$query.'%')->get();
            return response()->json([
                'customers' => $customers
            ]);
        }
        $customers = Customer::all();
        return response()->json([
            'customers' => $customers
        ]);
    }
}
