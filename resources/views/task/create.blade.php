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
                <form action="{{ action('TaskController@create') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                        <div class="form-group row">
                            <label class="col-md-2">タスク名</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="input-group row">
                            <label class="col-md-2">カテゴリー</label>
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
                            <label class="col-md-2">対象月</label>
                            <div class="col-md-3">
                                <input type="month" class="form-control" name="object_month" value="{{old('object_month')}}">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="col-md-2">作業期限</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="due_date" value="{{ old('due_date') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">作業担当者</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name_work" value="{{ old('name_work') }}">
                            </div>
                        </div>
                        <div class="input-group row">
                            <label class="col-md-2">部長承認</label>
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
                        <div class="form-group row">
                            <label>期限スケジュール</label>
                            <table class="table">
                            <tr>
                                <th>パターン</th>
                                <td>
                                    <lavel><input type="radio" name="due_pattern" value="1" onclick="patternChange()" checked />月初</lavel>
                                    <lavel><input type="radio" name="due_pattern" value="2" onclick="patternChange()" />固定（土日祝前倒し）</lavel>
                                    <lavel><input type="radio" name="due_pattern" value="3" onclick="patternChange()" />固定（土日祝後倒し）</lavel>
                                    <lavel><input type="radio" name="due_pattern" value="4" onclick="patternChange()" />月末（土日祝前倒し）</lavel>
                                </td>
                            </tr>
                            <tr>
                                <th>暫定</th>
                                <td>
                                    <input type="text" class="col-md-2" name="due_schedule" value="{{old('due_schedule')}}">
                                    <p>営業日/固定日/月末あとでjs実装する予定・・・</p>
                                </td>
                            </tr>
                            <!--
                            <tr id="due_pattern01">
                                <th>月初から</th>
                                <td><input type="text" class="col-md-1" id="due_schedule1" name="due_schedule" value="{{old('due_schedule')}}">
                                <p>営業日</p>
                                </td>
                            </tr>
                            <tr id="due_pattern02">
                                <th>毎月</th>
                                <td><input type="text" class="col-md-1" id="due_schedule1" name="due_schedule" value="{{old('due_schedule')}}">
                                <p>日（土日祝前倒し）</p>
                                </td>
                            </tr>
                            <tr id="due_pattern03">
                                <th>毎月</th>
                                <td><input type="text" class="col-md-1" id="due_schedule1" name="due_schedule" value="{{old('due_schedule')}}">
                                <p>日（土日祝後倒し）</p>
                                </td>
                            </tr>
                            <tr id="due_pattern04">
                                <th>月末</th>
                                <td><p>（土日祝前倒し）</p></td>
                            </tr>
                            -->
                            </table>
                        </div>                        
                        
                        <div class="form-group">
                            <label>作業開始スケジュール</label>
                        </div>
                            <div>
                                <input class="form-check-input" type="radio" name="start_pattern" value="1" id="start_pattern1">
                                <label class="form-check-label" for="start_pattern1">月初</label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="start_pattern" value="2" id="start_pattern2">
                                <label class="form-check-label" for="start_pattern2">固定(土日祝前倒し)</label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="start_pattern" value="3" id="start_pattern3">
                                <label class="form-check-label" for="start_pattern3">固定（土日祝後倒し）</label>
                            </div>
                        <div>
                                <div class="col-md-2">
                                <input type="text" class="form-control" name="start_schedule" value="{{old('start_schedule')}}">
                                <p>あとで実装します・・・</p>
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
                        <input type="submit" class="btn btn-primary" value="作成">
                </form> 
            </div>
        </div>
    </div>
@endsection