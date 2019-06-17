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

		$date=date('Y-m-d');
		$prodcuts = $un_produsts = [];
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
		
		$site = array_get($lang_arr,strtolower(App::getLocale()??'en'),'www.amazon.com');

		$produsts = RsgProduct::where('status',1)->where('daily_remain','>',0)->where('site',$site)->where('start_date','<=',$date)->where('end_date','>=',$date)->inRandomOrder()->take(8)->get()->toArray();
		$count = count($produsts);
		if($count<8){
			$un_produsts = RsgProduct::where('status',1)->where('site',$site)->where('daily_remain','<=',0)->where('start_date','<=',$date)->where('end_date','>=',$date)->inRandomOrder()->take(8-$count)->get()->toArray();
		}
		return view('home',['customer_email'=>$customer_email,'products'=>array_merge($produsts,$un_produsts)]);
    }
	
	public function getrsg(Request $request){
		$product_id = intval($request->input('product_id'));
		$agree = intval($request->input('agree'));
		$customer_email = $request->input('customer_email');
		
		if(session()->get('customer_email')){
			$customer_email = session()->get('customer_email');
		}
		$request_id = $request->input('id');
		$v_v = compact('product_id','customer_email');	
		$validator = Validator::make(array('customer_email'=>$customer_email), array('customer_email'=>array('email')));
		if ($validator->passes())
		{
			$is_ctg = DB::table('ctg')->where('email',$customer_email)->first();
			if(!$is_ctg){
				$v_v['step']='-4';
				return view('error',$v_v);
				die();
			}
			
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
				if($result) self::mailchimp($customer_email,'RSG Check Review Url',[
					'email_address' => $customer_email,
					'status'        => 'subscribed',
					'merge_fields' => ['REVIEWURL'=>$review_url],
				]);
				
			}
			$amazon_order_id = $request->input('amazon_order_id');
			if($amazon_order_id && $request_id){
				$result =RsgRequest::where('id',$request_id)->where('customer_email',$customer_email)->where('step',5)
				->update(['step'=>6,'amazon_order_id'=>$amazon_order_id]);
				if($result) self::mailchimp($customer_email,'RSG Check Purchase',[
					'email_address' => $customer_email,
					'status'        => 'subscribed',
					'merge_fields' => ['ORDERID'=>$amazon_order_id],
				]);
			}
			
			$customer_paypal_email = $request->input('customer_paypal_email');
			if($customer_paypal_email && $request_id){
				$result = RsgRequest::where('id',$request_id)->where('customer_email',$customer_email)->where('step',3)
				->update(['step'=>4,'customer_paypal_email'=>$customer_paypal_email]);
				if($result) self::mailchimp($customer_email,'RSG Check Paypal',[
					'email_address' => $customer_email,
					'status'        => 'subscribed',
					'merge_fields' => ['PAYPAL'=>$customer_paypal_email],
				]);
			}
			
			
			if($product_id){
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
				$daily_remain = RsgProduct::where('id',$product_id)->where('daily_remain','>',0)->decrement('daily_remain');
				if($daily_remain){
					//$is_ctg = DB::table('ctg')->where('email',$customer_email)->first();
					$insertData = array(
						'product_id'=>$product_id,
						'customer_paypal_email'=>NULL,
						'amazon_order_id'=>NULL,
						'review_url'=>NULL,
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s'),
						'step'=>($is_ctg)?3:1,
					);
					
					$data = RsgRequest::firstOrCreate(['customer_email'=>$customer_email], $insertData );
					$data = array_merge($data->toArray(),self::getProduct($product_id));
					if($data) self::mailchimp($customer_email,'RSG Join',[
						'email_address' => $customer_email,
						'status'        => 'subscribed',
						'merge_fields' => ['PROIMG'=>$data['product_img'],'PRONAME'=>$data['product_name'],'PROKEY'=>$data['keyword'],'PROPAGE'=>$data['page'],'PROPOS'=>$data['position']],
					]);
					if($data['step']==3) self::mailchimp($customer_email,'RSG Submit Paypal',[
						'email_address' => $customer_email,
						'status'        => 'subscribed',
						'merge_fields' => ['PROIMG'=>$data['product_img'],'PRONAME'=>$data['product_name'],'PROKEY'=>$data['keyword'],'PROPAGE'=>$data['page'],'PROPOS'=>$data['position']],
					]);
					return view(($data['step']==3)?'submit':'wait',$data); //等待申请审核
					die();
				}else{
					$v_v['step']='-3';
					return view('error',$v_v); //产品无库存 不可申请
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
	
	public function mailchimp($customer_email,$tag,$args){
		$MailChimp = new MailChimp('d013911df0560a3001215d16c7bc028a-us8');
		//$MailChimp->verify_ssl=false;
		$list_id = '6aaf7d9691';
		$subscriber_hash = $MailChimp->subscriberHash($customer_email);	
		$MailChimp->put("lists/$list_id/members/$subscriber_hash", $args);
		if (!$MailChimp->success()) {
			die($MailChimp->getLastError());
		}
		$MailChimp->post("lists/$list_id/members/$subscriber_hash/tags", [
			'tags'=>[
			['name' => $tag,
			'status' => 'active',]
			]
		]);
		if (!$MailChimp->success()) {
			die($MailChimp->getLastError());
		}
	}
}