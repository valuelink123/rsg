<!DOCTYPE html>
<html>
<head>
<link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="/assets/pages/css/signup-signin.css" rel="stylesheet" id="style_components" type="text/css" />

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function chk_form(){
        var notification = document.getElementById("notification");
        var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
        var msg = "";

        var email = document.getElementById("email");
        var trim_email = email.value.trim();
        var password = document.getElementById("password");
        var trim_password = password.value.trim();

        if(trim_email==""){
            msg = "Email cannot be blank.";
            email.focus();
        }
        else if(!preg.test(trim_email)){
            msg = "Email format is invalid.";
            email.focus();
        }
        else if(trim_password==""){
            msg = "Password cannot be blank!";
            password.focus();
        }

        if(msg != ""){
            notification.innerText = msg;
            notification.style = "color:red; display:block";
            return false;
        }

        return true;

    }
</script>

</head>

<body class="hide_scrollbar">
<div class="container-fluid padding_horizontal_zero">
    <div>
        <div id="sign_left_image" class="padding_horizontal_zero pull-left">
            <img src="/assets/pages/img/welcome_to_ctg.png" class="signin_img_size_adjustment padding_horizontal_zero" alt="">
        </div>
        <div class="padding_horizontal_zero bgcolor_grey pull-left right_side_size">
            <div class="sign_top_logo"></div>
            <div class="signup_signin_text signin_text_margin_bottom"><b>SIGN IN</b></div>
            <div>
                <form id="signin_form">
                    {{ csrf_field() }}
                    <div class="sign_form_outer_layout">
                        <div class="sign_form_inner_layout">
                            <label for="email" class="signin_label_margin_top">Email</label>
                            <input type="email" id="email" name="email" class="form-control input_show_only_bottomline" placeholder="Email" required autofocus>
                            <label for="password" class="signin_label_margin_top">Password</label>
                            <input type="password" id="password" name="password" class="form-control input_show_only_bottomline" placeholder="Enter Password" required>
                            <label id="notification" style="color:red; display:block;">&nbsp;</label>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-circle red col-xs-8 col-xs-offset-2 col-md-8 col-md-offset-2 signin_submit signin_button_margin_top" role="button">
                            OK
                        </button>
                    </div>
                </form>
            </div>

            <div class="clearfix"></div>
            <div class="text_center">
                <p>By continuing, you agree to to terms & conditions</p>
            </div>
        </div>
    </div>
</div>


</body>
</html>



<script type="text/javascript">

    $(document).ready(function() {
        // document is loaded and DOM is ready
        var width = parent.document.body.clientWidth;
        if(width < 960){
            $('#sign_left_image').hide();
        }
    });

    $(".signin_submit").on('click', function() {

        var check_result = chk_form();
        if(!check_result){
            return false;
        }

        $.ajax({
            type: 'post',
            url: '/rsg_signin_handle',
            data:$("#signin_form").serialize(),
            dataType: 'json',
            success: function (res) {
                if (res) {
                    var msg = res.msg;
                    if (msg == "successful") {
                        var success_msg = "Login successfully";

                        $("#notification").html(success_msg);
                        $("#notification").css({'color':'green'});
                        $("#notification").show();

                        setTimeout("window.top.location='/'", 2000);
                        return false;
                    }
                    else {
                        $("#notification").html(msg);
                        $("#notification").show();
                        return false;
                    }
                }
                else {
                    //操作失败
                    alert('Failed');
                }
            },
            error: function (res){
            }
        })

        return false;
    })

</script>
