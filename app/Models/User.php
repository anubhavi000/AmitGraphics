<?php

namespace App\Models;

use App\Models\UserPlant;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\Models\Designation;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userPlants()
    {
        return $this->belongsToMany(UserPlant::class, 'user_plants', 'user_id', 'plant_id');
    }

    public function employeeInfo()
    {
        return $this->belongsTo(EmployeeInfo::class, 'user_primary_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function hasModuleAccess($moduleId)
    {
        $authUser = \Auth::user();
        $designationModule = DesignationModule::where('designation_id', $authUser->designation_id)
            ->where('module_id', $moduleId)
            // ->where('view',1)
            ->first();

        if ($designationModule) {
            return $designationModule;
        }
        return false;
    }
    public function hasModuleAccessChild($moduleId)
    {
        $authUser = \Auth::user();
        $designationModule = DesignationModule::where('designation_id', $authUser->designation_id)
            ->where('module_id', $moduleId)
            ->where('view',1)
            ->first();

        if ($designationModule) {
            return $designationModule;
        }
        return false;
    }
    public static function is_admin(){ 
        $desig      = Self::where('id' , Auth::user()->designation_id)->first()->designation_id;
        $desig_info =  Designation::where('id' , $desig)->first();
        if(!empty($desig_info)){
            if( $desig_info->id == '1'){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public static function is_supervisor(){
        $desig      = Self::where('id' , Auth::user()->designation_id)->first()->designation_id;
        $desig_info =  Designation::where('id' , $desig)->first();
        if(!empty($desig_info)){
            if( $desig_info->id == '3'){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
}
