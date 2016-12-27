<?php
require_once($base_dir."/lib/database.php");

class GalleryManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial press manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function get_gallery($lang,$id){
		
		try{

			$sql = "select id,title_".$lang." as title ,thumbnail,image ";
			$sql .= ",( case when update_date is null then create_date else update_date end ) as data_date ";
			$sql .= "from gallery where active=1 and id='".$id."' order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Gallery : ".$e->getMessage();
		}
		
	}

	function get_list_gallery($lang,$id)
	{
			try{
			
			$sql = "select id,title_".$lang." as title ,thumbnail,image";
			$sql .= ",( case when update_date is null then create_date else update_date end ) as data_date ";
			$sql .= "from gallery where active=1 and album_id = ".$id." order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Gallery : ".$e->getMessage();
		}
	}
	
	function get_list_album($lang){
			try{
			
			$sql = "select id,title_".$lang." as title ,cover";
			$sql .= ",( case when update_date is null then create_date else update_date end ) as data_date ";
			$sql .= "from gallery_album where active=1 order by title_".$lang." ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Album : ".$e->getMessage();
		}
	}
	
}

?>