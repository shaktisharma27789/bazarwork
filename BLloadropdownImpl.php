<?php
include 'DB.php';


class BLloadropdownImpl {
	
	function loadState()
   { 
      $db = new DB(); 
	  
	  /* $condition = array('where' => array('email' => $email,
                'password' => $password, 'active' => 1), 'select' => 'wid,name');*/
			$condition = array('select' => 'city_state' ,'group by'=>'city_state');
	  $records = $db->getRows('t_cities',$condition);
	  $empRec=(array_values($records));
	  if($records){
		   return $empRec;
	  }
	}   
	
	function loadCity($state){
		/*testing*/
		$db = new DB();
		$condition = array('where' => array('city_state' => $state),'select' => 'city_name');
	  $records = $db->getRows('t_cities',$condition);
	  if($records){
		   $city=(array_values($records)); 
		   return $city;
	  }
	}
	
	function loadRegion($state,$city){
		$db = new DB();
		$condition = array('where' => array('city_state' => $state,'city_name' => $city),'select' => 'region');
	    $records = $db->getRows('t_region',$condition);
	  if($records){
		   $region=(array_values($records)); 
		   return $region;
	  }
	}
	
	function loadCategory(){
      $db = new DB(); 
	  $condition = array('where' => array('active' => 1),'select' => 'categoryname');
	  $records = $db->getRows('t_category',$condition);
	  if($records){
		   $Category=(array_values($records)); 
		   return $Category;
	  }
	}   
	
	
	function loadSubCategory($category){
		$db = new DB();
		$condition = array('where' => array('categoryname' => $category,'active' => 1),'select' => 'subcategoryname');
	  $records = $db->getRows('t_subcategory',$condition);
	  if($records){
		   $SubCategory=(array_values($records)); 
		   return $SubCategory;
	  }
	}
	
	
	
	
}

?>