<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupervisorMast;
use Illuminate\Support\Facades\Auth;
class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = SupervisorMast::where('status', 1)->get();
        return view('SupervisorMaster.index', [
            'data' => $record,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SupervisorMaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request->name)) {
            SupervisorMast::insert([
                'name' => $request->name,
                'email' => !empty($request->email) ? $request->email : null,
                'phone' => !empty($request->num) ? $request->num : null,
                'status' => 1,
                'descr' => !empty($request->description) ? $request->description : null,
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->id,
            ]);
        }
        return redirect('SupervisorMast');
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
        public function edit(Request $request, $id)
    {
        $encrypt_id = deCrypt($id);
        // dd($request, $id, $encrypt_id);
        $edit = SupervisorMast::where('status', 1)->where('id',$encrypt_id)->first();
        return view('SupervisorMaster.edit',['encrypt_id' => $id,'edit'=>$edit]);
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
        $decrypt = decrypt($id);
        SupervisorMast::where('id', $decrypt)
            ->update([
                'name' => $request->name,
                'email' => !empty($request->email) ? $request->email : null,
                'phone' => !empty($request->num) ? $request->num : null,
                'status' => 1,
                'descr' => !empty($request->description) ? $request->description : null,
                'updated_at' => date('Y-m-d h:i:s'),
                'updated_by' => Auth::user()->id,
            ]);

        return redirect('SupervisorMast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $del = SupervisorMast::find($ecrypt);
        // $del->delete([
        //     'del' => $del,
        // ]);
        // return redirect('SupervisorMast');
        // dd(1);
    }
}
