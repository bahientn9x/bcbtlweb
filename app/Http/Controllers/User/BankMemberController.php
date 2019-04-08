<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bankmember;
use App\Banks;
use Auth;

class BankMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankMembers = Auth::user()->bankmember;
        return view('user.profile.payment.index', compact('bankMembers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $banks = Banks::all();
        return view('user.profile.payment.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'account_name' => 'required',
            'account_number' => 'required|numeric',
        ],[
            'account_name.required' => 'Bạn chưa nhập tên tài khoản.',
            'account_number.required' => 'Bạn chưa nhập số tài khoản.',
            'account_number.numeric' => 'Số tài khoản không hợp lệ.',

        ]);

        $bankMember = new Bankmember;
        $bankMember->member_id = auth::user()->id;
        $bankMember->account_name = $request->account_name;
        $bankMember->account_number = $request->account_number;
        $bankMember->bank_name = $request->bank_name;
        return ( $bankMember->save() ) ? redirect('profile/payment')->with('notify','Thành công') : redirect('profile/payment')->with('notify','Gặp sự cố');
        
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
        $bankMember = Bankmember::find($id);
        $banks = Banks::all();
        return view('user.profile.payment.edit', compact(['bankMember', 'banks']));
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
        $this->validate($request,[
            'account_name' => 'required',
            'account_number' => 'required|numeric',
        ],[
            'account_name.required' => 'Bạn chưa nhập tên tài khoản.',
            'account_number.required' => 'Bạn chưa nhập số tài khoản.',
            'account_number.numeric' => 'Số tài khoản không hợp lệ.',

        ]);

        $bankMember = Bankmember::find($id);
        $bankMember->member_id = auth::user()->id;
        $bankMember->account_name = $request->account_name;
        $bankMember->account_number = $request->account_number;
        $bankMember->bank_name = $request->bank_name;
        return ( $bankMember->save() ) ? redirect('profile/payment')->with('notify','Thành công') : redirect('profile/payment')->with('notify','Gặp sự cố');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ( $bankMember = Bankmember::find($id)->delete() ) ? redirect('profile/payment')->with('notify','Thành công') : redirect('profile/payment')->with('notify','Gặp sự cố');
    }
}
