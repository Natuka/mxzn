@extends('layout')

@section('title')
    手机号绑定
@stop

@section('css')

@stop


@section('container')

    <header class="mx-header">
        <h1 class="mx-title">
            手机绑定
        </h1>
    </header>

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input id="mobile" class="weui-input" type="tel" placeholder="请输入手机号">
            </div>
            <div class="weui-cell__ft">
                <button id="send-btn" class="weui-vcode-btn">获取验证码</button>
                <button id="send-timeout" class="weui-vcode-btn mx-hide">获取验证码</button>
            </div>
        </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
            <div class="weui-cell__bd">
                <input id="code" class="weui-input" type="number" placeholder="请输入验证码">
            </div>
            <div class="weui-cell__ft">
                <img id="refresh-code" class="weui-vcode-img" src="./images/vcode.jpg">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">短信验证码</label></div>
            <div class="weui-cell__bd">
                <input id="sms-code" class="weui-input" type="number" pattern="[0-9]*" placeholder="请输短信验证码">
            </div>
        </div>
    </div>

    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
    </div>
@stop


@section('endOfJs')
    <script>
    $(function () {
        var sendBtn = $('#send-btn')
        var timeoutBtn = $('#send-timeout')
        var codeInput = $('#code')
        var mobileInput = $('#mobile')
        var refreshCodeImg = $('#refresh-code')
        var smsCodeInput = $('#sms-code')

        var submitBtn = $('#showTooltips')
        var timeout = 59
        var timeoutId = null
        var clicked = false

        // 发送
        sendBtn.on('click', function () {
            var mobileText = $.trim(mobileInput.val())
            var codeText = $.trim(codeInput.val())
            if (!mobileText) {
                $.alert('请输入手机号')
                return
            }

            if (!/^1\d{10}$/.test(mobileText)) {
                $.alert('手机号格式错误')
                return
            }

            if (!codeText) {
                return $.alert('请输入图形验证码')
            }

            ApiRequest.post('/sms/send', {mobile: mobileText, code: codeText}).done(function () {
                downCount()
            }).fail(function (e) {
                resetDownCount()
                $.alert(e || '获取失败，请重试')
            }).always(function () {
                console.log('send always')
            })
        })

        function resetClick() {
            clicked = false
        }

        function gotoIndex() {
            setTimeout(function () {
                window.location.href = '/'
            }, 1000)
        }

        // 保存
        submitBtn.on('click', function (e) {
            if (clicked) {
                return
            }
            clicked = true
            var mobileText = $.trim(mobileInput.val())
            var smsCodeText = $.trim(smsCodeInput.val())
            if (!mobileText) {
                resetClick()
                $.alert('请输入手机号')
                return
            }

            if (!/^1\d{10}$/.test(mobileText)) {
                resetClick()
                $.alert('手机号格式错误')
                return
            }

            if (!smsCodeText) {
                resetClick()
                return $.alert('请输入短信验证码')
            }

            ApiRequest.post('/mobile/bind', {mobile: mobileText, smsCode: smsCodeText}).done(function () {
                $.alert('绑定成功')
                gotoIndex()
            }).fail(function (data, message) {
                $.alert(message || '绑定失败')
            }).always(function () {
                resetClick()
            })
        })

        function resetDownCount() {
            sendBtn.removeClass('mx-hide')
            timeoutBtn.addClass('mx-hide')
            timeout = 59
        }

        function setDownCount() {
            timeout--
            sendBtn.addClass('mx-hide')
            timeoutBtn.removeClass('mx-hide')
        }

        function downCount() {
            if (timeout < 0) {
                resetDownCount()
                return
            }
            setDownCount()
            timeoutBtn.text('(' + timeout + ')秒后重新获取')
            timeoutId = setTimeout(function () {
                downCount()
            }, 1000)
        }
    })

    </script>
@stop
