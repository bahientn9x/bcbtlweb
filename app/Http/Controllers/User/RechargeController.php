<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Banks;
use App\User;
use DB;
use App\Bankadmin;
use App\Bankmember_Trans;
use App\Bankadmin_Trans;
class RechargeController extends Controller
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
        //
        $databanks = Banks::all();
        $recharge_id = Bankmember_Trans::max('id');
        $banks['a']='---Chọn ngân hàng---';
        foreach ($databanks as $key => $value) {
            $banks[$key] = $value['bank_name']; 
        }
        return view('user/layout/recharge/index',compact(['banks','recharge_id']));
        
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
                'recharge' =>'required',
                'note' =>'required',
            ],   
            [
                'recharge.required' =>"Bạn chưa nhập số tiền muốn nạp",
                'note.required' =>"Bạn chưa nhập ghi chú",
            ]);
        $bankmemberTrans = new Bankmember_Trans();
        $bankmemberTrans->type = "DEPOSIT";
        $bankmemberTrans->bankmember_id = "0";
        $bankmemberTrans->total = str_replace([',',' đ'],'', $request->recharge);
        $bankmemberTrans->fee = "0";
        $bankmemberTrans->note = $request->note;
        $bankmemberTrans->states = "0";
        $bankmemberTrans->save();
        $bankadminTrans = new Bankadmin_Trans();
        $bankadminTrans->member_id = $request->member_id;
        $bankadminTrans->type ="DEPOSIT";
        $bankadminTrans->bankadmin_id = $request->bankadmin_id;
        $bankadminTrans->bankmember_id = "0";
        $bankadminTrans->total = str_replace([',',' đ'],'', $request->recharge);
        $bankadminTrans->fee = "0";
        $bankadminTrans->note = $request->note."[".$request->recharge_id."]";
        $bankadminTrans->states = "0";
        $bankadminTrans->save();
        return redirect()->route('recharge.index')->with('thongbao','Yêu cầu nạp tiền của bạn đang chờ duyệt.');
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
    public function bankreceivemoney($bankname){
        $databank = Bankadmin::where('bank_name','=',$bankname)->where('states','1')->where('balance', Bankadmin::min('balance'))->first();
        if ($bankname == '---Chọn ngân hàng---') {
            echo "<div class=\"form-group row\">
                            <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Người nhận:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"\">
                            </div>
                            <input name=\"bankadmin_id\" type=\"hidden\" value=\"\">
                          </div>
                          <div class=\"form-group row\">
                            <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Tên ngân hàng:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"\">
                            </div>
                          </div>
                          <div class=\"form-group row\">
                            <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Số tài khoản:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"\">
                            </div>
                          </div>
                          <div class=\"form-group row\">
                            <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Chi nhánh:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"\">
                            </div>
                          </div>
                          <div class=\"form-group row\">
                                <label for=\"inputPassword\" class=\"col-sm-6 col-form-label text-right\">Trạng thái chuyển:</label>
                                <div class=\"col-sm-6\">
                                  <input type=\"text\" readonly class=\"border-0 form-control-plaintext\" id=\"inputPassword\" value=\"\">
                                </div>
                            </div>
                            ";
        }else{
            echo "<div class=\"form-group row\">
                            <label for=\"staticEmail\" class=\"col-sm-6 col-form-label text-right\">Người nhận:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"staticEmail\" value=\"$databank->account_name\">
                            </div>
                            <input name=\"bankadmin_id\" type=\"hidden\" value=\"$databank->id\">
                          </div>
                          <div class=\"form-group row\">
                            <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Tên ngân hàng:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"$databank->bank_name\">
                            </div>
                          </div>
                          <div class=\"form-group row\">
                            <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Số tài khoản:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"$databank->account_number\">
                            </div>
                          </div>
                          <div class=\"form-group row\">
                            <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Chi nhánh:</label>
                            <div class=\"col-sm-6\">
                              <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"$databank->department\">
                            </div>
                          </div>
                          <div class=\"form-group row\">
                                <label for=\"inputPassword\" class=\"col-sm-6 col-form-label text-right\">Trạng thái chuyển:</label>
                                <div class=\"col-sm-6\">
                                  <input type=\"text\" readonly class=\"border-0 form-control-plaintext\" id=\"inputPassword\" value=\"Chờ xác nhận\">
                                </div>
                            </div>
                            ";
        }
        
    }
}
