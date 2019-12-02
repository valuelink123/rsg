<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/*
	 * 得到默认的查询数据日期(产品相关数据)
	 * 因为VOP系统中addrsgtask脚本数据是早上7点更新，所以在凌晨到早上7点之间显示当天的数据的时候会显示空白
	 * 因此凌晨到七点半之间要显示的是昨天的数据
	 */
	public function getDefaultDate($todayDate)
	{
		if(time()-strtotime($todayDate.' 07:30:00') < 0){
			//凌晨到七点半之间要显示的是昨天的数据
			$todayDate = date('Y-m-d',strtotime($todayDate)-86400);
		}
		return $todayDate;
	}
}
