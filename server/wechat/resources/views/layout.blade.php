<!-- 以最简单的形式进行实现，不在采用单页面 -->
<!DOCTYPE html>
<html>
<head>
    <title>@section('title')
           TEST
        @show</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <!-- head 中 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">
    <link rel="stylesheet" href="/css/common.css" />

    @section('css')

    @show
</head>

<body ontouchstart>
<!-- 内容 -->
<div id="container">
    @yield('container')
</div>


<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script>
$(function () {
    FastClick.attach(document.body)
});
</script>
<script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>
<script src="/js/common.js?v=0.0.2.2"></script>

@section('endOfJs')
@show
</body>

</html>
