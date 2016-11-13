<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'content'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function labels(){
        return $this->belongsToMany('App\Label', 'task_label');
    }
}
