<?php

namespace App\Modules\Meeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'meetings';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'duration',
        'start_at',
        'end_at',
        'members',
        'meeting_room_id',
    ];
    
    /**
     * Add or update data
     */
    public static function AddUpdateData($where, $update) {
        return self::firstOrCreate($where, $update); 
    }
}
