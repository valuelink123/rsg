<!DOCTYPE html>

<html lang="en">
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
        <link rel="shortcut icon" href="favicon.ico"/></head>
    <!-- END HEAD -->

    <body class=" page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content" style="margin-left:0px;">
                        
                      
                        <!-- END PAGE BAR -->
                       
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN CONTENT HEADER -->
                        <div class="row margin-bottom-40 about-header">
							 <!-- BEGIN PAGE TITLE-->
							<div class="col-md-10 col-md-offset-1" style="text-align:left;">
								<img src="/assets/pages/img/logo.png">
								<div class="margin-top-40 pull-right" style="margin-left:30px;">
									<select class="form-control btn btn-circle red btn-outline" onChange="location.href='/'+this.value" >
										
										<?php
										$langs = config('app.locales');
										foreach($langs as $k=>$v){
										?>
										<option value='{{$k}}' @if(App::getLocale() == $k) selected @else @endif >{{$v}}</option>
										<?php
										}
										?>
										
									</select>
								</div>
                                <div class="margin-top-40 pull-right" style="margin-left:60px;">
                                    <div id="home-rule" class="btn btn-outline red btn-circle">
                                        {!! trans('custom.home-rule') !!}
                                    </div>
                                </div>
								<div class="margin-top-40 pull-right">
									<form action="{{url(App::getLocale().'/getrsg')}}" method="post" target="modal-iframe">
										{{ csrf_field() }}
										<input type="hidden" name="product_id" value="0">
										<input type="hidden" name="customer_email" value="{{$customer_email}}">
										<button type="submit" class="btn btn-circle red btn-outline trigger-modal" role="button" data-width="50%" data-height="60%">
										@if($customer_email)
											{!! trans('custom.home-myproduct') !!}
										@else
											{!! trans('custom.home-join') !!}
										@endif
										</button>
									</form>
									
								</div>
								
							</div>
							
							<!-- END PAGE TITLE-->
                            <div class="col-md-6" style="margin-left:250px;">
                                {!! trans('custom.home-freeproduct') !!}
                            </div>

                            <div id="home-rule1" style="display:none;">
                                <div class="rule-div">
                                    <div class="rule-content">{!! trans('custom.home-rule1') !!}</div>
                                </div>
                            </div>
                        </div>
                        <!-- END CONTENT HEADER -->
                       
                        
                        <!-- BEGIN MEMBERS SUCCESS STORIES -->
                        <div class="row margin-bottom-40 stories-header" data-auto-height="true">
                            <div class="col-md-12">
                                {!! trans('custom.home-freeproduct') !!}
                            </div>
                        </div>
                        <div class="row margin-bottom-40 stories-cont">
						
							@foreach($products as $product)
                            <div class="col-lg-3 col-md-6">
                                <div class="portlet light">
                                    <a href="/product/detail?id={{$product['id']}}" target="_blank">
                                    <div class="photo">
                                       <!--<a href="https://{{array_get($product,'site')}}/dp/{{array_get($product,'asin')}}?m={{array_get($product,'seller_id')}}" target="_blank">--> <img src="{{array_get($product,'product_img')}}" alt="" class="img-responsive" /><!--</a>-->
                                    </div>
                                    </a>
									<div class="progress-info">
                                        <div class="progress">
                                            <span style="width: {{intval(array_get($product,'daily_remain')/array_get($product,'daily_stock')*100)}}%;" class="progress-bar progress-bar-success red-haze">
                                                <span class="sr-only">{{intval(array_get($product,'daily_remain')/array_get($product,'daily_stock')*100)}}% {!! trans('custom.home-left') !!}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="title" >
                                        <span> {{array_get($product,'daily_remain')}} {!! trans('custom.home-AVAILABLE') !!} </span>
										
                                    </div>
									
                                    <div class="desc">
                                        <span><!--<a href="https://{{array_get($product,'site')}}/dp/{{array_get($product,'asin')}}?m={{array_get($product,'seller_id')}}" target="_blank">-->{{array_get($product,'product_name')}} <!--</a>--></span>
                                    </div>
									
									@if (array_get($product,'daily_remain')>0)
									<form action="{{url(App::getLocale().'/getrsg')}}" method="post" target="modal-iframe">
									{{ csrf_field() }}
									<input type="hidden" name="product_id" value="{{array_get($product,'id')}}">
									<input type="hidden" name="customer_email" value="{{$customer_email}}">
									<button type="submit" class="btn btn-circle red col-xs-8 col-xs-offset-2 col-md-8 col-md-offset-2 trigger-modal" role="button" data-width="50%" data-height="60%">{!! trans('custom.home-wantit') !!}</button>
									</form>
									@else
									<span class="btn btn-circle default col-xs-8 col-xs-offset-2 col-md-8 col-md-offset-2">{!! trans('custom.home-Comming') !!}</span>
									@endif
									<div class="clearfix margin-bottom-20"></div>
                                </div>
                            </div>
							 @endforeach
							
                        </div>
						
						<!-- BEGIN CARDS -->
					<div class="row margin-bottom-20">
						<div class="col-lg-4 col-md-4">
							<div class="portlet light">
								<div class="card-icon margin-top-20">
									
									<img src="/assets/pages/img/1.jpg">
								</div>
								<div class="card-title margin-top-20">
									<span> {!! trans('custom.home-s1') !!} </span>
								</div>
								<!--<div class="card-desc">
									<span> The best way to find yourself is
										<br> to lose yourself in the service of others </span>
								</div>-->
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="portlet light">
								<div class="card-icon margin-top-20">
									<img src="/assets/pages/img/2.jpg">
								</div>
								<div class="card-title margin-top-20">
									<span> {!! trans('custom.home-s2') !!} </span>
								</div>
								<!--<div class="card-desc">
									<span> The best way to find yourself is
										<br> to lose yourself in the service of others </span>
								</div>-->
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="portlet light">
								<div class="card-icon margin-top-20">
									<img src="/assets/pages/img/3.jpg">
								</div>
								<div class="card-title margin-top-20">
									<span> {!! trans('custom.home-s3') !!} </span>
								</div>
								<!--<div class="card-desc">
									<span> The best way to find yourself is
										<br> to lose yourself in the service of others </span>
								</div>-->
							</div>
						</div>
						
					</div>
					<!-- END CARDS -->
					
					<div class="row">
		  <div class="faq-page faq-content-1">
                            <div class="faq-content-container">
							
                                <div class="col-md-12" style="background:#fff;">
									<h2 class="faq-title uppercase" style="margin-left: 40px;
    border-bottom: 2px solid #ff6400;color:#ff6400;
    padding: 20px;
    float: left;">Q & A</h2>
									<div class="clearfix"></div>
                                    <div class="col-md-6">
                                        <div class="faq-section ">
                                            
                                            <div class="panel-group accordion faq-content" id="accordion1">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <i class="fa fa-circle"></i>
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1"> {!! trans('custom.home-q1') !!}
</a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_1" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p> {!! trans('custom.home-a1') !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <i class="fa fa-circle"></i>
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2"> {!! trans('custom.home-q2') !!}</a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_2" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p> {!! trans('custom.home-a2') !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <i class="fa fa-circle"></i>
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3"> {!! trans('custom.home-q3') !!}</a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p> {!! trans('custom.home-a3') !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
										</div> <div class="col-md-6">
                                        <div class="faq-section ">
                                            
                                            <div class="panel-group accordion faq-content" id="accordion3">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <i class="fa fa-circle"></i>
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> {!! trans('custom.home-q4') !!}</a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_1" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p> {!! trans('custom.home-a4') !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <i class="fa fa-circle"></i>
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2"> {!! trans('custom.home-q5') !!}</a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_2" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p>{!! trans('custom.home-a5') !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <i class="fa fa-circle"></i>
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3">{!! trans('custom.home-q6') !!}</a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_3" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p> {!! trans('custom.home-a6') !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
		  </div>
					
							
                        
                    </div>
					
					
                    <!-- END CONTENT BODY -->
				</div>
                <!-- END CONTENT -->
				
							
				 
                
          </div>
		  
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> © Copyright 2018   |   Claim The Gift   |   All Rights Reserved<BR>
Email: marketing@claimthegift.com<BR>
<a href="https://www.facebook.com/Claimthegift-944899235710664/" class="socicon-btn socicon-btn-circle socicon-solid bg-blue font-white bg-hover-grey-salsa socicon-facebook tooltips" data-original-title="Facebook" target="_blank"></a>
<a href="mailto:marketing@claimthegift.com" class="socicon-btn socicon-btn-circle socicon-solid bg-green font-white bg-hover-grey-salsa socicon-mail tooltips" data-original-title="Mail"></a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
		
		<script type="text/template" id="modal-template">
		  <div class="modal centered-modal" id="dynamicallyInjectedModal" tabindex="-1" role="dialog" aria-labelledby="modal-title">
			<div class="modal-dialog modal-vertical-centered" role="document" style="width:<%= width %>;height:<%= height %>;">
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  
				</div>
				<div class="modal-body">
				  <div id="iframe-loading" class="text-muted small" style="display:none; text-align:center;"><img src="/assets/pages/img/loading.gif"></div>
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
  page_id="944899235710664">
</div>
    </body>

</html>