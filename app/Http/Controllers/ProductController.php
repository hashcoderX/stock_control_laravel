<?php

namespace App\Http\Controllers;

use App\Models\FreeIssue;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function addProduct(Request $request)
    {
        $this->validate($request, [
            'prcode' => 'required',
            'prlongname' => 'required|max:255',
            'prshortname' => 'required|max:255',
            'expirydate' => 'required',
            'price' => 'required'
        ]);

        $product = new Product();

        $product->product_code = $request->prcode;
        $product->product_long_name = $request->prlongname;
        $product->Product_short_name = $request->prshortname;
        $product->expiry_date = $request->expirydate;
        $product->price = $request->price;

        $product->save();
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function viewAll()
    {
        $products = Product::all();
        return view('product', compact('products'));

        return response()->json([
            'status' => 200,
            'product' => $products,
        ]);
    }

    public function viewProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "The product is not found",
            ]);
        }
    }

    public function viewProductprcode($prcode)
    {
        $product = Product::where('product_code', $prcode)->first();

        // $productid = $product['product_long_name'];

        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "The product is not found",
            ]);
        }
    }

    public function viewProductfreeissue($name)
    {
        $product = Product::where('product_long_name', $name)->first();
        if (FreeIssue::where('purchase_product', $product['product_long_name'])->exists()) {
            $freeissue = FreeIssue::where('purchase_product', $product['product_long_name'])->first();
            return response()->json([
                'status' => 200,
                'freeissue' => $freeissue,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No free issue",
            ]);
        }
    }

    public function edit(Request $request)
    {

        $id = $request->id;

        if (Product::where("id", $id)->exists()) {
            $product = Product::find($id);

            $product->product_code = $request->product_code;
            $product->product_long_name = $request->product_long_name;
            $product->Product_short_name = $request->Product_short_name;
            $product->expiry_date = $request->expiry_date;
            $product->price = $request->price;

            $product->save();

            return response()->json([
                'status' => 200,
                'message' => "Product Details update successfull",
            ]);
        }
    }
}
