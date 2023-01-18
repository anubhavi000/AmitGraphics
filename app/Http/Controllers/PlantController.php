<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantMast;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = PlantMast::where('status', 1)->get();
        return view('PlantMaster.index', [
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
        return view('PlantMaster.create');
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
            PlantMast::insert([
                'name' => $request->name,
                'status' => 1,
                'descr' => !empty($request->description) ? $request->description : null,
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->id,
            ]);
        }
        return redirect('PlantMast');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $edit = PlantMast::where('status', 1)->where('id',$encrypt_id)->first();
        return view('PlantMaster.edit',['encrypt_id' => $id,'edit'=>$edit]);
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
        PlantMast::where('id', $decrypt)
            ->update([
                'name' => $request->name,
                'status' => 1,
                'descr' => !empty($request->description) ? $request->description : null,
                'updated_at' => date('Y-m-d h:i:s'),
                'updated_by' => Auth::user()->id,
            ]);

        return redirect('PlantMast');
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
}
