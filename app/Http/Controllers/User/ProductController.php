<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Category;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Input::merge(array_map('trim', Input::all()));
        $data = $request->validate([
            'produtct_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'type' => 'required',
            'num' => 'required',
            'price' => 'required',
            'description' => 'required',
            'icon' => 'required',
            'cate_id' => 'required'
        ]);

        $data['type'] = strtoupper($data['type']);

        if ($data['type'] != "BUY" && $data['type'] != "SELL") {
            $respon = array(
                'status' => false,
                'flag' => 1,
                'messenge' => 'Type không tồn tại.'
            );
            die(json_encode($respon));
        }

        $total = $data['price'] * $data['num'];

        if ($data['type'] == "SELL") {
            if (Auth::user()->balance < $total) {
                $respon = array(
                    'status' => false,
                    'flag' => 2,
                    'messenge' => 'Số dư của bạn không đủ để đặt cọc, vui lòng nạp thêm tiền.'
                );
                die(json_encode($respon));
            }
        }

        if (($request->hasFile('icon'))) {
            $extend = $request->file('icon')->getClientOriginalExtension();
            $sizeimg = $request->file('icon')->getSize();
            if ($extend == "jpg" || $extend == "jpeg" || $extend == "png" || $extend == "gif") {
                if ($sizeimg < 10000000) {
                    $fileExtension = $request->file('icon')->getClientOriginalExtension();
                    $fileName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999)) . "." . $fileExtension;
                    $request->file('icon')->move('img', $fileName);
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

        $order = new App\Orders();
        $order->member_id = Auth::user()->id;
        $order->product_name = $data['produtct_name'];
        $order->type = $data['type'];
        $order->num = $data['num'];
        $order->price = $data['price'];
        $order->total = $total;
        $order->address = $data['address'];
        $order->phonenumber = $data['phone'];
        $order->description = $data['description'];
        $order->icon = 'img/'.$fileName;
        $order->cate_id = $data['cate_id'];


        if ($order->save()) {
            $respon = array(
                'status' => true,
                'flag' => 0,
                'messenge' => 'Thêm mặt hàng thành công!'
            );
            die(json_encode($respon));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy()
    {
        //
    }

    public function buy()
    {
        $idCate = Input::get('id', 'null');
        $listCate = Category::all();
        return view('user.products.addproduct', compact("listCate", "idCate"));
    }

    public function sell()
    {
        $idCate = Input::get('id', 'null');
        $listCate = Category::all();
        return view('user.products.addproduct', compact("listCate","idCate"));
    }

}
