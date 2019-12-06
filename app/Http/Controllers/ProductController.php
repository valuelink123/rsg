<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RsgRequest;
use App\Models\RsgProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use DB;

class ProductController extends Controller
{
	public function __construct()
	{

	}

	public function detail(Request $request)
	{
		$id = intval($_REQUEST['id']);
		$date = $this->getDefaultDate(date('Y-m-d'));
		$user = isset($_GET['user']) ? $_GET['user'] : '';
		$user = explode('V',$user);
		$userid = isset($user[1]) && $user[1] ? $user[1] : 0;

		$data = RsgProduct::where('asin.id',$id)->where('created_at',$date)
			->join('asin', function ($join) {
				$join->on('rsg_products.asin', '=','asin.asin')->on('rsg_products.site', '=','asin.site')->on('rsg_products.sellersku','=','asin.sellersku');
			})->take(1)->select('asin.id as asin_id','rsg_products.*')->get()->toArray();

		if($data){
			$data = $data[0];
			$data['product_content'] = htmlspecialchars($data['product_content']);
			$data['product_summary'] = nl2br($data['product_summary']);
			$data['price'] = ltrim($data['price'],0);
			$data['task'] = $data['sales_target_reviews']-$data['requested_review'];
			$data['product_summary'] = json_decode(str_replace("'",'"',$data['product_summary']),TRUE);
			if($data['product_summary']){
				$data['product_summary'] = implode("<br/>",$data['product_summary']);
			}
		}

		$customer_email = $request->route('customer_email');
		if(session()->get('customer_email')){
			$customer_email = session()->get('customer_email');
		}else{
			$validator = Validator::make(array('customer_email'=>$customer_email), array('customer_email'=>array('email')));
			if ($validator->passes()) session()->put('customer_email',$customer_email);
		}

		$from = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';

		return view('productDetail',['data'=>$data,'customer_email'=>$customer_email,'from'=>$from,'user_id'=>$userid]);
	}


}