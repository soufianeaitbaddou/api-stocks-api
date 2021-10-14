<?php

namespace App\Http\Controllers\Stocks;

use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;
use App\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all();
        return StockResource::collection($stocks);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'price_purchase' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'price_sale' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_transport' => 'regex:/^\d+(\.\d{1,2})?$/',
            'cost_package' => 'regex:/^\d+(\.\d{1,2})?$/',
            'qte' => 'integer',
        ];
        $request->validate($rules);
        $input = $request->all();
        $input['qte_left'] = $input['qte'];
        $stock = Stock::create($input);
        return new StockResource($stock);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return new StockResource($stock);
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
        $stock = Stock::findOrFail($id);

        $data = json_decode($request->getContent());

        foreach ($data as $key => $value) {
            $stock[$key] = $value;
        }

        if (!$stock->isDirty()) {
            return $this->errorResponse('You need to specify any different value to update', 422);
        }
        $stock->save();
        return new StockResource($stock);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);

        $stock->delete();

        return 'deleted';
    }
}
