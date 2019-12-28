<?php
function getStepStatus(){
	return array(
		'1'  => 'Check Customer',
		'2'  => 'Request Reject',
		'3'  => 'Submit Paypal',
		'4'  => 'Check Paypal',
		'5'  => 'Submit Purchase',
		'6'  => 'Check Purchase',
		'7'  => 'Submit Review',
		'8'  => 'Check Review',
		'9'  => 'Completed'
	);
}

/*
 * 通过VOP系统的userid分配各自的Pageid
 * 默认值为944899235710664
 */
function getPageidByUserid(){
	return array(
		'0'=>'944899235710664',
		'27'  => '107381077272596',
	);
}