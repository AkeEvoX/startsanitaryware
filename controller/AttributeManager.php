<?php
require_once("../lib/database.php");


class AttributeManager {

	protected $mysql;

	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial registermanager.";
		}
		catch(Exception $e)
		{
			die("initial attribute error : ". $e->getMessage());
		}
	}

	function __destruct(){
		$this->mysql->disconnect();
	}

	function getmenu($lang)
	{
		try{
			$sql = " select id,name,".$lang." as title,seq from attribute_master ";
			$sql .= " where name like 'menu.%' ";
			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			return "Cannot get attribute menu : ".$e->getMessage();
		}
	}

	function getItems($lang,$type)
	{
		try{
			$sql = " select id,name,".$lang." as title,seq from attribute_master ";
			$sql .= " where name like '".$type.".%' or name like '%nav.%' ";
			log_warning($sql);
			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			return "Cannot get attributes : ".$e->getMessage();
		}
	}

}

?>
