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
		$data = RsgProduct::where('id',$id)->take(1)->get()->toArray();
		if($data){
			$data = $data[0];
			$data['product_content'] = htmlspecialchars($data['product_content']);
			$data['product_summary'] = nl2br($data['product_summary']);
			$data['price'] = ltrim($data['price'],0);
		}

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
		$from = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';

		$site = array_get($lang_arr,strtolower(App::getLocale()??'en'),'www.amazon.com');

		return view('productDetail',['data'=>$data,'customer_email'=>$customer_email,'from'=>$from]);
	}


}