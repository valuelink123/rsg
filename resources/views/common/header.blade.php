<div class="row margin-bottom-20 about-header">
    <!-- BEGIN PAGE TITLE-->
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 " >
        <div class="col-md-3 col-sm-2 col-xs-2 col-lg-1 " style="float:left;"><img class="logo" src="/assets/pages/img/logo.png"></div>
        <div class="col-md-9 col-sm-10 col-xs-10 col-lg-11 margin-top-30 top-menu" style="float:right;">
            <div class="col-xs-7 col-sm-3 col-md-3 col-lg-1" style="float:right;margin-bottom:5px;">
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

            <!-- <div class="col-md-4 col-sm-5 col-xs-12 col-lg-2" style="float:right;">
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

            </div> -->


            @if(session()->get('user_email'))
            <div class="col-xs-7 col-sm-3 col-md-2 col-lg-1" style="float:right;margin-bottom:5px;">
                <button class="btn btn-circle red btn-outline dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="float:right;width:100%">
                    My Account
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="#">My Account</a></li>
                    <li><a href="/rsg_logout">Log Out</a></li>
                </ul>

            </div>

            @else
            <div class="col-xs-7 col-sm-3 col-md-2 col-lg-1" style="float:right;margin-bottom:5px;">
                <form action="{{url(App::getLocale().'/rsg_signup')}}" method="post" target="modal-iframe">
                    {{ csrf_field() }}
                    <button type="submit" id="signup_button" class="btn btn-circle red btn-outline trigger-modal" role="button" data-width="50%" data-height="60%" style="float:right;width:100%">
                        Sign Up
                    </button>
                </form>
            </div>
            <div class="col-xs-7 col-sm-3 col-sm-offset-3 col-md-2 col-md-offset-5 col-lg-1 col-lg-offset-9" style="float:right;margin-bottom:5px;">
                <form action="{{url(App::getLocale().'/rsg_signin')}}" method="post" target="modal-iframe">
                    {{ csrf_field() }}
                    <button type="submit" id="signin_button" class="btn btn-circle red btn-outline trigger-modal" role="button" data-width="50%" data-height="60%" style="float:right;width:100%">
                        Sign In
                    </button>
                </form>
            </div>

            @endif


        </div>
    </div>

    <!-- END PAGE TITLE-->
</div>
