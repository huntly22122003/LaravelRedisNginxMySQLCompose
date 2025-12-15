<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TaskShop extends Model
{
    protected $connection = 'shop';
    protected $table = 'tasks';
    protected $fillable = ['title', 'description', 'status', 'created_by', 'assigned_to',];
    public function creator()
    {
        return $this->belongsTo(UserShop::class, 'created_by');
    }
    public function assignee()
    {
        return $this->belongsTo(UserShop::class, 'assigned_to');
    }

}