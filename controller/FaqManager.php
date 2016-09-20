<?php
include("../lib/database.php");
//include("../../../controller/logger.php");

class FaqManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial Faq manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){
		
		try{

			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 and id='".$id."' order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Faq : ".$e->getMessage();
		}
		
	}

	function getListItem($lang)
	{
		try{
			
			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Faq : ".$e->getMessage();
		}
	}
	
	function getmostview($lang)
	{
		try{
			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 order by view desc limit 3 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List MostView : ".$e->getMessage();
		}
	}
	
	function getrecentview($lang)
	{
		try{
			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail ,thumbnail,coverpage,update_date ";
			$sql .= "from faq where active=1 order by update_date desc limit 3 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List RecentView : ".$e->getMessage();
		}
	}
	
}

?>