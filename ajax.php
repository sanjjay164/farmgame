<?php
error_reporting(E_ALL);
ini_set("display_errors", "1");
require_once("functions.php");//includes common functions and constants
?>
<?php

if(isset($_GET) && isset($_GET['function']))
{
	$function_name = $_GET['function'];
	$data = [];

	function play()
	{
		global $farm_data,$data;
		session_start();

		$data['rendered'] = array();
		$data['total_turn_left'] = TOTAL_TURNS;
		$data['data'] = $farm_data;
		//foreach member a unique key is created
		foreach ($data['data'] as $key => $datarow)
		{
			foreach (range(1,$datarow['no_of_members']) as $no_of_member)
			{
				$data['rendered'][$key.'-'.$no_of_member]['turns_left'] = $datarow['die_after'];
			}
			$data['aliveKeys'][$key.'-'.$no_of_member] = $key.'-'.$no_of_member;

		}
		//data is stored in session from second chance
		if(isset($_SESSION) && count($_SESSION))
		{
			$data = $_SESSION;
		}

		$response = ['s'=>'0'];
		if($data['total_turn_left'] <1)
		{
			echo json_success('Game Finished. Turns Completed',[],"2");
			return;
		}

		$data['total_turn_left'] = $data['total_turn_left'] - 1;

		$response_data = $data;
		$random_key = getRandomMember();
		$msg = $random_key .' is fed';
		$counter = ["BUNNIES"=>0,"COWS"=>0,"FARMER"=>0,];
		
		foreach ($response_data['rendered'] as $data_key => $data_row)
		{
			$data_parent = explode("-",$data_key);
			if($random_key==$data_key)
			{
				$response_data['rendered'][$random_key]['turns_left'] = $response_data['data'][$data_parent[0]]['die_after'];
				$response_data['feed_member'] = $data_key;
			}
			elseif($response_data['rendered'][$data_key]['turns_left']>0)
			{
				$response_data['rendered'][$data_key]['turns_left'] = $response_data['rendered'][$data_key]['turns_left']-1;	
			}
			if($response_data['rendered'][$data_key]['turns_left']<1)
			{
				$response_data['rendered'][$data_key]['is_dead'] = true;
				$response_data['member_killed'][] = $data_key;

				$counter[$data_parent[0]] = $counter[$data_parent[0]]+1;
				$response_data["killed"] = $counter;

				unset($data['aliveKeys'][$data_key]);
			}
		}
		if($response_data['rendered']['FARMER-1']['turns_left']<1)
		{
			$msg .= ' but Farmer Died.. you lost the game';
			echo json_success($msg,['game_over'=>"1"]);
			return;
		}

		if(isset($response_data['killed']['BUNNIES']) && $response_data['killed']['BUNNIES'] >= TOTAL_BUNNY)
		{
			echo json_success('All Bunnies Died.. you lost the game',['game_over'=>"1"]);
			return;
		}

		if(isset($response_data['killed']['COWS']) && $response_data['killed']['COWS'] >= TOTAL_COWS)
		{
			echo json_success('All cows Died.. you lost the game',['game_over'=>"1"]);
			return;
		}

		if(!count($data['aliveKeys']))
		{
			$msg .= ' All Died.. you lost the game';
			echo json_success($msg,['game_over'=>"1"]);
			return;
		}
		$response_data['aliveKeys'] = $data['aliveKeys']; 
		$_SESSION = $response_data;
		$response['d'] = $response_data;
		$response['s'] = 1;
		echo json_success("",$response['d']);
		return;
	}

	function getRandomMember()
	{
		global $data;
		$allKeys= array_keys($data['rendered']);
		do{
			//unset($allKeys[$random_key]);
			$random_key = array_rand($data['rendered']);
		}
		while($data['rendered'][$random_key]['turns_left']<1);
		return $random_key;
	}

	if(!function_exists($function_name))
	{
		die;
	}
	$function_name();
}
?>