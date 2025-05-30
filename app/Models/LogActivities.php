<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivities extends Model
{
    use HasFactory;

    public $table = 'log_activities_tables';

    public $guarded = ['id'];

    public CONST TYPE_LOGIN = "LOGIN";
    public CONST TYPE_LOGIN_GOOGLE = "LOGIN_GOOGLE";
    public CONST TYPE_REGISTER = "REGISTER";
    public CONST TYPE_LOGOUT = "LOGOUT";

    public CONST TYPE_CREATE_COMMENT = "CREATE_COMMENT";
    public CONST TYPE_UPDATE_COMMENT = "UPDATE_COMMENT";
    public CONST TYPE_DELETE_COMMENT = "DELETE_COMMENT";

    public CONST TYPE_CREATE_EVENT = "CREATE_EVENT";
    public CONST TYPE_UPDATE_EVENT = "UPDATE_EVENT";
    public CONST TYPE_DELETE_EVENT = "DELETE_EVENT";

    public CONST TYPE_CREATE_PLACE = "CREATE_PLACE";
    public CONST TYPE_UPDATE_PLACE = "UPDATE_PLACE";
    public CONST TYPE_DELETE_PLACE = "DELETE_PLACE";
    
    public CONST TYPE_CREATE_PLACE_LIMIT = "CREATE_PLACE_LIMIT";
    public CONST TYPE_UPDATE_PLACE_LIMIT = "UPDATE_PLACE_LIMIT";
    public CONST TYPE_DELETE_PLACE_LIMIT = "DELETE_PLACE_LIMIT";
    
    public CONST TYPE_UPDATE_SETTINGS = "UPDATE_SETTINGS";
    
    public CONST TYPE_CREATE_USER = "CREATE_USER";
    public CONST TYPE_UPDATE_USER = "UPDATE_USER";
    public CONST TYPE_DELETE_USER = "DELETE_USER";
    public CONST TYPE_RESTORE_USER = "RESTORE_USER";
    public CONST TYPE_UPDATE_PROFILE_USER = "UPDATE_PROFILE_USER";
    public CONST TYPE_APPROVE_USER = "APPROVE_USER";
    public CONST TYPE_UNAPPROVE_USER = "UNAPPROVE_USER";
    public CONST TYPE_VERIFY_USER = "VERIFY_USER";


    public CONST TYPE_CREATE_USER_LIMIT = "CREATE_USER_LIMIT";
    public CONST TYPE_UPDATE_USER_LIMIT = "UPDATE_USER_LIMIT";
    public CONST TYPE_DELETE_USER_LIMIT = "DELETE_USER_LIMIT";

    public CONST TYPE_CREATE_ADVERTISE = "CREATE_ADVERTISE";
    public CONST TYPE_UPDATE_ADVERTISE = "UPDATE_ADVERTISE";
    public CONST TYPE_DELETE_ADVERTISE = "DELETE_ADVERTISE";

    public CONST TYPE_CREATE_BLOG = "CREATE_BLOG";
    public CONST TYPE_UPDATE_BLOG = "UPDATE_BLOG";
    public CONST TYPE_DELETE_BLOG = "DELETE_BLOG";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function getUserEmailAttribute()
    {
        return $this->user ? $this->user->email : null;
    }
}
