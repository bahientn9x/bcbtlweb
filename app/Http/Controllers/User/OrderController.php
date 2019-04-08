<?php

namespace App\Http\Controllers\User;

use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Orders;
use App\Bankmember;
use App\Bankmember_Trans;
use App\Members;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders;

        return view('user.profile.manager', compact('orders'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'type' => 'required',
            'address' => 'required',
            'phonenumber' => 'required'
        ]);

        $user = Auth::user()->toArray();
        foreach ($user as $value) {
            if (empty($value)) {
                die('Vui lòng cập nhật đầy đủ thông tin cá nhân để thực hiện giao dịch.');
            }
        }

        $order_current = Orders::find($data['id']);

        $checkOrder = Orders::where('order_id', $data['id'])->get()->toArray();
        if (!empty($checkOrder)) die("Mặt hàng đã có người đặt");

        if (strtoupper($data['type']) == "BUY") {
            if (Auth::user()->balance < $order_current->total) die('Số dư của bạn không đủ để đặt cọc');

            $user = Members::find(Auth::user()->id);
            $user->balance = $user->balance - $order_current->total;
            $user->save();

            $order = new Orders();
            $order->member_id = Auth::user()->id;
            $order->product_name = $order_current->product_name;
            $order->type = $order_current->type;
            $order->num = $order_current->num;
            $order->price = $order_current->price;
            $order->total = $order_current->total;
            $order->order_id = $data['id'];
            $order->address = $data['address'];
            $order->phonenumber = $data['phonenumber'];
            $order->description = '';
            $order->cate_id = 1;
            $order->save();

            $bankmember = new Bankmember_Trans();
            $bankmember->type = $order_current->type;
            $bankmember->total = $order_current->total;
            $bankmember->sender_id = Auth::user()->id;
            $bankmember->receiver_id = $order_current->member_id;
            $bankmember->order_id = $data['id'];
            $bankmember->fee = 0;
            $bankmember->states = 0;
            $bankmember->save();

            $notifi = array(
                'title' => "$order_current->product_name đã có người đặt cọc",
                'link' => "profile/order-status/$order_current->id",
                'icon' => "fa fa-file-text-o"
            );
            Members::find($order_current->member_id)->notify(new InvoicePaid($notifi));

            return redirect("profile/order-status/$order_current->id");
        } else {
            $order = new Orders();
            $order->member_id = Auth::user()->id;
            $order->product_name = $order_current->product_name;
            $order->type = $order_current->type;
            $order->num = $order_current->num;
            $order->price = $order_current->price;
            $order->total = $order_current->total;
            $order->order_id = $data['id'];
            $order->address = $data['address'];
            $order->phonenumber = $data['phonenumber'];
            $order->description = '';
            $order->cate_id = 1;
            $order->save();

            $notifi = array(
                'title' => "$order_current->product_name đã có người mua",
                'link' => "profile/order-status/$order_current->id",
                'icon' => "fa fa-file-text-o"
            );
            Members::find($order_current->member_id)->notify(new InvoicePaid($notifi));

            return redirect("profile/order-status/$order_current->id");
        }
    }

    /**
     *
     * /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        $info_product = Orders::find($id)->toArray();
        $checkOrder = $info_product['type'];

        if ($checkOrder == "SELL") {
            $type = "BUY";
            return view('user.home.buy', compact(['info_product', 'id', 'type']));
        }

        $type = "SELL";
        return view('user.home.sell', compact(['info_product', 'id', 'type']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (Orders::find($id)->delete()) ? redirect('profile/manager')->with('notify', 'Thành công') : redirect('profile/manager')->with('notify', 'Gặp sự cố');
    }


    /**
     * @param Request $request
     * kiểm tra đơn hàng đã được đặt cọc , số dư của người mua trước khi đặt cọc để mua hàng.
     */
    public function checkOrder(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'type' => 'required',
        ]);

        $order_current = Orders::find($data['id']);
        $checkOrder = Orders::where('order_id', $data['id'])->get()->toArray();

        if (!empty($checkOrder)) {
            $respon = array(
                'status' => false,
                'flag' => 1,
                'messenge' => 'Mặt hàng đã có người đặt cọc.'
            );
            die(json_encode($respon));
        } else if (strtoupper($data['type']) == 'BUY') {
            if (Auth::user()->balance < $order_current->total) {
                $respon = array(
                    'status' => false,
                    'flag' => 2,
                    'messenge' => 'Số dư của bạn không đủ để đặt cọc, vui lòng nạp thêm tiền.'
                );
                die(json_encode($respon));
            } else {
                $respon = array(
                    'status' => true,
                    'messenge' => 'Mặt hàng chưa có người đặt.'
                );
                die(json_encode($respon));
            }
        } else {
            $respon = array(
                'status' => true,
                'messenge' => 'Mặt hàng chưa có người đặt.'
            );
            die(json_encode($respon));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Đặt cọc mặt hàng, trừ tiền trong balance của user và tạo ra 1 bảng ghi trong bankmember_trans
     * có type là type của mặt hàng đăng, người đặt cọc và người nhận tiền cọc.
     */
    public function depositOrder(Request $request)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);
        $order = Orders::find($data['id']);
        $info_order = Orders::where('order_id', $data['id'])->first();
        $deposit = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 0])->first();
        $complete = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 2])->where('type', '!=', "GETBACK")->first();

        if (!empty($order) && !empty($info_order)) {
            if (empty($deposit) && empty($complete)) {
                if (($order->member_id == Auth::user()->id && $order->type == "SELL")
                    || ($info_order->member_id == Auth::user()->id && $order->type == "SELL")) {
                    $sender_id = $info_order->member_id;
                    $receiver_id = $order->member_id;
                } else if (($order->member_id == Auth::user()->id && $order->type == "BUY")
                    || ($info_order->member_id == Auth::user()->id && $order->type == "BUY")) {
                    $sender_id = $order->member_id;
                    $receiver_id = $info_order->member_id;
                }

                $user = Members::find(Auth::user()->id);
                $user->balance = $user->balance - $order->total;
                $user->save();

                $bankmember_trans = new Bankmember_Trans();
                $bankmember_trans->type = $order->type;
                $bankmember_trans->sender_id = $sender_id;
                $bankmember_trans->receiver_id = $receiver_id;
                $bankmember_trans->order_id = $order->id;
                $bankmember_trans->total = $order->total;
                $bankmember_trans->states = 0;
                $bankmember_trans->save();

                $notifi = array(
                    'title' => "$order->product_name đã được đặt cọc",
                    'link' => "profile/order-status/$order->id",
                    'icon' => "fa fa-money"
                );
                Members::find($receiver_id)->notify(new InvoicePaid($notifi));

                return redirect('profile/order-status/' . $order->id);
            } else die('Đơn hàng đã được đặt cọc');
        } else die('Đơn hàng không tồn tại');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Xác nhận đơn hàng đã được gửi, kiểm tra trạng thái của đơn hàng trước khi xác nhận.
     */
    public function confirmSent(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'img_sent' => 'required'
        ]);
        $order = Orders::find($data['id']);
        $info_order = Orders::where('order_id', $data['id'])->first();
        $deposit = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 0])->first();
        $complete = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 2])->where('type', '!=', "GETBACK")->first();
        if (!empty($order) && !empty($info_order) && !empty($deposit) && empty($complete)) {
            $member_id = 0;
            if($info_order->member_id != Auth::user()->id && $order->member_id != Auth::user()->id)
                die('Mặt hàng không thuộc giao dịch của bạn');

            if (($request->hasFile('img_sent'))) {
                $extend = $request->file('img_sent')->getClientOriginalExtension();
                $sizeimg = $request->file('img_sent')->getSize();
                if ($extend == "jpg" || $extend == "jpeg" || $extend == "png" || $extend == "gif") {
                    if ($sizeimg < 20000000) {
                        $fileExtension = $request->file('img_sent')->getClientOriginalExtension();
                        $fileName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999)) . "." . $fileExtension;
                        $request->file('img_sent')->move('img', $fileName);
                    } else {
                        $respon = array(
                            'status' => false,
                            'messenge' => 'Kích thước file quá lớn. Chỉ chấp nhận file nhỏ hơn 20MB'
                        );
                        die(json_encode($respon));
                    }
                } else {
                    $respon = array(
                        'status' => false,
                        'messenge' => 'Loại file không đúng. Chỉ chấp nhận file hình ảnh'
                    );
                    die(json_encode($respon));
                }
            } else {
                $respon = array(
                    'status' => false,
                    'messenge' => 'Ảnh không tồn tại'
                );
                die(json_encode($respon));
            }
            if ($order->member_id == Auth::user()->id && strtoupper($order->type) == "SELL") {
                $member_id = $info_order->member_id;
                $order->states = "SENT";
                $order->img_sent = 'img/'.$fileName;
                $order->save();
            } else if ($info_order->member_id == Auth::user()->id && strtoupper($order->type) == "BUY") {
                $member_id = $order->member_id;
                $info_order->states = "SENT";
                $info_order->img_sent = 'img/'.$fileName;
                $info_order->save();
            }

            $notifi = array(
                'title' => "Đơn hàng $order->product_name đã được gửi đi.",
                'link' => "profile/order-status/$order->id",
                'icon' => "fa fa-file-text-o"
            );
            Members::find($member_id)->notify(new InvoicePaid($notifi));

            return redirect('profile/order-status/' . $order->id);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Xác nhận đơn hàng đã nhận được, kiểm tra trạng thái của đơn hàng trước khi xác nhận.
     */

    public function confirmReceived(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'img_recv' => 'required'
        ]);

        $order = Orders::find($data['id']);
        $info_order = Orders::where('order_id', $data['id'])->first();
        $deposit = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 0])->first();
        $complete = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 2])->where('type', '!=', "GETBACK")->first();
        $member_id = 0;
        if (!empty($order) && !empty($info_order) && !empty($deposit) && empty($complete)
            && (strtoupper($order->states) == "SENT" || strtoupper($info_order->states) == "SENT" )) {

            if($info_order->member_id != Auth::user()->id && $order->member_id != Auth::user()->id)
                die('Mặt hàng không thuộc giao dịch của bạn');

            if (($request->hasFile('img_recv'))) {
                $extend = $request->file('img_recv')->getClientOriginalExtension();
                $sizeimg = $request->file('img_recv')->getSize();
                if ($extend == "jpg" || $extend == "jpeg" || $extend == "png" || $extend == "gif") {
                    if ($sizeimg < 10000000) {
                        $fileExtension = $request->file('img_recv')->getClientOriginalExtension();
                        $fileName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999)) . "." . $fileExtension;
                        $request->file('img_recv')->move('img', $fileName);
                    } else {
                        $respon = array(
                            'status' => false,
                            'messenge' => 'Kích thước file quá lớn. Chỉ chấp nhận file nhỏ hơn 10MB'
                        );
                        die(json_encode($respon));
                    }
                } else {
                    $respon = array(
                        'status' => false,
                        'messenge' => 'Loại file không đúng. Chỉ chấp nhận file hình ảnh'
                    );
                    die(json_encode($respon));
                }
            } else {
                $respon = array(
                    'status' => false,
                    'messenge' => 'Ảnh không tồn tại'
                );
                die(json_encode($respon));
            }

            if ($order->member_id == Auth::user()->id && strtoupper($order->type) == "BUY") {
                $member_id = $info_order->member_id;
                $order->states = "RECEIVED";
                $order->img_recv = 'img/'.$fileName;
                $order->save();
            } else if ($info_order->member_id == Auth::user()->id && strtoupper($order->type) == "SELL") {
                $member_id = $order->member_id;
                $info_order->states = "RECEIVED";
                $info_order->img_recv = 'img/'.$fileName;
                $info_order->save();
            }

            $notifi = array(
                'title' => "Đơn hàng $order->product_name đã nhận được.",
                'link' => "profile/order-status/$order->id",
                'icon' => "fa fa-file-text-o"
            );
            Members::find($member_id)->notify(new InvoicePaid($notifi));

            return redirect('profile/order-status/' . $order->id);
        }
    }

    /**
     * @param Request $request
     * Hủy giao dịch mua bán , chỉ dược hủy khi đơn hàng chưa được vận chuyển
     */
    public function destroyTrans(Request $request){
        $data = $request->validate([
            'id' => 'required'
        ]);

        $order = Orders::find($data['id']);
        $info_order = Orders::where('order_id', $data['id'])->first();
        $deposit = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 0])->first();
        $complete = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 2])->where('type', '!=', "GETBACK")->first();

        if(!empty($complete)){
            $respon = array(
                'status' => false,
                'messenge' => 'Không thể hủy giao dịch khi đơn hàng đã được vận chuyển'
            );
            die(json_encode($respon));
        }

        $symbol = 'đ';
        $symbol_thousand = '.';
        $decimal_place = 0;
        $price = number_format($order->total, $decimal_place, '', $symbol_thousand);
        $price = $price.$symbol;

        if(!empty($info_order)){
            if($info_order->member_id != Auth::user()->id && $order->member_id != Auth::user()->id){
                $respon = array(
                    'status' => false,
                    'messenge' => 'Mặt hàng không thuộc giao dịch của bạn'
                );
                die(json_encode($respon));
            }

            if ((strtoupper($info_order->states) != "SENT" && strtoupper($info_order->states) != "RECEIVED")
                && (strtoupper($order->states) != "SENT" && strtoupper($order->states) != "RECEIVED")){
                    if(!empty($deposit)){
                        if(strtoupper($order->type) == "SELL"){
                            Bankmember_Trans::where(['order_id' => $order->id, 'states' => 0])->delete();

                            $bank_trans = new Bankmember_Trans();
                            $bank_trans->type = "GETBACK";
                            $bank_trans->sender_id = $order->member_id;
                            $bank_trans->receiver_id = $info_order->member_id;
                            $bank_trans->order_id = $order->id;
                            $bank_trans->total = $order->total;
                            $bank_trans->states = 1;
                            $bank_trans->save();

                            $user = Members::find($info_order->member_id);
                            $user->balance = $user->balance + $order->total;
                            $user->save();

                            Orders::where('order_id', $order->id)->delete();

                            $notifi = array(
                                'title' => "Hoàn trả $price tiền đặt cọc đơn hàng $order->product_name do đơn hàng bị hủy.",
                                'link' => "profile/history",
                                'icon' => 'fa fa-money'
                            );
                            Members::find($info_order->member_id)->notify(new InvoicePaid($notifi));
                            Members::find($order->member_id)->notify(new InvoicePaid($notifi));

                            $respon = array(
                                'status' => true,
                                'messenge' => "Hủy giao dịch thành công. Hoàn trả $price tiền đặt cọc"
                            );
                            die(json_encode($respon));
                        }
                        else if(strtoupper($order->type) == "BUY"){
                            Bankmember_Trans::where(['order_id' => $order->id, 'states' => 0])->delete();

                            $bank_trans = new Bankmember_Trans();
                            $bank_trans->type = "GETBACK";
                            $bank_trans->sender_id = $info_order->member_id;
                            $bank_trans->receiver_id = $order->member_id;
                            $bank_trans->order_id = $order->id;
                            $bank_trans->total = $order->total;
                            $bank_trans->states = 1;
                            $bank_trans->save();

                            $user = Members::find($order->member_id);
                            $user->balance = $user->balance + $order->total;
                            $user->save();

                            Orders::where('order_id', $order->id)->delete();

                            $notifi = array(
                                'title' => "Hoàn trả $price tiền đặt cọc đơn hàng $order->product_name do đơn hàng bị hủy.",
                                'link' => "profile/history",
                                'icon' => 'fa fa-money'
                            );
                            Members::find($order->member_id)->notify(new InvoicePaid($notifi));
                            Members::find($info_order->member_id)->notify(new InvoicePaid($notifi));

                            $respon = array(
                                'status' => true,
                                'messenge' => "Hủy giao dịch thành công. Hoàn trả $price tiền đặt cọc"
                            );
                            die(json_encode($respon));
                        }
                    }
                    else{
                        $notifi = array(
                            'title' => "Đơn hàng $order->product_name đã bị hủy.",
                            'link' => "profile/manager",
                            'icon' => "fa fa-file-text-o"
                        );

                        Members::find($order->member_id)->notify(new InvoicePaid($notifi));
                        Members::find($info_order->member_id)->notify(new InvoicePaid($notifi));

                        Orders::where('order_id', $order->id)->delete();
                        $respon = array(
                            'status' => true,
                            'messenge' => 'Hủy giao dịch thành công.'
                        );
                        die(json_encode($respon));
                    }
            }
            else{
                $respon = array(
                    'status' => false,
                    'messenge' => 'Không thể hủy giao dịch khi đơn hàng đã được vận chuyển.'
                );
                die(json_encode($respon));
            }
        }
        else{
            $respon = array(
                'status' => false,
                'messenge' => 'Mặt hàng chưa có đối tác.'
            );
            die(json_encode($respon));
        }
    }

    public function destroyOrder(Request $request)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);

        $order = Orders::find($data['id']);
        $info_order = Orders::where('order_id', $data['id'])->first();
        $deposit = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 0])->first();
        $complete = Bankmember_Trans::where(['order_id' => $data['id'], 'states' => 2])->where('type', '!=', "GETBACK")->first();

        if($order->member_id != Auth::user()->id){
            $respon = array(
                'status' => false,
                'messenge' => 'Bạn không được thể xóa mặt hàng của người khác'
            );
            die(json_encode($respon));
        }

        if(!empty($complete)){
            $respon = array(
                'status' => false,
                'messenge' => 'Không thể xóa mặt hàng khi đơn hàng đã được vận chuyển'
            );
            die(json_encode($respon));
        }

        if(!empty($info_order)){
            $symbol = 'đ';
            $symbol_thousand = '.';
            $decimal_place = 0;
            $price = number_format($order->total, $decimal_place, '', $symbol_thousand);
            $price = $price.$symbol;

            if ((strtoupper($info_order->states) != "SENT" && strtoupper($info_order->states) != "RECEIVED")
                && (strtoupper($order->states) != "SENT" && strtoupper($order->states) != "RECEIVED")){
                if(!empty($deposit)){
                    if(strtoupper($order->type) == "SELL"){
                        Bankmember_Trans::where(['order_id' => $order->id, 'states' => 0])->delete();

                        $bank_trans = new Bankmember_Trans();
                        $bank_trans->type = "GETBACK";
                        $bank_trans->sender_id = $order->member_id;
                        $bank_trans->receiver_id = $info_order->member_id;
                        $bank_trans->order_id = $order->id;
                        $bank_trans->total = $order->total;
                        $bank_trans->states = 1;
                        $bank_trans->save();

                        $user = Members::find($info_order->member_id);
                        $user->balance = $user->balance + $order->total;
                        $user->save();

                        Orders::where('order_id', $order->id)->delete();
                        $order->delete();

                        $notifi = array(
                            'title' => "Hoàn trả $price tiền đặt cọc đơn hàng $order->product_name do đơn hàng bị hủy.",
                            'link' => "profile/history",
                            'icon' => 'fa fa-money'
                        );
                        Members::find($order->member_id)->notify(new InvoicePaid($notifi));
                        Members::find($info_order->member_id)->notify(new InvoicePaid($notifi));

                        $respon = array(
                            'status' => true,
                            'messenge' => "Xoá mặt hàng thành công. Hoàn trả $price tiền đặt cọc"
                        );
                        die(json_encode($respon));
                    }
                    else if(strtoupper($order->type) == "BUY"){
                        Bankmember_Trans::where(['order_id' => $order->id, 'states' => 0])->delete();

                        $bank_trans = new Bankmember_Trans();
                        $bank_trans->type = "GETBACK";
                        $bank_trans->sender_id = $info_order->member_id;
                        $bank_trans->receiver_id = $order->member_id;
                        $bank_trans->order_id = $order->id;
                        $bank_trans->total = $order->total;
                        $bank_trans->states = 1;
                        $bank_trans->save();

                        $user = Members::find($order->member_id);
                        $user->balance = $user->balance + $order->total;
                        $user->save();

                        Orders::where('order_id', $order->id)->delete();
                        $order->delete();

                        $notifi = array(
                            'title' => "Hoàn trả $price tiền đặt cọc đơn hàng $order->product_name do đơn hàng bị hủy.",
                            'link' => "profile/history",
                            'icon' => 'fa fa-money'
                        );
                        Members::find($order->member_id)->notify(new InvoicePaid($notifi));
                        Members::find($info_order->member_id)->notify(new InvoicePaid($notifi));

                        $respon = array(
                            'status' => true,
                            'messenge' => "Xoá mặt hàng thành công. Hoàn trả $price tiền đặt cọc"
                        );
                        die(json_encode($respon));
                    }
                }
                else{
                    Orders::where('order_id', $order->id)->delete();
                    $order->delete();

                    $notifi = array(
                        'title' => "Đơn hàng $order->product_name đã bị hủy.",
                        'link' => "profile/history",
                        'icon' => 'fa fa-file-text-o'
                    );
                    Members::find($order->member_id)->notify(new InvoicePaid($notifi));
                    Members::find($info_order->member_id)->notify(new InvoicePaid($notifi));

                    $respon = array(
                        'status' => true,
                        'messenge' => 'Xóa mặt hàng thành công.'
                    );
                    die(json_encode($respon));
                }
            }
            else{
                $respon = array(
                    'status' => false,
                    'messenge' => 'Không thể xóa mặt hàng khi đơn hàng đã được vận chuyển.'
                );
                die(json_encode($respon));
            }
        }
        else{
            $order->delete();
            $respon = array(
                'status' => true,
                'messenge' => 'Xóa mặt hàng thành công.'
            );
            die(json_encode($respon));
        }
    }
}
