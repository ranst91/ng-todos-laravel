<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['title'];
    public $timestamps = false;
    public function tasks()
    {
        return $this->belongsToMany('App\Task', 'task_label');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
