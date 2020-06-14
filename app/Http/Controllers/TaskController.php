<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use App\History;
use Carbon\Carbon;


class TaskController extends Controller
{
    //task新規作成画面表示
    public function add()
    {
        return view('create');
    }

    //task新規作成
    public function create(Request $request)
    {
        /*
        tasks tableへ保存
        */
        //vallidation
        $this->validate($request, Task::$rules);
        
        $tasks = new Task;
        $form = $request->all();
        
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        $tasks->fill($form);
        $tasks->save();
        
        /*
        histories tableへ保存
        */
        $history = new History;
        $history->task_id = $tasks->id;
        $history->object_month = $tasks->object_month;
        //$history->status 
        //startd_date取得
        $start_pattern = $tasks->start_pattern;
        $start_schedule = $tasks->start_schedule;
        //due
        $due_pattern = $tasks->due_pattern;
        $due_schedule = $tasks->due_schedule;
        
        $object_month = $history->object_month;
        //指定月の土日祝日を取得（google calender api使用予定）　
            
        
        if($start_pattern == 1)
        {   
            //月初●営業日
            
            $period = $this->businessDate($object_month);
            // $periodからkey:●-1のvalueを取得
            $history->start_date = current(array_slice($period, $start_schedule-1, 1, true)) ; 
            
        }else if ($start_pattern ==2)
        {
            //固定日（土日祝前倒し）
            $date = $object_month."-".$start_schedule;
            
            $history->start_date = $this->calcSubBusinessDate($date);
        
        }else if($start_pattern ==3)
        {
            $date = $object_month."-".$start_schedule;
            
            $history->start_date = $this->calcAddBusinessDate($date);
        }
        
        //作業期限の算出
        if($due_pattern == 1)
        {
            //月初●営業日
            $period = $this->businessDate($object_month);
            $history->start_date = current(array_slice($period, $due_schedule-1, 1, true)) ; 
            
        }else if($due_pattern == 2)
        {
            //固定日（土日祝日前倒し）
            $date = $object_month."-".$due_schedule ;
            $history->due_date = $this->calcSubBusinessDate($date);
            
        }
        else if($due_pattern == 3)
        {
            //固定日（土日祝日後倒し）
            $date = $object_month."-".$due_schedule ;
            $history->due_date = $this->calcAddBusinessDate($date);
            
        }else if($due_pattern == 4)
        {
            //作業月末（土日前倒し）
            $date = date('Y-m-d', strtotime('last day of ' . $object_month));
            $history->due_date = $this->calcSubBusinessDate($date);
        }
        $history->save();
        return redirect('task/create');       
    }
    
    /**
     *指定月の営業日（土日祝日）配列を作成
     * @param 指定月
     * @return　
     **/
    
    private function businessDate($object_month)
    {   
        //指定月の月初と月末の日付を取得
        $firstDate = date('Y-m-d', strtotime('first day of ' . $object_month));
        $lastDate = date('Y-m-d', strtotime('last day of ' . $object_month));
            
            
        //指定期間内の日付を配列にする
        $diff = (strtotime($lastDate) - strtotime($firstDate)) / ( 60 * 60 * 24);
        for($i = 0; $i <= $diff; $i++)
        {
            $period[] = date('Y-m-d', strtotime($firstDate . '+' . $i . 'days'));
        }
        
        //指定月内から土日祝日を排除
        $holidays = array(
            '2020-06' => array('sat1'=>'2020-06-06','sun1'=>'2020-06-07','sat2'=>'2020-06-13','sun2'=>'2020-06-14','sat3'=>'2020-06-20','sun3'=>'2020-06-21','sat4'=>'2020-06-27','sun4'=>'2020-06-28'),
            '2020-07' => array('sat1'=>'2020-07-04','sun1'=>'2020-07-05','sat2'=>'2020-07-11','sun2'=>'2020-07-12','sat3'=>'2020-07-18','sun3'=>'2020-07-19','ho1'=>'2020-07-23','ho2'=>'2020-07-24','sat4'=>'2020-07-25','sun4'=>'2020-07-26'),
            '2020-08' => array('sat1'=>'2020-08-01','sun1'=>'2020-08-02','sat2'=>'2020-08-08','sun2'=>'2020-08-09','ho1'=>'2020-08-10','sat3'=>'2020-08-15','sun3'=>'2020-08-16','sat4'=>'2020-08-22','sun4'=>'2020-08-23','sat5'=>'2020-08-29','sun5'=>'2020-08-30'),
        );
            
        $objectHoliday = $holidays[$object_month];
    
        foreach($objectHoliday as $key => $value)
        {
            $result = array_search($value, $period);
            unset($period[$result]);
            $period = array_values($period); //indexをつめる
        }
            return $period;
    }
    
    
    /**
     * 土日祝関数
     * 
     * @param 日付
     * @return 土日祝の場合：true、そうでない場合：false
     */
    private function isHoliday(String $date)
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
    
    /**
     * 営業日関数（schedule_pattern=2土日祝前倒し）
     * 引数の日付が営業日の場合、営業日を返却する。
     * もし、引数の日付が営業日でない場合(=土日祝のとき）、前営業日を返却する。
     * 
     * @param 日前営業日
     * 付
     * @return 日付（営業日 or 前営業日）
     */
    private function calcSubBusinessDate(String $date)
    {
        if ($this->isHoliday($date)){
            $carbon = new Carbon($date);
            return $this->calcSubBusinessDate($carbon->subDay(1)->toDateString()) ;
        }
        return $date;
    }
    
    /**
     * 営業日関数（schedule_pattern=3土日祝後倒し）
     * 引数の日付が営業日の場合、営業日を返却する。
     * もし、引数の日付が営業日でない場合(=土日祝のとき）、翌営業日を返却する。
     * 
     * @param 日付
     * @return 日付（営業日 or 前営業日）
     */
    private function calcAddBusinessDate(String $date)
    {
        if ($this->isHoliday($date)){
            $carbon = new Carbon($date);
            return $this->calcAddBusinessDate($carbon->addDay(1)->toDateString());
        }
        return $date;
    }
    
}
