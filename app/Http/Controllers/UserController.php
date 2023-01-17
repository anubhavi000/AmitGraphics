<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $details = DB::table('users')->where('layout_status', 1)->where('company_id', $company_id)
            ->take(500)->get();
        return view('CreateUser.index', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CreateUser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd(Auth::user());
        // dd(bcrypt($request->password));
        date_default_timezone_set('Asia/Kolkata');
        DB::table('users')->insert([
            'company_id' => Auth::user()->company_id,
            'name' => $request->username,
            'email' => $request->emailid,
            'password' => bcrypt($request->password),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
            'layout_status' => 1,
        ]);
        return redirect('Users')->with('success','Inserted Successfully');
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

        $decrypt_id = Crypt::deCrypt($id);
        $details = DB::table('users')->find($decrypt_id);
        return view('CreateUser.edit', compact('details'));
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
        date_default_timezone_set('Asia/Kolkata');
        if (!empty($request->password)) {
            DB::table('users')->where('id', $id)->update([
                'name' => $request->username,
                'email' => $request->emailid,
                'password' => bcrypt($request->password),

                'updated_at' => date('Y-m-d H:i:s'),

                'updated_by' => Auth::user()->id,

            ]);
        } else {
            DB::table('users')->where('id', $id)->update([
                'name' => $request->username,
                'email' => $request->emailid,


                'updated_at' => date('Y-m-d H:i:s'),

                'updated_by' => Auth::user()->id,

            ]);
        }
        return redirect('Users')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->update([
            'layout_status' => 0
        ]);
        return redirect('Users')->with('success','Deleted Successfully');
    }
    // public function getpdf($id){
    //     // dd($id);
    //     $decrypt_id= Crypt::deCrypt($id);
    //     $client_type= DB::table('client_type')->find($decrypt_id);


    //     return view('ClientType.clienttypepdf' , ['client_type'=>$client_type ]);

    // }
}
