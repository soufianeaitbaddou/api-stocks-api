<?php

namespace App\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\order;
use App\client;
use Illuminate\Http\Request;

class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        return OrderResource::collection($orders);
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
            'stock_id' => 'required|exists:stocks,id',
            'client_id' => 'required|exists:clients,id',
            'cost_confirmation' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_delivery' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'qte' => 'required|integer',
        ];
        $request->validate($rules);
        $input = $request->all();
        $input['state'] = Order::NEW_ORDER_STATUS;
        $order = Order::create($input);
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return new OrderResource($order);
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
        $order = Order::findOrFail($id);

        $data = json_decode($request->getContent());

        foreach ($data as $key => $value) {
            $order[$key] = $value;
        }

        if (!$order->isDirty()) {
            return $this->errorResponse('You need to specify any different value to update', 422);
        }
        $order->save();
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return 'deleted';
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWithClient(Request $request)
    {
        $rules = [
            'stock_id' => 'required|exists:stocks,id',
            'cost_confirmation' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_delivery' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'qte' => 'required|integer',
            'client' => 'required',
            'client.name' => 'required|string',
            'client.city' => 'required|string',
            'client.tel' => 'required|string',
        ];
        $request->validate($rules);

        $input = $request->all();
        $input['state'] = Order::NEW_ORDER_STATUS;
        $order = Client::create($input['client'])->orders()->create($input );
        return new OrderResource($order);
    }
}
