<?php

namespace App\Http\Controllers;

use App\Models\FreeIssue;
use App\Models\Product;
use Illuminate\Http\Request;

class FreeIssueController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $freeissueproducts = FreeIssue::all();
        return view('freeissuedefine', compact('products', 'freeissueproducts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'freeissue_lable' => 'required',
            'purchese_product' => 'required',
            'free_product' => 'required',
            'purches_qty' => 'required',
            'freeqty' => 'required',
            'lowerlimit' => 'required',
            'upperlimit' => 'required',
        ]);

        $freeissuedefin = new FreeIssue();

        $freeissuedefin->lable = $request->freeissue_lable;
        $freeissuedefin->purchase_product = $request->purchese_product;
        $freeissuedefin->freeproduct = $request->free_product;
        $freeissuedefin->purchesqty = $request->purches_qty;
        $freeissuedefin->freeqty = $request->freeqty;
        $freeissuedefin->lowlim = $request->lowerlimit;
        $freeissuedefin->upperlim = $request->upperlimit;

        $freeissuedefin->save();

        $products = Product::all();
        $freeissueproducts = FreeIssue::all();
        return view('freeissuedefine', compact('freeissueproducts', 'products'));
    }

    public function viewFreedefine($id)
    {
        $freedefine = FreeIssue::find($id);

        if ($freedefine) {
            return response()->json([
                'status' => 200,
                'freedefine' => $freedefine,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "The Id is not found",
            ]);
        }
    }

    public function editfreeissue(Request $request)
    {
        $id = $request->id;

        if (FreeIssue::where("id", $id)->exists()) {
            $freeissue = FreeIssue::find($id);

            $freeissue->lable = $request->label;
            $freeissue->purchase_product = $request->purches_product;
            $freeissue->freeproduct = $request->free_product;
            $freeissue->purchesqty = $request->purchqty;
            $freeissue->freeqty = $request->freeqty;
            $freeissue->lowlim = $request->lowlimit;
            $freeissue->upperlim = $request->upperlimit;

            $freeissue->save();

            return response()->json([
                'status' => 200,
                'message' => "Update successfull",
            ]);
        }
    }
}
