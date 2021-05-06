<?php

namespace App\Http\Controllers;
use \DrewM\MailChimp\MailChimp;
use Illuminate\Http\Request;
use App\Models\RsgRequest;
use App\Models\RsgProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
		$date = $this->getDefaultDate(date('Y-m-d'));
		$user = isset($_GET['user']) ? $_GET['user'] : '';
		$user = explode('V',$user);
		$userid = isset($user[1]) && $user[1] ? $user[1] : 0;
		$pageid = isset(getPageidByUserid()[$userid]) ? getPageidByUserid()[$userid] : getPageidByUserid()[0];
		session()->put('pageid',$pageid);

		$customer_email = $request->route('customer_email');
		if(session()->get('customer_email')){
			$customer_email = session()->get('customer_email');
		}else{
			$validator = Validator::make(array('customer_email'=>$customer_email), array('customer_email'=>array('email')));
			if ($validator->passes()) session()->put('customer_email',$customer_email);
		}


		$lang_arr=array(
			'en'=>'www.amazon.com',
			'gb'=>'www.amazon.co.uk',
			'de'=>'www.amazon.de',
			'fr'=>'www.amazon.fr',
			'it'=>'www.amazon.it',
			'es'=>'www.amazon.es',
			'jp'=>'www.amazon.co.jp',
		);
		$from = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';

		$site = array_get($lang_arr,strtolower(App::getLocale()??'en'),'www.amazon.com');

		$where_product = " and site = '".$site."' and created_at = '".$date."' and cast(rsg_products.sales_target_reviews as signed) - cast(rsg_products.requested_review as signed) > 0 and product_img !='' and order_status!=-1";
		$orderby = " order by rsg_products.order_status desc,score desc,id desc ";
