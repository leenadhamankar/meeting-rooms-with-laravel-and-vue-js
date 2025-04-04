<?php

namespace App\Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSubscription extends Model
{
    use HasFactory;

    protected $table = 'master_subscriptions';

    /**
     * Add or update data
     */
    public static function AddUpdateData($where, $update) {
        return self::firstOrCreate($where, $update); 
    }
}
