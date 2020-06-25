<!DOCTYPE html>
{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'task新規作成'を埋め込む --}}
@section('title', '編集画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')

<div  class="container">
    <h1>編集</h1>
    <div>
        
        <form action="{{ action('TaskController@update') }}" method="post" enctype="multipart/form-data">
            @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif

        <!--左　作業者-->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
            
                        <div class="form-group">
                            <table class="table">
                                <tr><td>ID</td><td>{{ $task_form->task_id }}</td></tr>
                                <tr><td>タスク名</td><td>{{ $task_form->title }}</td></tr>
                                <tr><td>作業担当者</td><td><input type="text" name="name_work" value="{{ $task_form->name_work}}"/></td></tr>
                                <tr><td>確認依頼日</td><td><input type="date" name="request_date" value="{{ $task_form->request_date }}"/></td></tr>
                                <tr><td>確認期限日</td><td><input type="date" name="delivery_date" value="{{ $task_form->delivery_date }}"/></td></tr>
                                <tr><td>備考</td><td> <textarea class="form-control" name="free" rows="5">{{  $task_form->free }}</textarea></td></tr>
                            </table>
                        </div>
                    </div>
                </div>        
            </div>
        
        
        <!--右上　確認者以上に表示　権限付-->
        
        
        <div class="col-md-4">
        @can('reviewer_higher')
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">確認者入力欄</h5>
                    <div class="row">
                        <label class="col-md-3" for="check_name">確認者</label>
                        <div class="col-md-6">
                            <input type="text" name="name_check" value="{{ $task_form->name_check}}">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3" for="check_date">確認日</label>
                        <div class="col-md-6">
                            <input type="date" name="check_date" value="{{ $task_form->check_date}}">
                        </div>
                    </div>
                </div>
            </div>
        @endcan
            <br>
            <br>
            <br>
            <!--右下部長のみ表示-->
            @can('dept_manager')           
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">部長入力欄</h5>
                        <div class="row">
                            <label class="col-md-3" for="">承認日</label>
                            <div class="col-md-6">
                                <input type="date" name="dept_date" value="{{ $task_form->dept_date }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            <br>
            <br>
            <div class="col">
            <div class="card bg-light border-danger">
                <h5 class="card-header">必ず変更してください</h5>
                <div class="card-body">
                    
                    <label for="status">ステータス</label>
                    <select name="status" id="status" class="form-group">
                        @foreach(\App\History::STATUS as $key => $val)
                            <option
                                value="{{ $key }}"
                                {{ $key == old('status', $task_form->status) ? 'selected' : '' }}
                                >
                                {{ $val['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            </div>
            <br>
            <div class="float-right">
                    <div class="row">
                        <input type="hidden" name="task_id" value="{{ $task_form->task_id }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="更新">
                    </div>    
            </div>
            
        </div>
        </div>
        </form>
    </div>

    
    
</div>



@endsection