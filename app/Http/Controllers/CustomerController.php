<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function index()
   {
      $customers = Customer::all();
      return view('customer', compact('customers'));
   }

   public function store(Request $request)
   {
      $this->validate($request, [
         'cusname' => 'required|max:255',
         'address' => 'required',
         'contactno' => 'required|max:12',
      ]);

      $customer = new Customer();

      $customer->customer_name    = $request->cusname;
      $customer->address    = $request->address;
      $customer->contact_no    = $request->contactno;

      $customer->save();

      $customers = Customer::all();
      return view('customer', compact('customers'));
   }

   public function viewCustomer($id)
   {
      $customer = Customer::find($id);

      if ($customer) {
         return response()->json([
            'status' => 200,
            'customer' => $customer,
         ]);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "The customer is not found",
         ]);
      }
   }

   public function edit(Request $request)
   {

      $id = $request->id;

      if (Customer::where("id", $id)->exists()) {
         $customer = Customer::find($id);

         $customer->customer_name    = $request->cusname;
         $customer->address    = $request->address;
         $customer->contact_no    = $request->contact;

         $customer->save();

         return response()->json([
            'status' => 200,
            'message' => "Product Details update successfull",
         ]);
      }
   }
}
