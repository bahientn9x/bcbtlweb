<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Orders;
use App\Bankmember_Trans;
use App\Members;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Orders::where('order_id', '0')->orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
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
    public function show($id)
    {
        $order = Orders::find($id);
        $orderTrans = Orders::where('order_id', $order->id)->first();
        $stateOrder = [
            'deposit' => false,
            'sent' => false,
            'received' => false,
            'complete' => false,
        ];
        if($order->states == 'SENT') $stateOrder['sent'] = true;
        if($order->states == 'RECEIVED') $stateOrder['received'] = true;
        if(!empty($orderTrans)) {
            $member['member'] = $orderTrans->members;
            $member['trans'] = Bankmember_Trans::where([
                    [ 'order_id', $order->id ],
                    ['type', 'SELL'],
                ])->orWhere([
                    [ 'order_id', $order->id ],
                    ['type', 'BUY'],
                ])->first();
            switch ($orderTrans->states) {
                case 'SENT':
                $stateOrder['deposit'] = true;
                $stateOrder['sent'] = true;
                break;
                case 'RECEIVED':
                $stateOrder['deposit'] = true;
                $stateOrder['sent'] = true;
                $stateOrder['received'] = true;
                break;
            }
            if(!empty($member['trans'])){
                if ($member['trans']->states == 2) {
                    $stateOrder['deposit'] = true;
                    $stateOrder['sent'] = true;
                    $stateOrder['received'] = true;
                    $stateOrder['complete'] = true;
                }
            }
        }
        return view('admin.order.detail', compact(['order', 'stateOrder', 'member']));
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
        $trans = Bankmember_Trans::find($id);
        $member = Members::find($trans->receiver_id);
        $order = Orders::find($trans->order_id);
        $orderTwo = Orders::where('order_id', $order->id)->first();
        if($request->check_type == "success") {
            $trans->states = 2;
            $member->balance = $member->balance + $trans->total;
        }
        else {
            $trans->states = 0;
            $member->balance = $member->balance - $trans->total;
        }
        $trans->save();
        $order->save();
        $orderTwo->save();
        $member->save();

        $notifi = array(
            "title" => "Đơn hàng $order->product_name đã được admin xác nhận",
            "link" => "profile/order-status/$order->id",
            "icon" => "fa fa-check-circle"
        );

        Members::find($trans->sender_id)->notify(new InvoicePaid($notifi));
        Members::find($trans->receiver_id)->notify(new InvoicePaid($notifi));

        return back()->with('notify','Thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Orders::find($id);
        if($order->delete()) return back()->with('notify', 'Thành công');
    }
}
