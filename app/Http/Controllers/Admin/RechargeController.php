<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bankadmin_Trans;
use App\Members;
use App\User;
use App\Bankadmin;
class RechargeController extends Controller
{
    function __construct(){
        $this->middleware('auth:users');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Bankadmin_Trans::where('type','DEPOSIT')->get();
        
        return view('admin/recharge.index',compact('data'));
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
        $data=Bankadmin_Trans::find($id);
        return view("admin/recharge.show",compact('data'));
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
        if ($request->status ='a') {
            $data = Bankadmin_Trans::find($id);
            $data->states ='1';
            $data->save();
            $member = Members::find($request->member_id)->first();
            $member->balance = $member->balance + $data->total - $data->fee;
            $member->save();
                return redirect()->route('adminrecharge.index')->with('notify','Xác nhận yêu cầu nạp tiền của khách hàng thành công!');
        }
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
        Bankadmin_Trans::find($id)->delete();
        return redirect()->route('adminrecharge.index')->with('notify','Xóa thành công!');
    }
}
