<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'global_id',
        'full_name',
        'username',
        'email',
        'password',
        'email_verified_at',
        'photo',
        'phone',
        'address',
        'description',
        'ship_id',
        'ugroup_id',
        'role',
        'budget',
        'totalpoint',
        'totalrevenue',
        'taxcode',
        'taxname',
        'taxaddress',
        'status',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function deleteUser($user_id){
        $user = User::find($user_id);
        if(auth()->user()->role =='admin')
        {
            $user->delete();
            return 1;
        }
        else{
            $user->status = "inactive";
            $user->save();
            return 0;
        }
            
        
    }
    public static function c_create($data)
    {
        
        $pro = User::create($data);
        $pro->code = "CUS" . sprintf('%09d',$pro->id);
        $pro->save();
       
        
       
        return $pro;
    }
    
    
}   
