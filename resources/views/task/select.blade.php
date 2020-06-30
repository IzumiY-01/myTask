<!DOCTYPE html>
{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'task新規作成'を埋め込む --}}
@section('title', 'タスク一覧')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')

<div  class="container">
    <div class="row">
        <h1>タスク詳細検索</h1>
    </div>
        <a class="btn btn-danger" data-toggle="collapse" href="#select1">
          詳細検索
        </a>
        <div class="collapse" id="select1">
         作業担当者
         <br>
         <input type="text" name="work_name"/>
        </div>
    
</div>
@endsection