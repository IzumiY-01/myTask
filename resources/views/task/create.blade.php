<!DOCTYPE html>
{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'task新規作成'を埋め込む --}}
@section('title', 'タスク新規作成')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>タスク新規作成</h2>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ action('TaskController@index') }}" role="button" class="btn btn-primary">一覧画面</a>
                    </div>
                </div>
                <br>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body"> 
                        <form action="{{ action('TaskController@create') }}" method="post" enctype="multipart/form-data">
                            @if (count($errors) > 0)
                                <ul>
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            @endif
                                <div class="form-group row ">
                                    <label class="col-md-3">タスク名</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="input-group row">
                                    <label class="col-md-3">カテゴリー</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" value="1" id="category1">
                                        <label class="form-check-label" for="category1">定例　</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" value="2" id="category2">
                                        <label class="form-check-label" for="category2">イレギュラー</label>
                                    </div>
                                </div>
                                <br>
                                <div class="input-group row">
                                    <label class="col-md-3">対象月</label>
                                    <div class="col-md-3">
                                        <input type="month" class="form-control" name="object_month" value="{{old('object_month')}}">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label class="col-md-3">作業期限</label>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" name="due_date" value="{{ old('due_date') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3">作業担当者</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name_work" value="{{ old('name_work') }}">
                                    </div>
                                </div>
                                <div class="input-group row">
                                    <label class="col-md-3">部長承認</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="dept_check" value="1" id="dept_check1">
                                        <label class="form-check-label" for="dept_check1">要　</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="dept_check" value="2" id="dept_check2">
                                        <label class="form-check-label" for="dept_check2">不要</label>
                                    </div>
                                </div>
                                <br>
                                <!--期限スケジュール--> 
                                <div class="form-group">
                                    <label>期限スケジュール</label>
                                    
                                    <div class="input-group row">
                                        <div class="form-check">
                                            <input type="radio" name="due_pattern" value="1" id="due_pattern01"　checked="checked"/><label>月初からXX営業日 </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="due_pattern" value="2" id="due_pattern02"/><label>固定（土日祝前倒し）</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="due_pattern" value="3" id="due_pattern03"/><label>固定（土日祝後倒し）</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="due_pattern" value="4" id="due_pattern04"/><label>月末（土日祝前倒し）</label>
                                        </div>
                                    </div>
                                    <br>
                                <div class="input-group row">
                                        <label class="col-md-3">入力</label>
                                        <div class="text text01">
                                            <label>月初から</label>
                                            <input type="text" class="col-md-3"  id="due_schedule1" name="due_schedule1" value="{{old('due_schedule')}}">
                                            <label>営業日</label>
                                        </div>
                            
                                        <div class="text text02">
                                            <label>毎月</label>
                                            <input type="text" class="col-md-3" id="due_schedule2" name="due_schedule2" value="{{old('due_schedule')}}">
                                            <label>日（土日祝前倒し）</label>
                                        </div>
                                        <div class="text text03">
                                            <label>毎月</label>
                                            <input type="text" class="col-md-3" id="due_schedule3" name="due_schedule3" value="{{old('due_schedule')}}">
                                            <label>日（土日祝前倒し）</label>
                                        </div>
                                        <div class="text text04">
                                            <label>月末を選択しています。　　＊日付入力不要＊</label>
                                        </div>
                                </div>
                                </div>
                                <br>
                                <br>
                                
                                <div class="form-group">
                                    <label>作業開始スケジュール</label>
                
                                    <div class="input-group row">
                                        <div class="form-check">
                                            <input type="radio" name="start_pattern" value="1" id="start_pattern01"　checked="checked">
                                            <label>月初からXX日</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="start_pattern" value="2" id="start_pattern02">
                                            <label>固定(土日祝前倒し)</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="start_pattern" value="3" id="start_pattern03">
                                            <label>固定（土日祝後倒し）</label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input-group row">
                                        <label class="col-md-3">入力</label>
                                        <div class="row">
                                            <div class="text00 text05">
                                                <label>月初から</label>
                                                <input type="text" class="col-md-3"  id="start_schedule1" name="start_schedule1" value="{{old('start_schedule')}}">
                                                <label>営業日</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text00 text06">
                                                <label>毎月</label>
                                                <input type="text" class="col-md-3"  id="start_schedule2" name="start_schedule2" value="{{old('start_schedule')}}">
                                                <label>日（土日祝前倒し）</label>
                                            </div>
                                        </div>
                                            <div class="text00 text07">
                                                <label>毎月</label>
                                                <input type="text" class="col-md-3"  id="start_schedule3" name="start_schedule3" value="{{old('start_schedule')}}">
                                                <label>日（土日祝後倒し）</label>
                                            </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label class="col-md-2">備考</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="free" value="{{ old('free') }}">
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                
                                <br>
                                <div>
                                <input type="submit" class="btn btn-primary" value="作成">
                                </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>            
                           
                
            </div>
        </div>
    </div>
@endsection