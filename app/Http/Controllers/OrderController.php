<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('order', compact('customers'));
    }

    public function placeOrder(Request $request)
    {
        $cutomerid = $request->cusname;
        $numberrow = count($request->netamountt);

        $order = new Order();
        $order->customer_no = $request->cusname;
        $order->netamount = $request->totalamount;

        $order->save();

        $mexid = DB::table('orders')->max('id');

        for ($i = 0; $i <  $numberrow; $i++) {
            $order_item = new OrderItem();

            $order_item->orderid = $mexid;
            $order_item->productname = $request->productnamet[$i];
            $order_item->qty = $request->qtyt[$i];
            $order_item->freeproduct = $request->freeproductt[$i];
            $order_item->freeqty = $request->freeqtyt[$i];
            $order_item->netamount = $request->netamountt[$i];

            $order_item->save();
        }

        return response()->json([
            'status' => 200,
            'message' => "Order Successfull",
        ]);
    }

    public function viewOrder()
    {
        $orderid = "";
        $orders = DB::select("SELECT orders.id,orders.netamount,customers.customer_name,customers.address,customers.contact_no from orders INNER JOIN customers ON orders.customer_no = customers.id;");
        foreach ($orders as $order) {
            $orderid = $order->id;
            $orderitems = DB::select("SELECT * FROM `order_items` WHERE `orderid`='$orderid'");
        }

        return view('vieworder', compact('orders', 'orderitems'));
    }

    public function orderDetails($id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::find($id);
        $customerdetails = Customer::where('id', $order->customer_no)->first();

        // $this->loadOrderItems($order->id);

        if ($order) {
            return response()->json([
                'status' => 200,
                'order' => $order,
                'customer' => $customerdetails,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "The Order is not found",
            ]);
        }
    }


    public function orderProductDetails($orderid)
    {
        // echo $orderid;
        $orderItems = DB::select("SELECT * FROM `order_items` WHERE `orderid`='$orderid'");

        return response()->json([
            'status' => 200,
            'orderitems' => $orderItems,
        ]);
    }
}
