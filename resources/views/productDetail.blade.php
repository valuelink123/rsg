<!DOCTYPE html>

<html lang="en">
@include('common.layout')
<!-- END HEAD -->
<style>
    .product{
        background-color: #F0F0F0;
    }
    .product-right-price{
        color:#ff6400;
    }
    .page-container{
        background-color: #fff;
    }
    .page-content{
        min-height:300px !important;
    }
    .product{
        background-color: #fff;
    }
    /*.product-top img{*/
        /*width:480px;*/
        /*height:480px;*/
    /*}*/
    .content{
        border:1px solid #EEEEEE;
        margin-top:10px;
        /*margin-left: 159px;*/
    }
    /*.product .product-top .product-top-right{*/
        /*margin-left:20px;*/
    /*}*/
    .product-top .product-right-summary{
        font-size: 16px;
        font-weight: 400;
        color: #808a94;
    }
    .product-top .btn-product{
        margin-top: 10px;
    }
    .product-detail-son .descript{
        /*text-align: center;*/
        color: #ff6400;
        font-size: 20px;
    }
    .product-no{
        min-height:100px;
        text-align:center;
        font-size:36px;
        color: #ff6400;
    }
    .product-right-title{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }
    .product-detail-son ul{
        width:100% !important;
    }
    .product-top .product-right-price .price-price{
        font-size:18px;
    }
    .product-top .product-right-price .price-amount{
        font-size:24px;
    }
    .product-top .product-right-price .available-number{
        font-size:24px;
    }
    .product-top .product-right-price .available-avail{
        font-size:18px;
    }
    .product .product-right-title{
        font-size:24px;
    }

</style>
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

                {{--产品详情页内容--}}
                @if($data)
                <div class="product margin-bottom-20 col-md-12">
                    <div class="product-top col-md-offset-1 col-md-10">
                        <div class="product-top-left col-md-4 col-xs-12">
                        <img class="col-md-12 col-xs-12" src="{{$data['product_img']}}">
                        </div >
                        <div class="product-top-right col-md-7 ">
                            <div class="product-right-title col-xs-12">
                                <b>{{$data['product_name']}}</b>
                            </div>
                            <div class="product-right-price col-xs-12">
                                <div class="col-xs-6 col-md-3">
                                    <span class="price-price">Price:</span>
                                    <span class="price-amount">${{$data['price']}}</span>
                                </div>
                                <div class="col-xs-5 col-md-3">
                                    <span class="available-number">{{array_get($data,'task')}}</span>
                                    <span class="available-avail">  {!! trans('custom.home-Available') !!} </span>
                                </div>
                            </div>
                            <div class="product-right-button col-md-12">
                                @if (array_get($data,'task')>0)
                                    <form action="{{url(App::getLocale().'/getrsg')}}" method="post" target="modal-iframe">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{array_get($data,'id')}}">
                                        <input type="hidden" name="customer_email" value="{{$customer_email}}">
                                        <input type="hidden" name="user_id" value="{{$user_id}}">
                                        <button type="submit" class="btn btn-product btn-circle red col-xs-4  col-md-4  trigger-modal" role="button" data-width="50%" data-height="60%">{!! trans('custom.home-wantit') !!}</button>
                                    </form>
                                @else
                                    <span class="btn btn-circle default col-xs-4  col-md-4 ">{!! trans('custom.home-Comming') !!}</span>
                                @endif
                                <div class="clearfix margin-bottom-20"></div>
                            </div>
                            <hr>
                            <div class="product-right-summary">
								{!! $data['product_summary'] !!}
                            </div>
                        </div>

                    </div>

                    <div class="product-detail col-md-12" ></div>
                        <div class="col-md-12">
                            <hr style="color:#D8D8D8"/>
                        </div>

                        <div class="product-detail-son col-md-10">
                            {{--<div class="col-md-10 col-md-offset-2 descript">P R O D U C T  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D E S C R I P T I O N</div>--}}
                            <div class="col-md-11 col-md-offset-1 content">
                            <?php echo html_entity_decode($data['product_content'])?>
                            </div>


                        </div>
                    </div>

                @else
                    <div class="product-no">
                        <span>No Data</span>
                    </div>
                @endif

                @include('common.bottom')

            </div>
            </div>


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