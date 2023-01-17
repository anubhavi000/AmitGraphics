<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_modules = Module::with('parent')->get();
        return view('Module.index', compact('all_modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_modules = Module::whereNull('parent_id')->get();
        return view('Module.create', compact('all_modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $module = new Module();
        $module->parent_id = $request->parent_id;
        $module->module_name = $request->module_name;
        $module->status = $request->status;
        $module->sequence = $request->sequence;
        $module->route_name = $request->route_name;
        $module->icon = $request->icon;
        $module->created_by = Auth::user()->id;
        $module->updated_by = Auth::user()->id;
        $module->save();
        return redirect('Module')->with('success','Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\odel  $odel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decrypt_id = Crypt::deCrypt($id);
        $module = Module::find($decrypt_id);

        $all_modules = Module::whereNull('parent_id')->get();
        return view('Module.edit', compact('module', 'all_modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\odel  $odel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $module = Module::find($id);
        $module->parent_id = $request->parent_id;
        $module->module_name = $request->module_name;
        $module->status = $request->status;
        $module->route_name = $request->route_name;
        $module->icon = $request->icon;
        $module->sequence = $request->sequence;
        $module->updated_by = Auth::user()->id;
        $module->save();
        return redirect('Module')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($module);
        Module::destroy($id);
        return redirect('Module')->with('success','Deleted Successfully');
    }
}
