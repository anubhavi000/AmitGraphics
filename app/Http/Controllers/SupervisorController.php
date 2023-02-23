<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupervisorMast;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Session;
class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = SupervisorMast::where('status', 1)
                                ->orderBy('id' , 'desc')
                                ->get();

        $users = User::pluckall();

        return view('SupervisorMaster.index', [
            'data'  => $record,
            'users' => $users
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
        if(!empty($request->name)){
            $check = SupervisorMast::checknameduplicacy($request->name);
            if($check){
                Session::put('error' , 'Supervisor with name '.$request->name.' already exists');                
                return redirect()->back();
            }
        }          
        if (!empty($request->name)) {
            $insert = SupervisorMast::insert([
                            'name' => $request->name,
                            'email' => !empty($request->email) ? $request->email : null,
                            'phone' => !empty($request->num) ? $request->num : null,
                            'status' => 1,
                            'descr' => !empty($request->description) ? $request->description : null,
                            'created_at' => date('Y-m-d h:i:s'),
                            'created_by' => Auth::user()->id,
                        ]);
            if($insert){
                return redirect('SupervisorMast')->with('success' , 'Added SuccessFully');
            }
            else{
                return redirect()->back();
            }
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

        $edit = SupervisorMast::where('status', 1)->where('id',$encrypt_id)->first();
        if(empty($edit)){
            return redirect()->back();
        }
        
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
        $update = SupervisorMast::where('id', $decrypt)
                                ->update([
                                    'name' => $request->name,
                                    'email' => !empty($request->email) ? $request->email : null,
                                    'phone' => !empty($request->num) ? $request->num : null,
                                    'status' => 1,
                                    'descr' => !empty($request->description) ? $request->description : null,
                                    'updated_at' => date('Y-m-d h:i:s'),
                                    'updated_by' => Auth::user()->id,
                                ]);
        if($update){
            return redirect('SupervisorMast')->with('success' , 'Updated SuccessFully');
        }
        else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request , $id)
    {
        $now_id = deCrypt($id);
        DB::begintransaction();

        $delete = SupervisorMast::where('id' , $now_id)
                        ->update([
                            'status' => 0,
                        ]);

        if($delete){
            DB::commit();
            return redirect()->back()->with('success' , 'Deleted SuccessFully');
        }
        else{
            DB::rollback();
            return redirect()->back();
        }
    }
}
