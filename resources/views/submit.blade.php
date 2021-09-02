<!DOCTYPE html>

<html lang="en">
    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-MLVCDBW');</script>
        <!-- End Google Tag Manager -->
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

    <body class=" page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MLVCDBW"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

		<div class="portlet light">
			<div class="portlet-body form">
				<form id ="rsgform" role="form" class="form-horizontal" role="form" method="post" action="{{url(App::getLocale().'/getrsg')}}">
				{{ csrf_field() }}
				<div class="form-body">
				@if ($step==7)
					<h4 class="block iframe_block_h4">{!! str_ireplace('{{$customer_email}}',$customer_email,trans('custom.submit-7')) !!}</h4>
                    <div class="form-group">
						<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">

							<input type="hidden" name="id" value="{{$id}}">
							<input type="hidden" name="customer_email" value="{{$customer_email}}">
							<input type="text" class="form-control" name="review_url" placeholder="" required><span class="help-block"> <a href="/{{App::getLocale()}}/help#review" target="_parent">{!! trans('custom.how-get') !!}?</a> </span>
						</div>
					</div>

				@elseif ($step==5)
					<h4 class="block iframe_block_h4 text-left">{!! str_ireplace('{{$customer_email}}',$customer_email,trans('custom.submit-5')) !!}</h4>
					<div class="form-group">

						<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">

							<input type="hidden" name="id" value="{{$id}}">
							<input type="hidden" name="customer_email" value="{{$customer_email}}">
							<input type="text" class="form-control " name="amazon_order_id" placeholder="" required><span class="help-block"><a href="/{{App::getLocale()}}/help#order"  target="_blank"> {!! trans('custom.how-get') !!}?</a> </span>
						</div>
					</div>
				@elseif ($step==3)
					<h4 class="block iframe_block_h4 text-left">{!! str_ireplace('customer_email',$customer_email,trans('custom.submit-3')) !!}</h4>
					<div class="form-group">
						<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">

							<input type="hidden" name="id" value="{{$id}}">
							<input type="hidden" name="customer_email" value="{{$customer_email}}">
							<input type="email" class="form-control " name="customer_paypal_email" placeholder="" required>
						</div>
					</div>
				@elseif ($step==-4)
					<h4 class="block iframe_block_h4">
{!! trans('custom.submit--4') !!}</h4>
					<div class="form-group">
						<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">
							<input type="hidden" name="product_id" value="-1">
							<input type="email" class="form-control " name="customer_email" placeholder="" value="{{$customer_email}}" required>
                            <input type="checkbox" style="margin-top: 10px" checked /> I accept the ClaimGiftsNow.com Terms and Policy. <a href="https://claimgiftsnow.com/privacy-statement" target="_blank">View detail</a>
						</div>
					</div>
				@elseif ($step==-5)
					{!! trans('custom.submit--5') !!}
					<div class="form-group">
						<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">
							<input type="hidden" name="product_id" value="{{$product_id}}">
							<input type="hidden" name="customer_email" value="{{$customer_email}}">
							<input type="hidden" name="agree" value="1">
						</div>
					</div>

				@else
					<h4 class="block iframe_block_h4">{!! trans('custom.submit-0') !!}</h4>
					<div class="form-group">

						<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">

							<input type="hidden" name="product_id" value="{{$product_id}}">
							<input type="email" class="form-control " name="customer_email" placeholder="" value="{{$customer_email}}" required>
                            <input type="checkbox" style="margin-top: 10px" checked /> I accept the ClaimGiftsNow.com Terms and Policy. <a href="https://claimgiftsnow.com/privacy-statement" target="_blank">View detail</a>
						</div>
					</div>
				@endif
				</div>
				@if ($step==-5)
				<div class="row">
					<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">

						<button type="button" class="btn btn-circle default pull-right" id="disagree">{!! trans('custom.submit-disagree') !!}</button>

						<button type="submit" class="btn btn-circle red pull-right" id="buttonCD" disabled="disabled">{!! trans('custom.submit-agree') !!}</button>

					</div>
				</div>
				<script>
					var second = 10;
					var time = setInterval(function(){
						$("#buttonCD").text('Agree'+((second>0)?'('+second+')':''));
						if(second>0){
							//$("#buttonCD").val("Agree ("+second+")");
							second--;
						}else{
							//$("#buttonCD").val("Agree");
							$("#buttonCD").removeAttr("disabled");
							clearInterval(time);
						}

					},1000);

				</script>
				@else
				<div class="row">
					<div class="col-md-8  col-md-offset-2 col-xs-8  col-xs-offset-2">

						<button type="submit" class="btn btn-circle red pull-right">{!! trans('custom.submit-button') !!}</button>

					</div>
				</div>
				@endif


				</form>
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
		<script>

			$(function() {
				$("#rsgform").submit(function(e){
				   var customer_email = $("input[name='customer_email']").val();
				   if(customer_email){
				   		$("input[name='customer_email']", parent.document).val(customer_email);
				   }
				});
				$("#disagree").click(function(e){
					$("iframe", parent.document).html("").attr("src", "");
					$(".modal-backdrop", parent.document).hide();
					$("#dynamicallyInjectedModal", parent.document).remove();
				});
			});
		</script>
    </body>

</html>
