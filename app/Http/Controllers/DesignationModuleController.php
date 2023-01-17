<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\DesignationModule;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class DesignationModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_modules = DesignationModule::with('designation', 'modules')->get();
        // $designations = Designation::all();
        return view('DesignationModule.index', compact('all_modules'));
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
        // dd($request);
        DesignationModule::where('designation_id' , $request->designation_id)->delete();
        
        $user_id = Auth::user()->id;
        $module_ids = $request->module_id;
            
       

        foreach ($module_ids as $key => $module_id) {
            $module = new DesignationModule();
            $module->designation_id = $request->designation_id;
            $module->module_id = $module_id;
            $module->view = !empty($request->view[$module_id]) ? $request->view[$module_id] : 0;
            $module->add = !empty($request->add[$module_id]) ? $request->add[$module_id] : 0;
            $module->edit = !empty($request->edit[$module_id]) ? $request->edit[$module_id] : 0;
            $module->delete = !empty($request->delete[$module_id]) ? $request->delete[$module_id] : 0;
            $module->download = !empty($request->download[$module_id]) ? $request->download[$module_id] : 0;
            $module->upload = !empty($request->upload[$module_id]) ? $request->upload[$module_id] : 0;

            $module->created_by = $user_id;
            $module->updated_by = $user_id;
            $module->save();
        }
        return redirect('DesignationModule')->with('success','updated Successfully');
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
    public function getModulePrevAccess()
    {
        $new_added_module=[];
        $designation_id = $_GET['designation_id'];
        $prev_access = DesignationModule::where('designation_id', $designation_id)->with('modules')->get();
        $prev_module_parent_module = DB::table('designation_modules')
                                     ->join('modules' , 'modules.id' , '=' , 'designation_modules.module_id')
                                     ->where('designation_id', $designation_id)
                                     ->where('modules.parent_id', null)
                                     ->get();
         $flag=0;
         foreach($prev_module_parent_module as $pmpm){
             $assigned_modules_all_child=DB::table('modules')->where('parent_id' , $pmpm->module_id)->get();
             foreach($assigned_modules_all_child as $amal){
                foreach($prev_access as $pv){
                    if($amal->id==$pv->module_id){
                       $flag++;
                    }
                }
                if($flag==0){
                    $new_added_module[]=$amal;
                }else{
                  $flag=0;

                }
             }

         }                         
         
        $data['new_added_module']=$new_added_module;
     
        $data['code'] = 200;
        $data['response'] = $prev_access;
        return json_encode($data);
    }
}
