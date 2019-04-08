<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bankadmin;
use App\Banks;
class BankAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Bankadmin::all();
        $bank = Banks::all();
        foreach ($bank as $key => $value) {
            $banks[$value->bank_name] = $value->bank_name;
        }
        return view('admin/bankadmin/index',compact(['data','banks']));
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
        $this->validate($request,
            [
                'account_name'=>'required',
                'account_number'=>'required'
            ],
            [
                'account_name.required' =>'Bạn chưa nhập tên tài khoản ngân hàng',
                'account_number.required' =>'Bạn chưa nhập số tài khoản ngân hàng',
                
            ]);
        Bankadmin::create($request->all());
        return redirect()->route('bankadmin.index')->with('notify','Thêm thành công');
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
        $this->validate($request,
            [
                'account_name'=>'required',
                'account_number'=>'required'
            ],
            [
                'account_name.required' =>'Bạn chưa nhập tên tài khoản ngân hàng',
                'account_number.required' =>'Bạn chưa nhập số tài khoản ngân hàng',
                
            ]);
        Bankadmin::find($id)->update($request->all());
        return redirect()->route('bankadmin.index')->with('notify','Thêm thành công');

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
        Bankadmin::find($id)->delete();
        return redirect()->route('bankadmin.index')->with('notify','Xóa thành công');
    }
}
