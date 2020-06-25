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
                    <div class="form-group row">
                        <label class="col-md-2">対象月</label>
                        <div class="col-md-3">
                            <input type="month" class="form-control" name="cond_month" value="{{'$cond_month'}}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
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
</div>
@endsection
