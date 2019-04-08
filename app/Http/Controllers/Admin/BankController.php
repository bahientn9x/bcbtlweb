<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banks;
class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Banks::all();
        return view('admin/bank/index',compact('data'));
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
                'bank_name'=>'required',
                'bank_fullname'=>'required'
            ],
            [
                'bank_name.required' =>'Bạn chưa nhập tên tài khoản ngân hàng',
                'bank_fullname.required' =>'Bạn chưa nhập số tài khoản ngân hàng',
                
            ]);
        Banks::create($request->all());
        return redirect()->route('bank.index')->with('notify','Thêm thành công');
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
                'bank_name'=>'required',
                'bank_fullname'=>'required'
            ],
            [
                'bank_name.required' =>'Bạn chưa nhập tên ngân hàng',
                'bank_fullname.required' =>'Bạn chưa nhập tên đầy đủ ngân hàng',
                
            ]);
        Banks::find($id)->update($request->all());
        return redirect()->route('bank.index')->with('notify','Sửa thành công');
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
        Banks::find($id)->delete();
        return redirect()->route('bank.index')->with('notify','Xóa thành công');
    }
}