//		if($site=='www.amazon.com'){产品的展示去掉价格小于100的限制，
//			$where_product .= ' and price < 100 ';
// 		}
        //B08P4MBK17,B08Z7FYB59,B08RZ3GSKH这3个ASIN 在RSG官网屏蔽到4月20日,4月20号也不显示
        $where_product .= " and asin not IN('B08Z75G16X')";

		$limit = 20;//默认显示20条数据
		if($site=='www.amazon.co.jp'){//日本站点限制显示置顶产品
			$where_product .= ' and order_status = 1 ';
			$limit = 4;//日本站点最多显示4条数据
		}

		$sql = "
        SELECT rsg_products.id as id,(status_score*type_score*level_score*rating_score*review_score*days_score)  as score
            from rsg_products
            left join (
				select id,
					case post_status
						WHEN 1 then 1
						WHEN 2 then 2
						ELSE 0 END as status_score,
					case post_type
						WHEN 1 then 1*20
						WHEN 2 then 0.5*20
						ELSE 0 END as type_score,
				   	if(stock_days<60,0,1) as days_score,
					case sku_level
						WHEN 'S' then 1
						WHEN 'A' then 0.6
						WHEN 'B' then 0.2
						ELSE 0 END as level_score,
					case review_rating
						WHEN 5 then 1
						WHEN 4.9 then 1
						WHEN 4.8 then 2
						WHEN 4.7 then 4
						WHEN 4.6 then 2
						WHEN 4.5 then 1
						WHEN 4.4 then 1
						WHEN 4.3 then 3
						WHEN 4.2 then 5
						WHEN 4.1 then 4
						WHEN 0 then 1
						ELSE 0 END as rating_score,
					if(site='www.amazon.com',
						case
							WHEN number_of_reviews < 100 then 10
							WHEN number_of_reviews >= 100 and number_of_reviews < 400 then 7
							WHEN number_of_reviews >= 400 and number_of_reviews < 1000 then 4
							WHEN number_of_reviews >= 1000 and number_of_reviews < 4000 then 1
							WHEN number_of_reviews >= 4000 then 0
							END,
						case
							WHEN number_of_reviews < 40 then 10
							WHEN number_of_reviews >= 40 and number_of_reviews < 100 then 7
							WHEN number_of_reviews >= 100 and number_of_reviews < 400 then 4
							WHEN number_of_reviews >= 400 and number_of_reviews <= 1000 then 1
							WHEN number_of_reviews > 1000 then 0
							END
					)as review_score
				from rsg_products
				where created_at = '".$date."'
			) as rsg_score on rsg_score.id=rsg_products.id
			where 1 = 1 {$where_product}
			{$orderby} limit {$limit}";
		$_products = DB::select($sql);
		$ids = array();
		//取出前十条数据的id
		foreach($_products as $key=>$val){
			$ids[] = $val->id;
		}
		//在这前十条数据中随机选择8条数据展示
		$products = RsgProduct::whereIN('rsg_products.id',$ids)
			->join('asin', function ($join) {
				$join->on('rsg_products.asin', '=','asin.asin')->on('rsg_products.site', '=','asin.site')->on('rsg_products.sellersku','=','asin.sellersku');
			})->inRandomOrder()->take($limit)->select('asin.id as asin_id','rsg_products.*')->get()->toArray();

		foreach($products as $key=>$val){
			$products[$key]['task'] = $val['sales_target_reviews'] - $val['requested_review'];
			//剩余百分比的计算（task/sales_target_reviews）
			$products[$key]['percent'] = $val['sales_target_reviews']>0 ? intval($products[$key]['task']*100/$val['sales_target_reviews']) : '0';
		}
		return view('home',['customer_email'=>$customer_email,'products'=>$products,'from'=>$from,'user_id'=>$userid]);
    }

	public function getrsg(Request $request){
		$product_id = intval($request->input('product_id'));
		$agree = intval($request->input('agree'));
		$customer_email = $request->input('customer_email');
		$user_id = intval($request->input('user_id'));

		if($user_id) session()->put('user_id',$user_id);

		if(session()->get('customer_email')){
			$customer_email = session()->get('customer_email');
		}
		$request_id = $request->input('id');
		$v_v = compact('product_id','customer_email');
		$validator = Validator::make(array('customer_email'=>$customer_email), array('customer_email'=>array('email')));
		if ($validator->passes())
		{
			/*取消非CTG限制
			$is_ctg = DB::table('ctg')->where('email',$customer_email)->first();
			if(!$is_ctg){
				$v_v['step']='-4';
				return view('error',$v_v);
				die();
			}
			*/
			if(!(session()->get('customer_email'))) session()->put('customer_email',$customer_email);
			if($product_id==-1 && $customer_email){
				$product_id=0;
				echo "<script>parent.location.href='/".$customer_email."';</script>";
				die();
			}

			$review_url = $request->input('review_url');
			if($review_url && $request_id){

				$result = RsgRequest::where('id',$request_id)->where('customer_email',$customer_email)->where('step',7)
				->update(['step'=>8,'review_url'=>$review_url]);
//				if($result) self::mailchimp($customer_email,'RSG Check Review Url',[
//					'email_address' => $customer_email,
//					'status'        => 'subscribed',
//					'merge_fields' => ['REVIEWURL'=>$review_url],
//				]);

			}
			$amazon_order_id = $request->input('amazon_order_id');
			if($amazon_order_id && $request_id){
				$result =RsgRequest::where('id',$request_id)->where('customer_email',$customer_email)->where('step',5)
				->update(['step'=>6,'amazon_order_id'=>$amazon_order_id]);
//				if($result) self::mailchimp($customer_email,'RSG Check Purchase',[
//					'email_address' => $customer_email,
//					'status'        => 'subscribed',
//					'merge_fields' => ['ORDERID'=>$amazon_order_id],
//				]);
			}

			$customer_paypal_email = $request->input('customer_paypal_email');
			if($customer_paypal_email && $request_id){
				$result = RsgRequest::where('id',$request_id)->where('customer_email',$customer_email)->where('step',3)
				->update(['step'=>4,'customer_paypal_email'=>$customer_paypal_email]);
//				if($result) self::mailchimp($customer_email,'RSG Check Paypal',[
//					'email_address' => $customer_email,
//					'status'        => 'subscribed',
//					'merge_fields' => ['PAYPAL'=>$customer_paypal_email],
//				]);
			}


			if($product_id){
                $crmRsgStatusArr = getCrmRsgStatusArr();
                $rsgStatus = DB::select('SELECT rsg_status, rsg_status_explain from client_info join client on client.id = client_info.client_id and client_info.email = "'.$customer_email.'"');

                if($rsgStatus && $rsgStatus[0]->rsg_status == 1){
                    $msg = isset($crmRsgStatusArr[$rsgStatus[0]->rsg_status_explain]) ? $crmRsgStatusArr[$rsgStatus[0]->rsg_status_explain]['rsg'] : $rsgStatus[0]->rsg_status_explain;
                    $v_v['step']='0';
                    echo '<script>alert("'.$msg.'")</script>';
                    return view('submit', $v_v);
                    die();
                }
				//参与次数限制
				$exists = RsgRequest::where('customer_email',$customer_email)->first();
				if($exists){
					$v_v['step']='-2';
					return view('error',$v_v);
					die();
				}
				if(!$agree){
					$v_v['step']='-5';
					return view('submit',$v_v);
					die();
				}
				// $daily_remain = RsgProduct::where('id',$product_id)->where('daily_remain','>',0)->decrement('daily_remain');
				$res = RsgProduct::where('id',$product_id)->whereRaw('requested_review < sales_target_reviews')->increment('requested_review');//已请求的数量+1
				if($res){
					$is_ctg = DB::table('ctg')->where('email',$customer_email)->first();
					$insertData = array(
						'product_id'=>$product_id,
						'customer_paypal_email'=>NULL,
						'amazon_order_id'=>NULL,
						'review_url'=>NULL,
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s'),
						'step'=>($is_ctg)?3:1,
						'user_id' => session()->get('user_id'),
						'processor' => (session()->get('user_id'))??0,//添加请求数据的时候指定负责人为VOP系统的user_id
					);

					$data = RsgRequest::firstOrCreate(['customer_email'=>$customer_email], $insertData );
					$data = array_merge($data->toArray(),self::getProduct($product_id));
//					if($data) self::mailchimp($customer_email,'RSG Join',[
//						'email_address' => $customer_email,
//						'status'        => 'subscribed',
//						'merge_fields' => ['PROIMG'=>$data['product_img'],'PRONAME'=>$data['product_name'],'PROKEY'=>$data['keyword'],'PROPAGE'=>$data['page'],'PROPOS'=>$data['position']],
//					]);
//					if($data['step']==3) self::mailchimp($customer_email,'RSG Submit Paypal',[
//						'email_address' => $customer_email,
//						'status'        => 'subscribed',
//						'merge_fields' => ['PROIMG'=>$data['product_img'],'PRONAME'=>$data['product_name'],'PROKEY'=>$data['keyword'],'PROPAGE'=>$data['page'],'PROPOS'=>$data['position']],
//					]);
					return view(($data['step']==3)?'submit':'wait',$data); //等待申请审核
					die();
				}else{
					$v_v['step']='-3';
					return view('error',$v_v); //产品数据库操作异常 不可申请
					die();
				}

			}

			// 查看邮箱有无正在进行的任务
			$current_task = RsgRequest::where('customer_email',$customer_email)->first();
			if($current_task){
				if(in_array($current_task->step,array(1,2,4,6,8,9))){
					$data = array_merge($current_task->toArray(),self::getProduct($current_task->product_id));
					return view('wait',$data);
					die();
				}else{
					return view('submit',$current_task->toArray());
					die();
				}
			}
			$v_v['step']='-1';
			if(!$product_id){
				return view('error',$v_v); //无任务
				die();
			}

		}else{
			if($product_id){
				$v_v['step']='0';
			}else{
				$v_v['step']='-4';
			}
			return view('submit',$v_v); //提交邮箱
			die();
		}
    }

	public function getProduct($product_id){
		return RsgProduct::where('id',$product_id)->first(['product_name','product_img','keyword','position','page'])->toArray();
	}

	public function help(){
		return view('help');
	}

	public function notice(){
		return view('notice');
	}

//	public function mailchimp($customer_email,$tag,$args){
//		$MailChimp = new MailChimp('d013911df0560a3001215d16c7bc028a-us8');
//		//$MailChimp->verify_ssl=false;
//		$list_id = '6aaf7d9691';
//		$subscriber_hash = $MailChimp->subscriberHash($customer_email);
//		$MailChimp->put("lists/$list_id/members/$subscriber_hash", $args);
//		if (!$MailChimp->success()) {
//			die($MailChimp->getLastError());
//		}
//		$MailChimp->post("lists/$list_id/members/$subscriber_hash/tags", [
//			'tags'=>[
//			['name' => $tag,
//			'status' => 'active',]
//			]
//		]);
//		if (!$MailChimp->success()) {
//			die($MailChimp->getLastError());
//		}
//	}
}
