<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/FaqManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");


$faq = new FaqManager();

$lang = "th"; 
if(isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
	$lang = $_SESSION["lang"];
}

$req_id = $_GET["id"];
$type = $_GET["type"];

	if($type=="list")
	{
		$item = $faq->getListItem($lang);
	}
	else if($type=="most")
	{
		$item = $faq->getmostview($lang);
	}
	else if($type=="recent")
	{
		$item = $faq->getrecentview($lang);
	}
	else {
		$item = $faq->getItem($req_id,$lang);
	}

$result = null;

while($row = $item->fetch_object()){
	$data = array("id"=>$row->id
	,"title"=>$row->title
	,"detail"=>$row->detail
	,"thumbnail"=>$row->thumbnail
	,"date"=>$row->update_date);
	$result[] = $data;
}

log_debug("get list faq ".$type."> " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>