<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransporterMast;
use Illuminate\Support\Facades\Auth;
class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = TransporterMast::where('status', 1)->get();
        // dd($record);
        return view('TransporterMaster.index', [
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
        return view('TransporterMaster.create');
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
            TransporterMast::insert([
                'name' => $request->name,
                'email' => !empty($request->email) ? $request->email : null,
                'contact_no' => $request->contact_no,
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->id,
                'status' => 1,
            ]);
        }
        return redirect('TransporterMast');
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
        $edit = TransporterMast::where('status', 1)->where('id',$encrypt_id)->first();
        return view('TransporterMaster.edit',['encrypt_id' => $id,'edit'=>$edit]);
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
        TransporterMast::where('id', $decrypt)
            ->update([
                'name' => $request->name,
                'email' => !empty($request->email) ? $request->email : null,
                'contact_no' => $request->contact_no,
                'status' => 1,
                'updated_at' => date('Y-m-d h:i:s'),
                'updated_by' => Auth::user()->id,
            ]);

        return redirect('TransporterMast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $del = TransporterMast::find($ecrypt);
        // $del->delete([
        //     'del' => $del,
        // ]);
        // return redirect('TransporterMast');
        // dd(1);
    }
}
