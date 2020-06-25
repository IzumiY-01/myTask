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
        'free'=>'required',
        );
    
    //historyモデルに関連付け
    public function histories()
    {
      return $this->hasMany('App\History');

    }
    
     const CATEGORY = [
        1 => [ 'label' => '定例' ],
        2 => [ 'label' => 'イレギュラー' ],
        3 => [ 'label' => 'トラブル' ],
    ];
    
}
