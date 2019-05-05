<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      return view('forms._new_product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

      $price = filter_var($request->get('price'), FILTER_VALIDATE_INT);
      $quantity = filter_var($request->get('quantity'), FILTER_VALIDATE_INT);

      $productStore = Storage::disk('public')->exists('products.json') ? json_decode(Storage::disk('public')->get('products.json')) : [];

      $inputData = $request->only(['productname', 'quantity', 'price']);

      $inputData['datetime_submitted'] = Carbon::now()->toFormattedDateString();

      /* Calculate */
      $inputData['total_value'] = ($price * $quantity);

      array_push($productStore,$inputData);

      Storage::disk('public')->put('products.json', json_encode($productStore));

      return response()->json(['R' => 'Got it 👍', 'Productname' => $request->get('productname'), 'Quantity' => $quantity, 'Price' => $price ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
