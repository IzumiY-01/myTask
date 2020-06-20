<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /**status定義
    *1:未着手,2:確認依頼中,3:承認依頼中,4:完了
    */
    
    const STATUS = [
        1 => [ 'label' => '未着手' ],
        2 => [ 'label' => '確認依頼中' ],
        3 => [ 'label' => '承認依頼中' ],
        4 => [ 'label' => '完了' ],
    ];

}
