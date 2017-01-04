<?php
require_once($base_dir."/lib/database.php");

class ProductManager{

	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial Product manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getProduct($lang,$id){

		try{

			$sql = "select p.id ,p.typeid ,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name,p.doc_link ,t.title_".$lang." as catename";
			$sql .= " from products p inner join product_detail d on p.id=d.proid ";
			$sql .= " inner join product_type t on p.typeid=t.id ";
			$sql .= " where p.id='".$id."' ;";
			
			log_warning("product > " . $sql);
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Item : ".$e->getMessage();
		}

	}

	function getImages($id) {
		try{

			$sql = "select id,proid,thumb,image ";
			$sql .= " from product_images  where active=1 and proid='".$id."' ";
			log_warning("product image > " . $sql);
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Images : ".$e->getMessage();
		}
	}

	function getProductList($lang,$cate) {
		try{

			$sql = " select p.id,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name,p.doc_link ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid ";
			$sql .= " where p.typeid='".$cate."' ";
			$sql .= " order by p.create_date desc ";
			//log_warning("product list > " . $sql);
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product List : ".$e->getMessage();
		}
	}
	
	function getProductTypeByID($id) {
		try{
			//get type serial condition top 1 asc
			$sql = " select id,parent,title_th,title_en,detail_th,detail_en,link,thumb";
			$sql .= " from product_type ";
			$sql .= " where active=1 and id='".$id."' ;";
			log_warning("getProductTypeByID > " . $sql);
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get ProductType By ID : ".$e->getMessage();
		}
	}

	function getProductType($lang,$id) {
		try{
			//get type serial condition top 1 asc
			$sql = " select id,title_".$lang." as title ,detail_".$lang." as detail,thumb, cover_".$lang." as cover ";
			$sql .= " from product_type ";
			$sql .= " where active=1 and id='".$id."' ;";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get ProductType : ".$e->getMessage();
		}
	}

	function getSeriesDefault($lang) {
		try{
			//get type serial condition top 1 asc
			$sql = " select id,title_".$lang." as title ,detail_".$lang." as detail,thumb,cover_".$lang." as cover ";
			$sql .= " from product_type ";
			$sql .= " where active=1 order by id asc limit 1;";
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Series List : ".$e->getMessage();
		}
	}
	
	function getSeriestList($lang,$id){
		try{
			//get type serial condition top 1 asc
			$sql = " select s.id ,s.title_".$lang." as title ,p.typeid ,p.thumb ,p.plan ,pd.code ,pd.name ";
			$sql .= " from series s ";
			$sql .= " inner join products p on s.pro_id=p.id ";
			$sql .= " inner join product_detail pd on p.id = pd.proid ";
			$sql .= " where s.active=1 and s.series_id='".$id."' order by pd.code ; ";
			
			log_debug($sql);
						
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Series List : ".$e->getMessage();
		}
	}

	function getShowRoomList($lang,$id){
		try{
			//get type serial condition top 1 asc
			$sql = " select s.id ,s.title_".$lang." as title ,p.typeid ,p.thumb ,p.plan ,pd.code ,pd.name ";
			$sql .= " from showroom s ";
			$sql .= " inner join products p on s.pro_id=p.id ";
			$sql .= " inner join product_detail pd on p.id = pd.proid ";
			$sql .= " where s.active=1 and s.room_id='".$id."' order by pd.code ; ";
			
			log_debug($sql);
						
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get ShowRoome List : ".$e->getMessage();
		}
	}
	
	function getProductReleated($lang,$cate) {
		try{

			$sql = "select p.id,p.title_".$lang." as title ,p.detail_".$lang." as detail,p.thumb,p.image,p.plan,d.code,d.name ";
			$sql .= " from products p inner join product_detail d on p.id=d.proid where p.typeid='".$cate."' ";
			$sql .= " order by  p.create_date desc limit 6 ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product List : ".$e->getMessage();
		}
	}

	function getAttributes($lang,$id) {
		try{

			$sql = " select p.id,p.".$lang." as title,a.".$lang." as label from product_attribute p ";
			$sql .= " left join attribute_master a on a.name=p.attribute ";
			$sql .= " where p.proid='".$id."' order by a.seq ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Attribute : ". $e->getMessage();
		}
	}
	
	function getColor($id){
		try{

			$sql = " select c.thumb from product_color p ";
			$sql .=  " left join color_master c on p.colorid = c.id ";
			$sql .= " where p.proid='".$id."' and c.active=1 ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Product Color : ". $e->getMessage();
		}
	}
	
	function getColorMaster($id){
		try{

			$sql = " select * from color_master  ";
			$sql .= " where id='".$id."' ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Color Master: ". $e->getMessage();
		}
	}

	function getMenu($lang)
	{
		try{

			$sql = " select a.id,a.parent,a.title_".$lang." as title,a.link ";
			$sql .= " from product_type a ";
			$sql .= " where a.active=1 ";
			$sql .= " order by a.id; ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Menu Product : ".$e->getMessage();
		}
		
	}
	
