<head>
    <meta charset="utf-8" />
    <title>RSG</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content=""  name="description" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/socicon/socicon.css" rel="stylesheet" type="text/css" />

    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/assets/pages/css/about.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/pages/css/faq.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>



<script type="text/template" id="modal-template">
    <div class="modal centered-modal" id="dynamicallyInjectedModal" tabindex="-1" role="dialog" aria-labelledby="modal-title">
        <div class="modal-dialog modal-vertical-centered" role="document" style="width:<%= width %>;height:<%= height %>;">
        <div class="modal-content">
            <!-- 实现注册登录功能，需要把以下这个div注释掉。-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div id="iframe-loading" class="text-muted small" style="display:none; text-align:center;"><img id="img_loading" src="/assets/pages/img/loading.gif"></div>
                <iframe id="modal-iframe" name="modal-iframe" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    </div>
</script>

<input type="hidden" id="from" value="{!! $from !!}">

<script type="text/template" id="modal-success">
    <div class="modal centered-modal" id="" tabindex="-1" role="dialog" aria-labelledby="success-title">
        <div class="success-dialog success-vertical-centered" role="document" >
            <div class="success-content">
                <div class="success-header">
                    <div class="header-content">Finish 100%!</div>
                </div>
                <div class="">
                    <div class="body-content">
                        Thank you for sharing your experience!<br>

                        You can expect your free gift in 4-6 days!
                    </div>
                    <div class="body-content">
                        Would you also like to test and keep the products for free?<br>

                        It is only eligible for our regular customer like you!
                    </div>
                </div>
                <div class="modal-bottom">
                    <button type="button" class="submit success-submit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Choose one to test now!</span></button>
                </div>
            </div>
        </div>
    </div>
</script>

<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script>
<script src="/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/global/scripts/underscore-min.js"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<script>
    function showModal(title, width, height) {
        var width = width ? width : "100%";
        var height = height ? height : "100%";
        var modal = $(_.template($('#modal-template').html())({
            width: width,
            height: height
        })).modal({
            show: true,
            keyboard: true,
        }).on('hidden.bs.modal', function() {
            $(this).find('iframe').html("").attr("src", "");
            $('#dynamicallyInjectedModal').remove();
        });
        modal.find('iframe').hide();

        <!--width有相对值和绝对值两种，比如650px, 50%。将px转成数字，例如：650px -> 650)-->
        if(width.indexOf('px') > -1){
            var temp_width = width.substring(0, width.length-2);
            <!--加载图片原始大小是400x300, iframe宽度>=400时，图片显示实际大小，否则按比例缩小。这样不会有闪烁的现象。-->
            var image_width = (temp_width >= 400) ? 400 : temp_width;
            modal.find('#img_loading').css('width', image_width);
        }

        modal.find('#iframe-loading').show();
        modal.find('iframe').on("load", function() {
            modal.find('#iframe-loading').hide();
            modal.find('iframe').show();
        });
    }

    function showModalSuccess(title) {
        var width ="100%";
        var height = "100%";
        var modal = $(_.template($('#modal-success').html())({
            width: width,
            height: height
        })).modal({
            show: true,
            keyboard: true,
        }).on('hidden.bs.modal', function() {
            $(this).find('iframe').html("").attr("src", "");
        });
        modal.find('iframe').hide();
        modal.find('#iframe-loading').show();
        modal.find('iframe').on("load", function() {
            modal.find('#iframe-loading').hide();
            modal.find('iframe').show();
        });
    }

    $(function() {
        $('body').on('click', 'button.trigger-modal', function() {
            typeof(showModal) === 'function' ?
                showModal($(this).text(), $(this).attr('data-width'), $(this).attr('data-height')):
                alert('"showModal" is not available.');
        });
        var from = $('#from').val();
        if(from=='ctg'){
            showModalSuccess();
        }

        //rule按钮点击事件，点击显示隐藏规则介绍步骤
        $('body').on('click','#home-rule',function(){
            var display = $('#home-rule1').css('display');
            if(display == 'none'){
                $('#home-rule1').show();
            }else{
                $('#home-rule1').hide();
            }
        });

        //获取当前屏幕的宽度，根据宽度设置特殊样式
        var width = document.body.clientWidth;

        if(width >= 960){
            $('#signup_button').attr('data-width', '858px');
            $('#signup_button').attr('data-height', '515px');

            $('#signin_button').attr('data-width', '858px');
            $('#signin_button').attr('data-height', '515px');
        }
        else{
            $('#signup_button').attr('data-width', '332px');
            $('#signup_button').attr('data-height', '515px');

            $('#signin_button').attr('data-width', '332px');
            $('#signin_button').attr('data-height', '515px');
        }

        if(width<768){
                $('.product-detail-son .content img').css('width','100%');
                $('.product-detail-son .content table').css('width','100%');

                $('.product-top .product-right-price .price-price').css('font-size','14px');
                $('.product-top .product-right-price .price-amount').css('font-size','20px');
                $('.product-top .product-right-price .available-number').css('font-size','20px');
                $('.product-top .product-right-price .available-avail').css('font-size','14px');
                $('.product-top').css('padding-left','0px');
                $('.product-top').css('padding-right','0px');
                $('.product-detail-son').css('padding-left','2px');
                $('.product-detail-son').css('padding-right','2px');
                $('.product-top-left').css('padding-left','0px');
                $('.product-top-left').css('padding-right','0px');
                $('.product-top-right').css('padding-left','0px');
                $('.product-top-right').css('padding-right','0px');
                $('.product .product-right-title').css('font-size','12px');

                //首页和详情页的公共部分
                //设置banner高度为130px，在手机端，右边三个按钮会变成3行，确保这三个按钮不会超出banner。
                $('.about-header').css('height','130px');
                $('.logo').css('height','70px');
                $('.top-menu').removeClass('margin-top-30');
                $('.top-menu').addClass('margin-top-10');
                $('.bottom-banner .card-title span').css('font-size','12px');
                $('.bottom-banner .portlet .card-icon img').css('width','100%');
                $('.bottom-banner .portlet.light').css('padding','0px');
                $('.bottom-banner .portlet.light').css('margin-bottom','0px');
                $('.bottom-banner .portlet.light').css('margin-top','-20px');
                $('.bottom-banner .portlet.light').css('height','128px');
                $('.bottom-banner .portlet .card-title').removeClass('margin-top-20');
                $('.bottom-banner .portlet .card-title').addClass('margin-top-10');


            }else{
                $('.product-detail-son .content').css('margin-left','159px');
            }

        //showModal('Notice','50%','60%');
        //$('#modal-iframe').attr("src", "{{url('notice')}}");
    })
</script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'tZ2SQKzogQ';var d=document;var w=window;function l(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
        s.src = '//code.jivosite.com/script/widget/'+widget_id
        ; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
        if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}
        else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
<!-- END THEME LAYOUT SCRIPTS -->
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v3.2'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="107381077272596">
</div>