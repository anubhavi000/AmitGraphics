<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\DesignationModule;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Module::whereNull('parent_id')->get();
        $submenus=[];
        foreach($menus as $menu){
            $submenus[$menu->id]=Module::where('parent_id' , $menu->id)->get();
        }
      
        return view('layouts.panel', compact('menus' , 'submenus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_modules = Module::whereNull('parent_id')->get();
        // dd($all_modules);
        $designations = Designation::all();
        return view('DesignationModule.create', compact('all_modules', 'designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $user_id = Auth::user()->id;
        $module_ids = $request->module_id;

        foreach ($module_ids as $key => $module_id) {
            $module = new DesignationModule();
            $module->designation_id = $request->designation_id;
            $module->module_id = $module_id;
            $module->add = !empty($request->add[$module_id]) ? $request->add[$module_id] : 0;
            $module->edit = !empty($request->edit[$module_id]) ? $request->edit[$module_id] : 0;
            $module->delete = !empty($request->delete[$module_id]) ? $request->delete[$module_id] : 0;
            $module->download = !empty($request->download[$module_id]) ? $request->download[$module_id] : 0;
            $module->upload = !empty($request->upload[$module_id]) ? $request->upload[$module_id] : 0;

            $module->created_by = $user_id;
            $module->updated_by = $user_id;
            $module->save();
        }
        return redirect('DesignationModule')->with('success','Inserted Successfully');
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DesignationModule::destroy($id);
        return redirect('DesignationModule')->with('success','Deleted Successfully');
    }
    public function getChildModules()
    {
        $parent_module_id = $_GET['parent_module_id'];
        $child_modules = Module::where('parent_id', $parent_module_id)->get();
        $data['code'] = 200;
        $data['response'] = $child_modules;
        return json_encode($data);
    }





    // view code 
    // @if(!empty($menus))
    // @foreach($menus as $menu)
    //   <li class="pcoded-hasmenu" >
    //   <a href="javascript:void(0)" class="waves-effect waves-dark">
    //     <span class="pcoded-micon"><i class="feather icon-box"></i></span>
    //     <span class="pcoded-mtext">{{$menu->module_name}}</span>
    // </a>
    //    @if(!empty($submenus[$menu->id]))
    //       <ul class="pcoded-submenu">
    //         @foreach($submenus[$menu->id] as $submenu)
    //           <li class="">
    //               <a class="slide-item" href="{{url($submenu->route_name)}}" class="waves-effect waves-dark">
    //               <span class="pcoded-mtext">{{$submenu->module_name}}</span>
    //           </a>
    //           </li>
    //           @endforeach
    //           @endif
            
    //       </ul>
    //   </li>
    //   @endforeach
}
