<!DOCTYPE html>

<html lang="en">
    @include('common.layout')
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
                        @include('common.header')
                        <!-- END CONTENT HEADER -->
                       
                        
                        <!-- BEGIN MEMBERS SUCCESS STORIES -->
                        <div class="row margin-bottom-20 stories-header" data-auto-height="true">
                            <div class="col-md-12">
                                {!! trans('custom.home-freeproduct') !!}
                            </div>
                        </div>
                        <div class="row margin-bottom-40 stories-cont">
						
							@foreach($products as $product)
                            <div class="col-lg-3 col-md-6">
                                <div class="portlet light">
                                    <a href="/product/detail?id={{$product['asin_id']}}&user=V{{$user_id}}" target="_blank">
                                    <div class="photo">
                                       <!--<a href="https://{{array_get($product,'site')}}/dp/{{array_get($product,'asin')}}?m={{array_get($product,'seller_id')}}" target="_blank">--> <img src="{{array_get($product,'product_img')}}" alt="" class="img-responsive" /><!--</a>-->
                                    </div>
                                    </a>
									<div class="progress-info">
                                        <div class="progress">
                                            <span style="width: {{array_get($product,'percent')}}%;" class="progress-bar progress-bar-success red-haze">
                                                <span class="sr-only">{{array_get($product,'percent')}}% {!! trans('custom.home-left') !!}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="title" >
                                        <span> {{array_get($product,'task')}} {!! trans('custom.home-AVAILABLE') !!} </span>
										
                                    </div>
									
                                    <div class="desc">
                                        <span><!--<a href="https://{{array_get($product,'site')}}/dp/{{array_get($product,'asin')}}?m={{array_get($product,'seller_id')}}" target="_blank">-->{{array_get($product,'product_name')}} <!--</a>--></span>
                                    </div>
									
									@if (array_get($product,'task')>0)
									<form action="{{url(App::getLocale().'/getrsg')}}" method="post" target="modal-iframe">
									{{ csrf_field() }}
									<input type="hidden" name="product_id" value="{{array_get($product,'id')}}">
									<input type="hidden" name="customer_email" value="{{$customer_email}}">
                                    <input type="hidden" name="user_id" value="{{$user_id}}">
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

                        @include('common.bottom')
                        
                    </div>
					
					
                    <!-- END CONTENT BODY -->
				</div>
                <!-- END CONTENT -->
				
							
				 
                
          </div>
		  
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            @include('common.footer')
            <!-- END FOOTER -->
        </div>

    </body>

</html>