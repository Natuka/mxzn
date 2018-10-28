@extends('layout')

@component('common.header')
    @slot('title')
        服务详情
    @endslot
@endcomponent

@section('container')

    <br>
    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd"><img src=""></div>
            <div class="weui-cell__bd">
                <p>服务单号</p>
            </div>
            <div class="weui-cell__ft">说明文字</div>
        </div>
    <div class="weui-cell">
            <div class="weui-cell__hd"><img src=""></div>
            <div class="weui-cell__bd">
                <p>当前状态</p>
            </div>
            <div class="weui-cell__ft">说明文字</div>
        </div>
    <div class="weui-cell">
            <div class="weui-cell__hd"><img src=""></div>
            <div class="weui-cell__bd">
                <p>服务类别</p>
            </div>
            <div class="weui-cell__ft">说明文字</div>
        </div>
    <div class="weui-cell">
            <div class="weui-cell__hd"><img src=""></div>
            <div class="weui-cell__bd">
                <p>受理方式</p>
            </div>
            <div class="weui-cell__ft">说明文字</div>
        </div>
    <div class="weui-cell">
            <div class="weui-cell__hd"><img src=""></div>
            <div class="weui-cell__bd">
                <p>受理时间</p>
            </div>
            <div class="weui-cell__ft">说明文字</div>
        </div>
    <div class="weui-cell">
            <div class="weui-cell__hd"><img src=""></div>
            <div class="weui-cell__bd">
                <p>受理人</p>
            </div>
            <div class="weui-cell__ft">说明文字</div>
        </div>
    <div class="weui-cell">
            <div class="weui-cell__hd"><img src=""></div>
            <div class="weui-cell__bd">
                <p>客户名称</p>
            </div>
            <div class="weui-cell__ft">说明文字</div>
        </div>
    </div>

    <div class="weui-cells__title">报修人</div>

    <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
                <p>报修人电话</p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
                <p>联系地址</p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
    </div>

    <div class="weui-tabbar">
        <a href="{{url('/repair/sign/1')}}" class="weui-tabbar__item" url="{{url('/repair/sign/1')}}">
            <p href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">签到</p>
        </a>
        <a href="{{url('/repair/action/1')}}" class="weui-tabbar__item" url="{{url('/repair/action/1')}}">
            <p href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">处理</p>
        </a>
        <a href="{{url('/repair/document/1')}}" class="weui-tabbar__item" url="{{url('/repair/document/1')}}">
            <p href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">附件</p>
        </a>
        <a href="javascript:;" class="weui-tabbar__item" id="mx-action">
            <p href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">更多</p>
        </a>
    </div>

@stop



@section('endOfJs')
    <script>
        $(function () {
            var action = $('#mx-action')
            action.on('click', function () {
                $.actions({
                    actions: [{
                        text: "转派",
                        onClick: function() {
                            $.alert('转派')
                            //do something
                        }
                    },{
                        text: "完工",
                        onClick: function() {
                            //do something
                            $.alert('完工')
                        }
                    },{
                        text: "修改",
                        onClick: function() {
                            //do something
                            $.alert('修改')
                        }
                    },{
                        text: "取消",
                        onClick: function() {
                            //do something
                            $.alert('取消')
                        }
                    },{
                        text: "备件/耗材",
                        onClick: function() {
                            $.alert('备件/耗材')
                        }
                    },{
                        text: "服务项目",
                        onClick: function() {
                            //do something
                            $.alert('服务项目')
                        }
                    },{
                        text: "签到记录",
                        onClick: function() {
                            //do something
                            $.alert('签到记录')
                        }
                    },{
                        text: "操作记录",
                        onClick: function() {
                            //do something
                            $.alert('操作记录')
                        }
                    },{
                        text: "催单记录",
                        onClick: function() {
                            //do something
                            $.alert('催单记录')
                        }
                    }]
                });
            })
        })
    </script>
@stop
