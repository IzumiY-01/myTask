<!DOCTYPE html>
{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'task新規作成'を埋め込む --}}
@section('title', 'タスク一覧')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')

<div  class="container">
    <div class="row">
        <h1>タスク一覧</h1>
    </div>
        <br>
        <div class="col-md-12">
            <form action="{{ action('TaskController@index') }}" method="get">
                    <div class="form-group">
                        <div class="row">
                             <div class="col-md-2">
                                {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                            
                            </div>
                            <label class="col-md-2">対象月</label>
                            <div class="col-md-3">
                            <input type="month" class="form-control" name="cond_month" value="{{$cond_month}}">
                            </div>
                        </div>
                        <br>
                        <a class="btn btn-link" data-toggle="collapse" href="#select1">
                         詳細設定
                        </a> 
                            <div class="collapse" id="select1">
                                <div class="row">
                                    <label class="col-md-3">作業担当者</label>
                                    <div class="col-md-3">
                                    <input type="text" class="form-control" name="cond_name" value="{{$cond_name}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3">作業期限</label>
                                    <div class="col-md-3">
                                    <input type="date" class="form-control" name="cond_due" value="{{$cond_due}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3">作業開始</label>
                                    <div class="col-md-3">
                                    <input type="date" class="form-control" name="cond_start" value="{{$cond_start}}">
                                    </div>
                                </div>    
                                <div class="row">
                                    <label class="col-md-3">ステータス</label>
                                    <div class="col-md-6">
                                        <select name="cond_status" id="status" class="form-group">
                                            <option value=" ">未選択</option>
                                            <option value="1" @if($cond_status=='未着手') selected @endif>未着手</option>
                                            <option value="2" @if($cond_status=='確認依頼中') selected @endif>確認依頼中</option>
                                            <option value="3" @if($cond_status=='承認依頼中') selected @endif>承認依頼中</option>
                                            <option value="4" @if($cond_status=='完了') selected @endif>完了</option>
                                            <!--@foreach(\App\History::STATUS as $key => $val)-->
                                            <!--<option value="{{ $key }}">-->
                                            <!--        {{ $val['label'] }}-->
                                            <!--</option>-->
                                            <!--@endforeach-->
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
            </form>
            
        </div>
        <div class="row">
            <div class="list-tasks col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width>ID</th>
                                <th width>タスク名</th>
                                <th width>カテゴリ</th>
                                <th width>作業担当</th>
                                <th width>作業期限</th>
                                <th width>作業開始</th>
                                <th width>ステータス</th>
                                <th width>確認依頼日</th>
                                <th width>確認期限</th>
                                <th width>確認日</th>
                                <th width>確認者</th>
                                <th width>部長承認</th>
                                <th width>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                    <th>{{ $task->task_id }}</th>
                                    <th>{{ $task->title }}</th>
                                    <th>{{ \App\Task::CATEGORY[$task->category]['label'] }}</th>
                                    <th>{{ $task->name_work }}</th>
                                    <th>{{ $task->due_date }}</th>
                                    <th>{{ $task->start_date }}</th>
                                    <td>{{ \App\History::STATUS[$task->status]['label'] }}</td>
                                    <th>{{ $task->request_date }}</th>
                                    <th>{{ $task->delivery_date }}</th>
                                    <th>{{ $task->check_date }}</th>
                                    <th>{{ $task->name_check }}</th>
                                    <th>{{ $task->dept_date }}</th>
                                    <td>
                                        <div>
                                        <a href="{{ action('TaskController@edit', ['task_id' => $task->task_id]) }}">編集</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>            
            </div>
        </div>
    
</div>
@endsection
