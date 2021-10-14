<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait ApiResponser
{



    protected function errorResponse($message, $code)
    {
        return response()->json(['message' => [$message]], $code);
    }

    protected function errorResponseWithData($message, $data, $code)
    {
        return response()->json(['message' => $message, 'data' => $data], $code);
    }

    protected function Data($collection)
    {
        $collection = $this->filtredData($collection);
        //$collection = $this->paginate($collection);
        return $collection;
    }
    protected function filtredData($collection)
    {

        foreach (request()->query() as $query => $value) {
            if (isset($query, $value)) {
                $collection = $collection->where($query, $value);
            }
        }

        return $collection;
    }

    protected function paginate(Collection $collection)
    {

        // $page = LengthAwarePaginator::resolveCurrentPage();
        //
        // $results =  $collection->slice( ($page - 1) * $perPage,$perPage)->values();
        // $paginated = new LengthAwarePaginator($results,$collection->count(),$perPage ,$page ,[
        //     'path'=>LengthAwarePaginator::resolveCurrentPage(),
        // ]);
        // $paginated->appends(request()->all());
        $page = null;
        $perPage = 5;
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $collection instanceof Collection ? $collection : Collection::make($collection);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options = []);
    }
}
