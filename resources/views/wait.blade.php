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
		
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/assets/pages/css/about.min.css" rel="stylesheet" type="text/css" />
		<link href="/assets/pages/css/faq.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->
		<style>
			.mt-comments .mt-comment .mt-comment-img > img {
				border-radius: 5% !important;
				width: 100px;
			}
			.mt-comments .mt-comment .mt-comment-img{width: 100px;}
			.portlet{margin-bottom:0px;}
		</style>
    <body class=" page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
	
		<div class="portlet light">
			<div class="portlet-body form">
				<h4 class="block iframe_block_h4 text-left">
				@if ($step==4)
					{!! trans('custom.wait-4') !!}
				@elseif ($step==6)
					{!! trans('custom.wait-6') !!}
				@elseif ($step==8)
					{!! str_ireplace('product_name',$product_name,trans('custom.wait-8')) !!}
				@elseif ($step==9)
					{!! trans('custom.wait-9') !!}
					
				@else
					{!! trans('custom.wait-10') !!}
				@endif
				</h4>
				<div class="clearfix margin-bottom-20"></div>
				<div class="mt-comments">
                                                   
					<div class="mt-comment">
						<div class="mt-comment-img">
							<img src="{{$product_img}}"> </div>
						<div class="mt-comment-body">
							<div class="mt-comment-info">
								<span class="mt-comment-author">{{$customer_email}}</span>
								<span class="mt-comment-date">
								{{$created_at}}
								</span>
							</div>
							<div class="mt-comment-text">{{$product_name}}</div> 
							<div class="mt-comment-details">
								<span class="mt-comment-status mt-comment-status-rejected">{{array_get(getStepStatus(),$step)}}</span>
							</div>
							
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				
			</div>
		</div>
		


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
    </body>

</html>