<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Orders;
use App\Bankmember_Trans;
use Auth;
use App\Notifications\InvoicePaid;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
      * sql = SELECT oke_orders.*, oke_products.name FROM `oke_orders` JOIN oke_products ON product_id = oke_products.id
            WHERE order_id = 0 AND oke_orders.type = 'BUY' AND oke_orders.id  NOT IN
            (
                SELECT order_id  FROM oke_orders WHERE order_id != 0
            )
     *
     */


    public function index()
    {


        $id_login = -1;

        if(Auth::check()){
            $id_login = Auth::user()->id;
        }

        $product_buy = Orders::select(DB::raw('ok_orders.*') )
                        ->whereRaw("order_id = 0 AND  ok_orders.type = 'BUY' AND ok_orders.id NOT IN ( SELECT order_id FROM ok_orders WHERE order_id != 0 )")
                        ->get()
                        ->toArray();

        $product_sell = Orders::select(DB::raw('ok_orders.*') )
                        ->whereRaw("order_id = 0 AND  ok_orders.type = 'SELL' AND ok_orders.id NOT IN ( SELECT order_id FROM ok_orders WHERE order_id != 0 )")
                        ->get()
                        ->toArray();

         $product_order = Bankmember_Trans::select(DB::raw('ok_bankmember_trans.*, ok_orders.product_name'))
                        ->join('ok_orders', 'ok_orders.id', '=', 'ok_bankmember_trans.order_id')
                        ->whereRaw("ok_bankmember_trans.type = 'BUY' or ok_bankmember_trans.type = 'SELL'")
                        ->get();
                        ;

                        // dd($product_order);

        return view('user.home.dashboard', compact(
                                                    'product_buy',
                                                    'product_sell',
                                                    'product_order'
        ));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {

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

    public function isFullInformation()
    {
        $data =  Auth::user()->toArray();
        foreach ($data as $key => $value) {
           if (empty($value)) return false;
        }
        return true;
    }
}