	function insert_product_type($items){
		try{
			$parent = $items["parent"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$link = $items["link"];
			$cover = $items["cover"];
			$active = "1";
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into product_type(parent,title_th,title_en,cover,active,link,create_by,create_date) ";
			$sql .= "values($parent,'$title_th','$title_en','$cover',$active,'$link',$create_by,$create_date); ";
			
			//echo $sql."<br/>";
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Product Type: ".$e->getMessage();
		}
	}
	function insert_color($items){
		try{
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$thumb = $items["thumb"];
			$active = "1";
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into color_master(title_th,title_en,thumb,active,create_by,create_date) ";
			$sql .= "values('$title_th','$title_en','$thumb',$active,$create_by,$create_date); ";
			
			log_debug($sql); 
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Color Master : ".$e->getMessage();
		}
	}
	
	function update_color($items){
		try{
			
			$id = $items["id"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			$thumb = "";
			
			if($items["thumb"]){
				$thumb = ",thumb='".$items["thumb"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by = "0";
			$update_date = "now()";
			
			$sql = "update color_master set  ";
			$sql .= "title_th='$title_th' ";
			$sql .= ",title_en='$title_en' ";
			$sql .= $thumb;
			$sql .= ",active=$active ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= "where id=$id ;";
			
			log_warning("update color master > " . $sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Update Color Master : ".$e->getMessage();
		}
	}
	
	function update_product_type($items){
		try{
			$id = $items["id"];
			$parent = $items["parent"];
			$title_th = $items["title_th"];
			$title_en = $items["title_en"];
			//$link = $items["link"];
			//$cover = $items["cover"];
			//$active = "1";
			$update_by = "0";
			$update_date = "now()";
			
			$sql = "update product_type set  ";
			$sql .= "parent=$parent ";
			$sql .= ",title_th='$title_th' ";
			$sql .= ",title_en='$title_en' ";
			//$sql .= ",cover='$cover' ";
			
			//$sql .= ",link='$link' ";
			//$sql .= ",active=$active ";
			$sql .= ",update_by=$update_by";
			$sql .= ",update_date='$update_date' ";
			$sql .= "where id=$id ;";
			
			//echo $sql."<br/>";
			log_warning("update_product_type > " . $sql);
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Update Product Type: ".$e->getMessage();
		}
	}
	
	function delete_color($id){
		try{

			$sql = "delete from color_master where id=$id ;";
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Color Master : ".$e->getMessage();
		}
	}
	
	function delete_product_type($id){
		try{
			/*flag delete 
			** can delete manual with your self. prevent data is lost
			*/
			//$sql = "delete from product_type where id=$id ;";
			$sql = "update product_type set active='0' where id=$id ;";
			
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Product Type: ".$e->getMessage();
		}
	}
	
	function get_fetch_category(){//$start_fetch,$max_fetch
		try{
			//$max_fetch = 10;

			$sql = " select * ";
			$sql .= " from product_type ";
			$sql .= " where active=1 ";
			$sql .= " order by id ";
			//$sql .= " LIMIT $start_fetch,$max_fetch ;";
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Category Product : ".$e->getMessage();
		}
	}

	function get_fetch_product($lang,$start_fetch,$max_fetch){
		try{
			//$max_fetch = 10;

			$sql = " select p.id,p.title_".$lang." as title,t.title_".$lang." category,p.thumb,p.create_date ";
			$sql .= " from products p ";
			$sql .= " inner join product_type t on t.id = p.typeid ";
			$sql .= " where t.parent not in ('2','3') ";
			$sql .= " order by p.id ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";

			log_debug($sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Fetch Product : ".$e->getMessage();
		}
	}
	
	function get_fetch_showroom($lang,$start_fetch,$max_fetch){
		try{

			$sql = " select p.id ,p.title_th ,p.title_en ,p.thumb ,p.cover,p.create_date  ";
			$sql .= " from product_type p ";
			$sql .= " where p.parent in ('3') ";
			$sql .= " order by p.id ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";

			log_debug($sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Fetch ShowRoom  : ".$e->getMessage();
		}
	}
	
	function get_fetch_color($lang,$start_fetch,$max_fetch){
		try{

			$sql = " select * from color_master  ";
			$sql .= " order by id ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";

			log_debug($sql);
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Fetch Color  : ".$e->getMessage();
		}
	}

	function search_fetch_product($lang,$search_text,$search_fillter,$start_fetch,$max_fetch){
		
		try{
			//$max_fetch = 10;

			$sql = " select proid,code,name,rough,systems,seat,comsumption,overflow,size,shape,faucet,type,outlet ";
			$sql .= " from search_product_".$lang."  ";
			$sql .= " where 1=1 ";
			$sql .= " and name like '%".$search_text."%' ";
			$sql .= " or code like '%".$search_text."%' ";
			$sql .= " or type like '%".$search_text."%' ";
			$sql .= " or systems like '%".$search_text."%' ";
			$sql .= " or size like '%".$search_text."%' ";
			$sql .= " order by name ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Search  Product  : ".$e->getMessage();
		}
	}
	
}

?>
