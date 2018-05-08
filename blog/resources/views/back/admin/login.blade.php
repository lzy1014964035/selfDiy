<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Free Bootstrap Admin Template : Binary Admin</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="/css/back/bootstrap.css" rel="stylesheet"/>
    <!-- FONTAWESOME STYLES-->
    <link href="/css/back/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLES-->
    <link href="/css/back/custom.css" rel="stylesheet"/>
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>

</head>
<body>
<div class="container">
    <div class="row text-center ">
        <div class="col-md-12">
            <br/><br/>
            <h2> Binary Admin : Login</h2>

            <h5>( Login yourself to get access )</h5>
            <br/>
        </div>
    </div>
    <div class="row ">

        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong> Enter Details To Login </strong>
                </div>
                <div class="panel-body">
                    <form role="form">
                        <br/>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Your Username "/>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Your Password"/>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox"/> Remember me
                            </label>
                            <span class="pull-right">
                                                   <a href="#">Forget password ? </a>
                                            </span>
                        </div>

                        <a  class="btn btn-primary " onclick="login()">登陆</a>
                        <hr/>
                        Not register ? <a href="registeration.html">click here </a>
                    </form>
                </div>

            </div>
        </div>


    </div>
</div>


<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="/js/back/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="/js/back/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="/js/back/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="/js/back/custom.js"></script>

</body>
</html>
<script>
    /**
     * 登陆
     */
    function login() {
        // 定义参数
        var url = '/index.php/back/adminLoginDeal';
        var data = {
            'username': $('[name=username]').val(),
            'password': $('[name=password]').val(),
            '_token': '{{csrf_token()}}'
        };
        var format = 'json';
        // 定义回调
        var functionItem = function (data) {

            if (data.error) {
                alert(data.error);
                return false;
            }
            if (data.success) {
                window.location.href="/index.php/back";
            }
        };

        // 发起请求
        $.post(url,data,functionItem,format);
    }

</script>
