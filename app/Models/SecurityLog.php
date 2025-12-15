<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class SecurityLog extends Model
{
    protected $connection = 'shop';
    protected $table = 'security_logs';
    protected $fillable =['user_id','action'];
    public $timestamps = false; // No update_at =>turn off

    public function user()
    {
        return $this->belongsTo(UserShop::class, 'user_id');
    }

}