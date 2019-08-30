<div class="row margin-bottom-20 about-header">
    <!-- BEGIN PAGE TITLE-->
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 " >
        <div class="col-md-3 col-sm-2 col-xs-4 col-lg-1 " style="float:left;"><img class="logo" src="/assets/pages/img/logo.png"></div>
        <div class="col-md-8 col-sm-10 col-xs-8 col-lg-11 margin-top-30 top-menu" style="float:right;">


            <div class="col-md-3 col-sm-3 col-xs-8 col-lg-1" style="float:right;margin-bottom:10px;">
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

            <div class="col-md-4 col-sm-5 col-xs-12 col-lg-2" style="float:right;">
                <form action="{{url(App::getLocale().'/getrsg')}}" method="post" target="modal-iframe">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="0">
                    <input type="hidden" name="customer_email" value="{{$customer_email}}">
                    <button type="submit" class="btn btn-circle red btn-outline trigger-modal" role="button" data-width="50%" data-height="60%" style="float: right;">
                        @if($customer_email)
                            {!! trans('custom.home-myproduct') !!}
                        @else
                            {!! trans('custom.home-join') !!}
                        @endif
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- END PAGE TITLE-->
</div>