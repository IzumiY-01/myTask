<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = array('id');
    //validation
    public static $rules = array(
        'title' => 'required',
        'category' => 'required',
        'name_work' =>'required',
        'dept_check' =>'required',
        
        );
    
    //historyモデルに関連付け
    public function histories()
    {
      return $this->hasMany('App\History');

    }
    
    
}
