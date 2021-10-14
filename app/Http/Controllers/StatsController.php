<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\order;

class StatsController extends Controller
{
    public function index()
    {

           $CONFIRMED_STATUS = Order::where('state',order::CONFIRMED_STATUS)->get();

           $CONFIRMED_STATUS_Total = $CONFIRMED_STATUS->sum(function($value) {
                return $value->getTotal();
            });
           $CONFIRMED_STATUS_Cost = $CONFIRMED_STATUS->sum(function($value) {
                return $value->getCost();
            });
           $CONFIRMED_STATUS_Net = $CONFIRMED_STATUS->sum(function($value) {
                return $value->getNet();
            });

        $CANCELLED_STATUS = Order::where('state',order::CANCELLED_STATUS)->get();

                   $CANCELLED_STATUS_Total = $CANCELLED_STATUS->sum(function($value) {
                return $value->getTotal();
            });
           $CANCELLED_STATUS_Cost = $CANCELLED_STATUS->sum(function($value) {
                return $value->getCost();
            });
           $CANCELLED_STATUS_Net = $CANCELLED_STATUS->sum(function($value) {
                return $value->getNet();
            });
        $DELIVERED_STATUS = Order::where('state',order::DELIVERED_STATUS)->get();
                           $DELIVERED_STATUS_Total = $DELIVERED_STATUS->sum(function($value) {
                return $value->getTotal();
            });
           $DELIVERED_STATUS_Cost = $DELIVERED_STATUS->sum(function($value) {
                return $value->getCost();
            });
           $DELIVERED_STATUS_Net = $DELIVERED_STATUS->sum(function($value) {
                return $value->getNet();
            });
        $PAID_STATUS = Order::where('state',order::PAID_STATUS)->get();
                           $PAID_STATUS_Total = $PAID_STATUS->sum(function($value) {
                return $value->getTotal();
            });
           $PAID_STATUS_Cost = $PAID_STATUS->sum(function($value) {
                return $value->getCost();
            });
           $PAID_STATUS_Net = $PAID_STATUS->sum(function($value) {
                return $value->getNet();
            });
        $NEW_ORDER_STATUS = Order::where('state',order::NEW_ORDER_STATUS)->get();
          $NEW_ORDER_STATUS_Total = $NEW_ORDER_STATUS->sum(function($value) {
                return $value->getTotal();
            });
           $NEW_ORDER_STATUS_Cost = $NEW_ORDER_STATUS->sum(function($value) {
                return $value->getCost();
            });
           $NEW_ORDER_STATUS_Net = $NEW_ORDER_STATUS->sum(function($value) {
                return $value->getNet();
            });



        return response()->json([
        	'CONFIRMED_STATUS_Total' => $CONFIRMED_STATUS_Total, 
        	'CONFIRMED_STATUS_Cost' => $CONFIRMED_STATUS_Total, 
        	'CONFIRMED_STATUS_Net' => $CONFIRMED_STATUS_Total,

        	'CANCELLED_STATUS_Total' => $CANCELLED_STATUS_Total, 
        	'CANCELLED_STATUS_Net' => $CANCELLED_STATUS_Net, 
        	'CANCELLED_STATUS_Net' => $CANCELLED_STATUS_Net, 

        	'NEW_ORDER_STATUS_Total' => $NEW_ORDER_STATUS_Total, 
        	'NEW_ORDER_STATUS_Cost' => $NEW_ORDER_STATUS_Cost, 
        	'NEW_ORDER_STATUS_Net' => $NEW_ORDER_STATUS_Net, 

        	'DELIVERED_STATUS_Total' => $DELIVERED_STATUS_Total, 
        	'DELIVERED_STATUS_Cost' => $DELIVERED_STATUS_Cost, 
        	'DELIVERED_STATUS_Net' => $DELIVERED_STATUS_Net, 

        	'PAID_STATUS_Total' => $PAID_STATUS_Total, 
        	'PAID_STATUS_Cost' => $PAID_STATUS_Cost, 
        	'PAID_STATUS_Net' => $PAID_STATUS_Net, 

        ], 200);


        return OrderResource::collection($orders);
    }
}
