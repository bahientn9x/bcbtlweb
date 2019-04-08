<?php

namespace App\Http\Controllers\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Members;
use App\Bankmember;
use App\Bankmember_Trans;
use App\Bankadmin_Trans;
use Mail;
use TrueBV\Punycode;
use Carbon\Carbon;
$Punycode = new Punycode();
//var_dump($Punycode->encode('renangonçalves.com'));
// outputs: xn--renangonalves-pgb.com

//var_dump($Punycode->decode('xn--renangonalves-pgb.com'));
// outputs: renangonçalves.com
class WithdController extends Controller
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
        $databankmem = Auth::user()->bankmember;
        $moneyUser = Auth::user()->balance;
        $deposit = Bankmember_Trans::select('total')->where('sender_id',Auth::user()->id)->where('states','0')->sum('total');
        $max = $moneyUser - $deposit;
        $withd_id = Bankmember_Trans::max('id');
        $bankmem['a'] = "---Chọn ngân hàng---";
        foreach ($databankmem as $key => $value) {
            $bankmem[$value->id] = $value->bank_name;
        }
        return view('user/layout/withdrawal/index',compact(['bankmem','withd_id','max']));
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
                'total' => "required"
            ],

            [
                'total.required' => 'Bạn chưa nhập số tiền cần rút',
            ]);
        $bankmemberTrans = new Bankmember_Trans();
        $bankmemberTrans->type = "WITHDRAW";
        $bankmemberTrans->bankmember_id = $request->bankmember;
        $bankmemberTrans->total = str_replace([',',' đ'],'', $request->total);
        $bankmemberTrans->fee = "0";
        $bankmemberTrans->note = "Rút tiền";
        $bankmemberTrans->states = "0";
        $bankmemberTrans->verifyToken=Str::random(40);
        $bankmemberTrans->save();
        session(['token'=>$bankmemberTrans->verifyToken]);
        $data= Bankmember_Trans::findOrFail(Bankmember_Trans::max('id'));
        Mail::send('user/layout/email/confirmation',['name'=>'Admin'],function($message) use($data){
            $message->from('bahientn9x1@gmail.com','Hien');
            $message->to(auth::user()->email,Auth::user()->name);
            $message->subject('Xác thực yêu cầu rút tiền');
        });
        return redirect()->route('withdrawal.index')->with('thongbao','Một email xác thực đã được gửi tới '.auth::user()->email.'. Email sẽ tồn tại trong 5 phút');
    }
    public function confirmation($token){
        echo $token;
        $confirm = Bankmember_Trans::where('verifyToken',$token)->first();
        $dt = Carbon::parse($confirm->created_at);
        $now = Carbon::now();
      
        if ($now > $dt->addMinutes(5)) {
            return redirect()->route('withdrawal.index')->with('thongbaoloi','Link đã hết thời hạn');

        }else{
            if (!is_null($confirm)) {
            $confirm->verifyToken ="";
            $confirm->states ="1";
            $confirm->save();
            $bankadminTrans = new Bankadmin_Trans();
            $bankadminTrans->member_id = Auth::user()->id;
            $bankadminTrans->type ="WITHDRAWAL";
            $bankadminTrans->bankadmin_id = "0";
            $bankadminTrans->bankmember_id = $confirm->bankmember_id;
            $bankadminTrans->total = $confirm->total;
            $bankadminTrans->fee = "0";
            $bankadminTrans->note = "Rút tiền[".$confirm->id."]";
            $bankadminTrans->states = "0";
            $bankadminTrans->save();
            return redirect()->route('withdrawal.index')->with('thongbao','Xác thực thành công. Yêu cầu rút tiền của bạn đang được xử lý');
            }
        }
        return redirect()->route('withdrawal.index')->with('thongbaoloi','Link đã hết thời hạn');
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
    public function bankwithdmoney($data){
        $databankmem = Bankmember::find($data);
        echo "<div class=\"form-group row\">
                                <label for=\"staticEmail\" class=\"col-sm-6 col-form-label text-right\">Người nhận:</label>
                                <div class=\"col-sm-6\">
                                  <input type=\"text\" readonly readonly class=\"form-control-plaintext\" id=\"staticEmail\" value=\"$databankmem->account_name\">
                                </div>
                              </div>
                              <div class=\"form-group row\">
                                <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Tên ngân hàng:</label>
                                <div class=\"col-sm-6\">
                                  <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"$databankmem->bank_name\">
                                </div>
                              </div>
                              <div class=\"form-group row\">
                                <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Số tài khoản:</label>
                                <div class=\"col-sm-6\">
                                  <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"$databankmem->account_number\">
                                </div>
                              </div>
                              <div class=\"form-group row\">
                                <label for=\"\" class=\"col-sm-6 col-form-label text-right\">Chi nhánh:</label>
                                <div class=\"col-sm-6\">
                                  <input type=\"text\" readonly class=\"form-control-plaintext\" id=\"\" value=\"$databankmem->department\">
                                </div>
                              </div>";
    }
}
