<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemMast;
use DB;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view_folder = 'ItemMaster';
        $this->table =  'item_mast';
        $this->url = 'ItemMast';
    }
    public function index()
    {
        $record = ItemMast::where('status', 1)
                          ->orderBy('id' , 'desc')
                          ->get();

        $users = User::pluckall();                          
        
        return view('ItemMaster.index', [
            'data' => $record,
            'users'=> $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ItemMaster.create' , [
            'url'  => $this->url            
        ]);
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
            $check = ItemMast::checknameduplicacy($request->name);
            if($check){
                Session::put('error' , 'Item With Name '.$request->name.' already Exists');                
                return redirect()->back();
            }
            $insert = ItemMast::insert([
                                'name'       => $request->name,
                                'status'     => 1,
                                'descr'      => !empty($request->description) ? $request->description : null,
                                'created_at' => date('Y-m-d h:i:s'),
                                'created_by' => Auth::user()->id,
                        ]);
            if($insert){
                return redirect('ItemMast')->with('success' , 'Added SuccessFully');
            }
            else{
                return redirect('ItemMast');
            }
        }
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

        $edit = ItemMast::where('status', 1)
                        ->where('id',$encrypt_id)
                        ->first();
        if(!empty($edit)){
            return view('ItemMaster.edit',['encrypt_id' => $id,'edit'=>$edit]);            
        }
        else{
            return redirect()->back();
        }    
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

        $update  = ItemMast::where('id', $decrypt)
                ->update([
                    'name'       => $request->name,
                    'status'     => 1,
                    'descr'      => !empty($request->description) ? $request->description : null,
                    'updated_at' => date('Y-m-d h:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
        if($update){
            return redirect('ItemMast')->with('success' , 'Updated SuccessFully');
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
        $now_id  =  deCrypt($id);

        DB::begintransaction();

        $delete = ItemMast::where('id' , $now_id)
                          ->update([
                            'status' => 0,
                          ]);
        if($delete){
            DB::commit();
         return redirect('ItemMast')->with('success' , 'Deleted SuccessFully');            
        }
        else{
            DB::rollback();
            return redirect()->back();
        }        
    }
}
