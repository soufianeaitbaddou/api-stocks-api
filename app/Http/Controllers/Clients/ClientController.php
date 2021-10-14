<?php

namespace App\Http\Controllers\Clients;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Client::query();
         foreach (request()->query() as $query => $value) {
            if ($query != "scope") {
                if (isset($query, $value) && $query != "page" &&  $query != "per_page") {
                    $collection = $collection->where($query, 'like', "%" . $value . "%");
                }
            }
        }
        $data = $collection->get();
        return ClientResource::collection($data);
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
            'name' => 'required|string',
            'city' => 'required|string',
            'tel' => 'required|string',
        ];
        $request->validate($rules);

        $input = $request->all();

        $client = Client::create($input);

        return new ClientResource($client);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return new ClientResource($client);
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

        $client = Client::findOrFail($id);

        $data = json_decode($request->getContent());

        foreach ($data as $key => $value) {
            $client[$key] = $value;
        }

        if (!$client->isDirty()) {
            return $this->errorResponse('You need to specify any different value to update', 422);
        }
        $client->save();
        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        $client->delete();

        return 'deleted';
    }
}
