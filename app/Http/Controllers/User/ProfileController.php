<?php

namespace App\Http\Controllers\User;

use App\Bankadmin_Trans;
use App\Orders;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Members;
use App\Bankmember_Trans;
use App\Bankmember;
use Hash;
use File;
use Validator;

class ProfileController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $member = Members::find(Auth::user()->id);
        return view('user.profile.index', compact('member'));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * view change password
     */
    public function viewChangePassword()
    {
        return view('user.profile.change-password');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * view history
     */
    public function viewHistory()
    {
        $bankmember = Bankmember::select('id')->where('member_id', Auth::user()->id)->get();
        $bankadmin_trans = Bankadmin_Trans::where('member_id', Auth::user()->id)->get();
        $bankmember_trans = Bankmember_Trans::whereIn('bankmember_id', $bankmember)
            ->whereNull('bankmember_id')
            ->orWhere('sender_id', Auth::user()->id)
            ->orWhere('receiver_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')->get();
        return view('user.profile.history', compact('bankmember_trans', 'bankadmin_trans'));
    }

    /**
     * update profile member
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email_user' => 'required',
            'phone_number' => 'required|numeric|digits_between:10,11',
            'address' => 'required',
            'cmnd' => 'required|numeric|digits_between:9,9',
        ], [
            'full_name.required' => 'Bạn chưa nhập họ tên.',
            'email_user.required' => 'Bạn chưa nhập email.',
            'phone_number.required' => 'Bạn chưa nhập số điện thoại.',
            'phone_number.numeric' => 'Số điện thoại không đúng.',
            'phone_number.digits_between' => 'Số điện thoại không đúng.',
            'cmnd.required' => 'Bạn chưa nhập số cmnd.',
            'cmnd.numeric' => 'Số cmnd không đúng.',
            'cmnd.digits_between' => 'Số cmnd không đúng.',
            'address.required' => 'Bạn chưa nhập địa chỉ',
        ]);
        if ($validator->fails()) return back()->withInput()->withErrors($validator);
        $member = auth::user();
        $arrImg = [];
        $arrOldImg = [];
        // upload image cmt
        if ($request->file('cmt') != null) {
            foreach ($request->file('cmt') as $key => $value) {
                $filenameWithExt = $value->getClientOriginalName();
                $filename = '';
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $value->getClientOriginalExtension();
                $filenameToStore = $filename . '_' . time() . '.' . $extension;
                $value->move('img/profile', $filenameToStore);
                $arrImg[$key] = 'img/profile/' . $filenameToStore;
            }
        }
        $member->name = $request->full_name;
        $member->email = $request->email_user;
        $member->phone = $request->phone_number;
        $member->address = $request->address;
        $member->so_cmnd = $request->cmnd;

        //set img to database
        if (isset($arrImg[0])) {
            $arrOldImg[] = $member->cmt_1;
            $member->cmt_1 = $arrImg[0];
        }
        if (isset($arrImg[1])) {
            $arrOldImg[] = $member->cmt_2;
            $member->cmt_2 = $arrImg[1];
        }
        if (isset($arrImg[2])) {
            $arrOldImg[] = $member->cmt_3;
            $member->cmt_3 = $arrImg[2];
        }
        if (isset($arrImg[3])) {
            $arrOldImg[] = $member->cmt_4;
            $member->cmt_4 = $arrImg[3];
        }
        // delete img not used
        foreach ($arrOldImg as $value) {
            if ($value != '') {
                if (file_exists($value)) File::delete($value);
            }
        }
        $member->save();
        return redirect('profile')->with('notify', 'Thành công');
    }

    /**
     * change password member
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'repeat_password' => 'required',
        ], [
            'old_password.required' => 'Bạn chưa nhập mật khẩu cũ.',
            'new_password.required' => 'Bạn chưa nhập mật khẩu mới.',
            'repeat_password.required' => 'Bạn chưa nhập lại mật khẩu.',
        ]);

        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;
        $repeatPassword = $request->repeat_password;

        $member = Members::find(auth::user()->id);
        if ($newPassword != $repeatPassword) {
            return back()->withInput()->with('notify_false', 'Mật khẩu nhập lại không khớp.');
        }

        if (Hash::check($oldPassword, $member->password)) {
            $member->password = Hash::make($newPassword);
            $member->save();
            return back()->with('notify_success', 'Đổi mật khẩu thành công.');
        }
        return back()->withInput()->with('notify_false', 'Mật khẩu cũ không đúng.');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|int
     * Thông tin chi tiết trạng thái của mặt hàng.
     */
    public function orderSatus($id)
    {
        $order = Orders::find($id);
        $flag = 0;

        if ($order != null) {
            $info_order = Orders::where('order_id', $id)->first();
            $deposit = Bankmember_Trans::where(['order_id' => $order->id ,'states' => 0])->first();
            $complete = Bankmember_Trans::where(['order_id' => $order->id ,'states' => 2])->where('type', '!=', "GETBACK")->first();
            $info_user = array();

            if(empty($info_order) && $order->member_id != Auth::user()->id)
                die;

            if((!empty($info_order) && $info_order->member_id != Auth::user()->id) && $order->member_id != Auth::user()->id)
                die;

            if(strtoupper($order->type == "SELL")){
                $info_user[1] = array(
                    'name' => $order->members->name,
                    'address' => $order->address,
                    'phonenumber' => $order->phonenumber,
                    'date' => $order->updated_at
                );
                if(!empty($info_order)){
                    $info_user[2] = array(
                        'name' => $info_order->members->name,
                        'address' => $info_order->address,
                        'phonenumber' => $info_order->phonenumber,
                        'date' => $info_order->updated_at
                    );
                }
            }
            else if(strtoupper($order->type == "BUY")){
                $info_user[2] = array(
                    'name' => $order->members->name,
                    'address' => $order->address,
                    'phonenumber' => $order->phonenumber,
                    'date' => $order->updated_at
                );
                if(!empty($info_order)){
                    $info_user[1] = array(
                        'name' => $info_order->members->name,
                        'address' => $info_order->address,
                        'phonenumber' => $info_order->phonenumber,
                        'date' => $info_order->updated_at
                    );
                }
            }

            if (!empty($info_order)) {
                if (!empty($complete))
                    $flag = 5;
                else if ((strtoupper($info_order->states) == "SENT" || strtoupper($info_order->states) == "RECEIVED")
                    && (strtoupper($order->states) == "SENT" || strtoupper($order->states) == "RECEIVED"))
                    $flag = 4;
                else if (strtoupper($info_order->states) == "SENT" || strtoupper($order->states) == "SENT")
                    $flag = 3;
                else if(!empty($deposit))
                    $flag = 2;
                else
                    $flag = 1;
            }

            return view('user.profile.order-status', compact('order', 'info_order', 'flag', 'info_user'));
        }
    }

    public function unreadNotifi()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }
}
