<?php

namespace App\Http\Controllers\User;

use App\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\Input;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    /**
     * @param Request $request
     * Đăng nhập
     */
    public function login(Request $request)
    {
        Input::merge(array_map('trim', Input::all()));
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($data)){
            echo 'Đăng nhập thành công!';
        }
        else die("Tài khoản hoặc mật khẩu không chính xác!");
    }

    /**
     * @param Request $request
     * Đăng ký tài khoản
     */
    public function register(Request $request)
    {
        Input::merge(array_map('trim', Input::alL()));
        $data = $request->validate([
            'email' => 'required|email|unique:oke_users,email',
            'password' => 'required|confirmed',
        ],[
            'email.unique' => 'Email đã tồn tại',
            'password.confirmed' => 'Xác thực mật khẩu không trùng khớp'
        ]);

        $user = new App\User();
        $user->email = $data['email'];
        $user->name = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->balance = 0;
        $user->states = 0;
        if($user->save()){
            echo 'Tạo tài khoản thành công!';
        }
        else die("Lỗi tạo tài khoản");
    }

    /**
     * Ajax kiểm tra thông tin của người đang đăng nhập đã được cập nhật đầy đủ thông tin chưa
     */
    public function checkProfile(){
        $user = Auth::user()->toArray();
        foreach ($user as $value){
            if(empty($value)){
                $respon = array(
                    'status' => false,
                    'messenge' => 'Vui lòng cập nhật đầy đủ thông tin cá nhân để thực hiện giao dịch.'
                );
                die(json_encode($respon));
            }
        }

        $respon = array(
            'status' => true,
            'messenge' => 'Bạn đã cập nhật đầy đủ thông tin cá nhân.'
        );
        die(json_encode($respon));
    }

    public function checkDeposit(Request $request){
        $data = $request->validate([
            'id' => 'required',
        ]);

        $order_current = Orders::find($data['id']);

        if (Auth::user()->balance < $order_current->total) {
            $respon = array(
                'status' => false,
                'messenge' => 'Số dư của bạn không đủ để đặt cọc, vui lòng nạp thêm tiền.'
            );
            die(json_encode($respon));
        } else {
            $respon = array(
                'status' => true,
                'messenge' => 'Số dư của bạn đủ để đặt cọc.'
            );
            die(json_encode($respon));
        }
    }

}
