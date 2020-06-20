<?php
namespace App\Libs;

class CommonFunction
{
    
    // /**
    //  * stringからdate型へ変換
    //  * 
    //  **/
    // public function convertDate($stringDate)
    // {
    //     $date = date('Y-m-d', strtotime($stringDate));
    //     return $date;
    // }
    
    /**
     * 土日祝関数
     * 修正箇所
     * 引数はdate型で受け取って、date型で返す
     * stringからdateへ変換する関数を切り出す
     * @param 日付
     * @return 土日祝の場合：true、そうでない場合：false
     */
    public static function isHoliday($date)
    {
        $weekdate = date('w', strtotime($date));
        
        if ($weekdate != 0 || $weekdate != 6){
            // TODO 祝日を確認する関数
           
            $holidays = array(
                '2020-06' => array('sat1'=>'2020-06-06','sun1'=>'2020-06-07','sat2'=>'2020-06-13','sun2'=>'2020-06-14','sat3'=>'2020-06-20','sun3'=>'2020-06-21','sat4'=>'2020-06-27','sun4'=>'2020-06-28'),
                '2020-07' => array('sat1'=>'2020-07-04','sun1'=>'2020-07-05','sat2'=>'2020-07-11','sun2'=>'2020-07-12','sat3'=>'2020-07-18','sun3'=>'2020-07-19','ho1'=>'2020-07-23','ho2'=>'2020-07-24','sat4'=>'2020-07-25','sun4'=>'2020-07-26'),
                '2020-08' => array('sat1'=>'2020-08-01','sun1'=>'2020-08-02','sat2'=>'2020-08-08','sun2'=>'2020-08-09','ho1'=>'2020-08-10','sat3'=>'2020-08-15','sun3'=>'2020-08-16','sat4'=>'2020-08-22','sun4'=>'2020-08-23','sat5'=>'2020-08-29','sun5'=>'2020-08-30'),
            );
            
            $objectHoliday = $holidays[date('Y-m', strtotime($date))];
        
            if (array_search($date,$objectHoliday,true)) {
                return true;
            }
            return false;
        }
        return true;
    }

}