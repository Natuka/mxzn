@extends('layout')

@section('title')
    TEST
@stop

@section('css')

@stop


@section('container')

    @component('common.header')
        @slot('title')
            处理过程
        @endslot
    @endcomponent


    <div class="weui-flex mlr-20">
        <div class="weui-flex__item">
            <span class="mx-label">操作时间</span>
        </div>
        <div class="weui-flex__item">
            <span class="mx-label">处理方式</span>
        </div>
    </div>
    <div class="weui-flex mlr-20">
        <div class="weui-flex__item">
            <span class="mx-label">处理人</span>
        </div>
        <div class="weui-flex__item">
            <span class="mx-label">处理网店</span>
        </div>
    </div>
    <div class="weui-flex mlr-20">
        <div class="weui-flex__item">
            <span class="mx-label">下步处理</span>
        </div>
        <div class="weui-flex__item">
            <span class="mx-label">下步处理人</span>
        </div>
    </div>
    <div class="weui-flex mlr-20">
        <div class="weui-flex__item">
            <span class="mx-label">下步处理网点</span>
        </div>
        <div class="weui-flex__item">
            <span class="mx-label">操作</span>
        </div>
    </div>
    <div class="weui-flex mlr-20">
        <div class="weui-flex__item"></div>
        <div class="weui-flex__item wx-right">
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">修改</a>
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">删除</a>
        </div>
    </div>
@stop


@section('endOfJs')

@stop
