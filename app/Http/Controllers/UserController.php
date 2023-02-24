<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\sites;
use App\Models\Designation as role;
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
    public function __construct(){
        $this->view  = 'users';
        $this->table =  'users';
        $this->url   =  'Users'; 
    }

    public function index(Request $request)
    {
        $entriesraw =  User::where('status' , 1);

        if(isset($request->site)){
            $entriesraw->where('site' , $request->site);
        }

        $entries = $entriesraw->get();
        
        $sites = Sites::activesitespluck();

        $designations = role::pluckactives();

        return view($this->view.'.index', [
            'url'   => $this->url,
            'data'  => $entries,
            'sites' => $sites,
            'roles' => $designations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites        = Sites::activesitespluck();

        $designations = role::pluckactives();

        return view($this->view.'.create' , [
            'sites'       => $sites,
            'designations' => $designations
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
       
        $additional_parameters = [
            'created_at'        => date('Y-m-d h:i:s'),
            'created_by'        => Auth::user()->id,
            'status'            => 1,
            'orignal_password'  => $request->password
        ];
        $request->merge($additional_parameters);

        $insert_arr = $request->except('_token' , '_method');
        $insert_arr['password'] = bcrypt($insert_arr['password']);
        
        $insert = User::insert($insert_arr);

        if($insert){
            return redirect('Users')->with('success','User Created Successfully');    
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Insert');
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
    public function edit($id)
    {
        $decrypt_id = Crypt::deCrypt($id);
        $data = DB::table('users')->find($decrypt_id);
        $sites = Sites::where('status' , 1)
                      ->where('is_owner' , 1)
                      ->pluck('name' , 'id')
                      ->toArray();
        $designations = role::pluckactives();

        if(!empty($data)){
            return view('users.edit', compact('data' , 'sites' , 'designations'));
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
        $now_id = decrypt($id);
        $additional_parameters = [
            'updated_at'        => date('Y-m-d h:i:s'),
            'updated_by'        => Auth::user()->id,
            'status'            => 1,
            'orignal_password'  => $request->password
        ];

        $request->merge($additional_parameters);

        $update_arr = $request->except('_token'  , '_method');
        $update_arr['password'] = bcrypt($update_arr['password']);
        
        $update = User::where('id' , $now_id)
                      ->update($update_arr);

        if($update){
            return redirect('Users')->with('success','User Updated Successfully');    
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $now_id = decrypt($id); 
        $delete = User::where('id' , $now_id)
                       ->update([
                            'status' => 0
                       ]);
        if($delete){
        return redirect('Users')->with('success','Deleted Successfully');
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Delete');
        }
    }
}
