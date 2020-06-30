<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use App\History;
use Carbon\Carbon;
use App\Libs\CommonFunction;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{   
    /**
     *作業開始/作業期限のスケジュールを決めるパータン
     *  1:WORKDAY  月初からx営業日パターン：
     *  2:FIXED_PRE 固定x日（土日祝前倒し）：
     *  3:FIXED_POST 固定x日（土日祝後倒し）：
     *  4:LASTDAY 月末
     **/
    const WORKDAY = 1;
    const FIXED_PRE = 2;
    const FIXED_POST = 3;
    const LASTDAY = 4;
    
    //task新規作成画面表示
    public function add()
    {
        return view('task.create');
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
        
        //作業開始パターンとスケジュール取得　formへ追加・削除
        $start_pattern = $request->start_pattern;
            if($start_pattern == self::WORKDAY)
            {
                 $start_schedule = $request->start_schedule1;
                 $form['start_schedule'] = $start_schedule;
                 unset($form['start_schedule1']);
                 unset($form['start_schedule2']);
                 unset($form['start_schedule3']);
            }else if ($start_pattern ==self::FIXED_PRE)
            {
                 $start_schedule = $request->start_schedule2;
                 $form['start_schedule'] = $start_schedule;
                 unset($form['start_schedule1']);
                 unset($form['start_schedule2']);
                 unset($form['start_schedule3']);
            }else if ($start_pattern ==self::FIXED_POST)
            {
                 $start_schedule = $request->start_schedule3;
                 $form['start_schedule'] = $start_schedule;
                 unset($form['start_schedule1']);
                 unset($form['start_schedule2']);
                 unset($form['start_schedule3']);
            }
        
        //作業期限パターンとスケジュール取得　formへ追加・削除
        $due_pattern = $request->due_pattern;
            if($due_pattern == self::WORKDAY)
            {
                 $due_schedule = $request->due_schedule1;
                 $form['due_schedule'] = $due_schedule;
                 unset($form['due_schedule1']);
                 unset($form['due_schedule2']);
                 unset($form['due_schedule3']);
            }else if ($due_pattern ==self::FIXED_PRE)
            {
                 $due_schedule = $request->due_schedule2;
                 $form['due_schedule'] = $due_schedule;
                 unset($form['due_schedule1']);
                 unset($form['due_schedule2']);
                 unset($form['due_schedule3']);
            }else if ($due_pattern ==self::FIXED_POST)
            {
                 $due_schedule = $request->due_schedule3;
                 $form['due_schedule'] = $due_schedule;
                 unset($form['due_schedule1']);
                 unset($form['due_schedule2']);
                 unset($form['due_schedule3']);
            }
        
        
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        $tasks->fill($form);
        $tasks->save();
        
        
         //histories table へ保存 
         // task_id,object_mont,start_date,due_date
         
        $history = new History;
        $history->task_id = $tasks->id;
        $history->object_month = $tasks->object_month;
        
        $start_pattern = $tasks->start_pattern;
        $start_schedule = $tasks->start_schedule;        
        $due_pattern = $tasks->due_pattern;
        $due_schedule = $tasks->due_schedule;
        
        $object_month = $history->object_month;
        //指定月の土日祝日を取得（google calender api使用予定）　
        
        
            
        //作業開始日の算出
        if($start_pattern == self::WORKDAY)
        {   
            //月初●営業日
            $period = $this->businessDate($object_month);
            // $periodからkey:●-1のvalueを取得
            $history->start_date = current(array_slice($period, $start_schedule-1, 1, true)) ; 
            
        }else if ($start_pattern ==self::FIXED_PRE)
        {
            //固定日（土日祝前倒し）
            $date = date('Y-m-d', strtotime($object_month."-".$start_schedule));
            
            $history->start_date = $this->calcSubBusinessDate($date);
        
        }else if($start_pattern ==self::FIXED_POST)
        {
            //固定日（土日祝後倒し）
            $date = date('Y-m-d', strtotime($object_month."-".$start_schedule));
            $history->start_date = $this->calcAddBusinessDate($date);
        }
        
        //作業期限の算出
        if($due_pattern == self::WORKDAY)
        {
            //月初●営業日
            $period = $this->businessDate($object_month);
            $history->due_date = current(array_slice($period, $due_schedule-1, 1, true)) ; 
            
        }
        else if($due_pattern == self::FIXED_PRE)
        {
            //固定日（土日祝日前倒し）
            $date = date('Y-m-d', strtotime($object_month."-".$due_schedule));
            
            $history->due_date = $this->calcSubBusinessDate($date);
            
        }
        else if($due_pattern == self::FIXED_POST)
        {
            //固定日（土日祝日後倒し）
            $date = date('Y-m-d', strtotime($object_month."-".$due_schedule));
            $history->due_date = $this->calcAddBusinessDate($date);
            
        }
        else if($due_pattern == self::LASTDAY)
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
     * 営業日関数（schedule_pattern=2土日祝前倒し）
     * 引数の日付が営業日の場合、営業日を返却する。
     * もし、引数の日付が営業日でない場合(=土日祝のとき）、前営業日を返却する。
     * 
     * @param 日前営業日
     * 付
     * @return 日付（営業日 or 前営業日）
     */
    private function calcSubBusinessDate($date)
    {
        if (CommonFunction::isHoliday($date)){
            $carbon = new Carbon($date);
            return $this->calcSubBusinessDate($carbon->subDay(1)) ;
            //->toDateString()
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
    private function calcAddBusinessDate($date)
    {
        if (CommonFunction::isHoliday($date)){
            $carbon = new Carbon($date);
            return $this->calcAddBusinessDate($carbon->addDay(1));
        }
        return $date;
    }
    
    /**
     * タスク一覧表示
     * 
     **/
    
    public function index(Request $request)
    {   
        
        //検索時に入力した項目を取得
        $cond_month = $request->input('cond_month');
        $cond_name = $request->input('cond_name');
        $cond_status = $request->input('cond_status');
        $cond_due = $request->input('cond_due');
        $cond_start = $request->input('cond_start');
        
        //検索クエリ作成
        $query = Task::query();
        //dd($request->cond_due);
        
        //結合
        $query->join('histories', function ($query) use ($request) {
        $query->on('tasks.id','=','histories.task_id');
        });
        
        //条件
        if(!empty($cond_month)){
        $query->where('histories.object_month',$cond_month);
        }
        
        if(!empty($cond_name)){
        $query->where('tasks.name_work','like','%'.$cond_name.'%');
        }
        
        
        if(!empty($cond_due)){
        
        $query->where('histories.due_date',$cond_due);
        }
        
        if(!empty($cond_start)){
        
        $query->where('histories.start_date',$cond_start);
        }
       
        if(!empty($cond_status)){
        $query->where('histories.status',$cond_status);
        }
       
        
        $tasks = $query->paginate(10);
        
        
        return view('task.index',compact(['tasks','cond_month','cond_name','cond_due','cond_start','cond_status']));
    }
    
    /**
     * 編集画面
     * 
     **/
    public function edit(Request $request)
    {   
        $task_id = $request->task_id;
        $task_form = DB::table('tasks')
                    ->select('histories.*','tasks.title','tasks.category','tasks.name_work','tasks.free')
                    ->join('histories','tasks.id','=','histories.task_id')
                    ->where('histories.task_id',$task_id)
                    ->first();
        
        if (empty($task_form)){
            abort(404);    
        }
        
        return view('task.edit',compact('task_form'));
    }
    
    /**
     *更新 
     * 
     * tasks:name_work,free
     * histories:status,request_date,delivery_date,check_date,name_check,dept_date
     * 
     **/
    public function update(Request $request)
    {   
        //該当のタスクをTaskモデルから取得
        $task = Task::find($request->task_id);
        
        //フォームから送信されてきた作業担当者を取得
        //フォームから送信されてきた備考欄を取得
        $task->name_work = $request->name_work;
        $task->free = $request->free;
        //tasksテーブルへ保存
        $task->save();
        
        //該当のタスクをhistoryモデルから取得
        
        $history = History::where('task_id',$request->task_id)->first();
        
        $history->status = $request->status;
        $history->request_date = $request->request_date;
        $history->delivery_date =$request->delivery_date;
        $history->check_date = $request->check_date;
        $history->name_check = $request->name_check;
        $history->dept_date = $request->dept_date;
        
        $history->save();
        
        return redirect('task');
    }
    
    public function select()
    {
        return view('task.select');
    }
   
}
