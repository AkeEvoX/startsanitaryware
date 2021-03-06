<?php
require_once($base_dir."/lib/database.php");

class PressManager{
	
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

	function getItem($id,$lang){
		
		try{

			$sql = "select id,title_".$lang." as title ,detail_".$lang." as detail,thumbnail,coverpage,create_date,update_date ";
			$sql .= "from press where active=1 and id='".$id."' order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Press : ".$e->getMessage();
		}
		
	}

	function getListItem($lang)
	{
		try{
			
			$sql = "select id,title_".$lang." as title , LEFT(detail_".$lang.", 100) as detail  ,thumbnail,coverpage,create_date,update_date ";
			$sql .= "from press where active=1 order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Press : ".$e->getMessage();
		}
	}
	
	function getSlideItem($lang){
		try{
			
			$sql = "select id,title_".$lang." as title,thumbnail,create_date,update_date ";
			$sql .= "from press where active=1 order by create_date desc limit 5 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Slide Press : ".$e->getMessage();
		}	
	}
	
	function getHomeItem($lang){
		try{
			
			$sql = "select id,title_".$lang." as title,LEFT(detail_".$lang.", 100) as detail,thumbnail,coverpage,create_date,update_date ";
			$sql .= "from press where active=1 order by update_date desc limit 4 ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Home Press : ".$e->getMessage();
		}	
	}
	
	
	function get_fetch_list($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from press a ";
			$sql .= " order by id desc " ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("Press > get_fetch_list > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list press  : ".$e->getMessage();
		}
	}
	
	function get_press_info($id){
		try{

			$sql = "select * ";
			$sql .= " from press where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Press info: ".$e->getMessage();
		}
	}
	
	function insert_item($items){
		
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$detail_th =$items["detail_th"];
			$detail_en =$items["detail_en"];
			$coverpage = $items["coverpage"];
			$thumbnail = $items["thumbnail"];
			

			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by=$_SESSION["profile"]->id;
			$create_date='now()';
			
			$sql = "insert into press (title_th ,title_en  ,detail_th ,detail_en  ,coverpage,thumbnail   ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th'  ,'$title_en'  ,'$detail_th' ,'$detail_en' ,'$coverpage' , '$thumbnail'  ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("Press > insert  > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Press : ".$e->getMessage();
		}
		
	}
	
	function update_item($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$detail_th =$items["detail_th"];
			$detail_en =$items["detail_en"];
			$coverpage = $items["coverpage"];
			$thumbnail = $items["thumbnail"];
			
			if($items["coverpage"]){
				$coverpage=",coverpage='".$items["coverpage"]."' ";	
			}
			
			if($items["thumbnail"]){
				$thumbnail=",thumbnail='".$items["thumbnail"]."' ";	
			}
		
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by=$_SESSION["profile"]->id;
			$update_date='now()';
			//title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date
			
			$sql = "update press set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,detail_th='$detail_th' ,detail_en='$detail_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= $coverpage. " " . $thumbnail;
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("Press > update > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Press  Project : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		
		try{
			$sql = "delete from press where id=$id ; ";
			log_debug("Press > delete > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Press : ".$e->getMessage();
		}
	}
	
	
	
}

?>