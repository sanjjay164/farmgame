<?php
define("TOTAL_FARMER",1);
define("TOTAL_COWS",2);
define("TOTAL_BUNNY",4);
define("FARMER_DIE_AFTER",15);
define("COWS_DIE_AFTER",10);
define("BUNNY_DIE_AFTER",8);
define("TOTAL_TURNS",50);
define("WIN_REQ_COW",1);
define("WIN_REQ_BUNNY",1);

$farm_data = [
					"FARMER"=>[
								"die_after"=>FARMER_DIE_AFTER,
								"turns_left"=>FARMER_DIE_AFTER,
								"no_of_members"=>TOTAL_FARMER,
								"died"=>0,
								"members"=>range(1,TOTAL_FARMER),
								'member_details'=>array()
					],
					"COWS"=>[
								"die_after"=>COWS_DIE_AFTER,
								"turns_left"=>COWS_DIE_AFTER,
								"no_of_members"=>TOTAL_COWS,
								"died"=>0,
								"members"=>range(1,TOTAL_COWS),
								'member_details'=>array()
					],
					"BUNNIES"=>[
								"die_after"=>BUNNY_DIE_AFTER,
								"turns_left"=>BUNNY_DIE_AFTER,
								"no_of_members"=>TOTAL_BUNNY,
								"died"=>0,
								"members"=>range(1,TOTAL_BUNNY),
								'member_details'=>array()
					]
				];

function base_url()
{
	$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
	$base_url .= "://".$_SERVER['HTTP_HOST'];
	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']); 
	return $base_url;
}


function json_success($msg="",$data=[],$status="1")
{
	$response = [];
	$response['s']=$status;
	$response['d']=$data;
	$response['m']=$msg;
	return json_encode($response);
}

function json_error($msg="",$data=[])
{
	$response = [];
	$response['s']=0;
	$response['d']=$data;
	$response['m']=$msg;
	return json_encode($response);
}
?>