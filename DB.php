<?php
/*
 * DB Class
 * This class is used for database related (connect, get, insert, update, and delete) operations
 * with PHP Data Objects (PDO)
 * @author    ShaktiSharma

 */
class DB {
    // Database credentials
    private $dbHost     = 'localhost';
    private $dbUsername = 'root';
    private $dbPassword = 'root';
    private $dbName     = 'bazarlocater';
    public $db;
    /*
     * Connect to the database and return db connecction
     */
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            try{
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
            }catch(PDOException $e){
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }
    
    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
	  public function loginUser($tblName,$email,$password,$canname,$canpassword){
		 
		 
		 
		 $sql ='SELECT *from  '.$tblName.' where '.$canname.'= "'.$email.'" and '.$canpassword.'="'.$password.'"';
		 
		 $query = $this->db->prepare($sql);
         $query->execute();
		 $data = $query->fetch(PDO::FETCH_ASSOC);
		   
		if (!empty($data)) {
			 session_start();
			 
			 if($tblName == 't_candidate_reg'){
				  
					  $_SESSION["canemail"] = $data['canemail'];
					    $_SESSION["canid"] = $data['canid'];
					  $_SESSION["canpassword"] = $data['canpassword'];
					   return $data['canid'];
			 }
			 
			 else if($tblName == 't_company_reg'){
				
			       $_SESSION["comid"] = $data['comid'];
					$_SESSION["cname"] = $data['cname'];
					$_SESSION["password"] = $data['password'];
					 return $data['comid'];
			 }
		  
		  }
		 else{
			 return false;
		 }
		
	  }
	  
	  
	   public function forgotPassword($tblName,$email,$tablecolumn){
		 
		 $result="Email sent successfully";
		
		 $sql ='SELECT *from  '.$tblName.' where '.$tablecolumn.'= "'.$email.'"';
		  $query = $this->db->prepare($sql);
          $query->execute();
		  $data = $query->fetch(PDO::FETCH_ASSOC);
		   
		 if (!empty($data)) {
			  return $result;
		 }
		 else{
			 return false;
		 }
		 
	  }
	  
	  
	  public function getProfileInformation($tblName,$email,$coulumname){
	 $sql ='SELECT *from  '.$tblName.' where '.$coulumname.'= "'.$email.'"';
		
         $query = $this->db->prepare($sql);
          $query->execute();
		 $data = $query->fetch(PDO::FETCH_ASSOC);
		   
		if (!empty($data)) {
			
		 return $data;
		    
		 }
		else{
			
		 return false;
		 }
		
	  } 
	  
	  public function checkPaidCompany($tblName,$condition){
		 $sql ='SELECT *from  '.$tblName.' where  comid= '.$condition.'';
		
		//echo $sql;
         $query = $this->db->prepare($sql);
          $query->execute();
		 $data = $query->fetch(PDO::FETCH_ASSOC);
		   
		if (!empty($data)) {
			
		 return $data;
		    
		 }
		else{
			
		 return false;
		 }
		
	  } 
	  
	 
	 
    public function getRows($table,$conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;

        if(array_key_exists("where",$conditions)){
            
            
			
		  $sql .= ' WHERE ';
                  if(array_key_exists("like",$conditions)){
                 $i = 0;
                      foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." like '%".$value."%'";
                $i++;
            }
                
               // echo $sql;
            }
            
             else  {
                   $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
             }   
          
        }
			
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }
		
		if(array_key_exists("group by",$conditions)){
            $sql .= ' group by '.$conditions['group by']; 
        }
        
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
        }
        
	//echo $sql;
        $query = $this->db->prepare($sql);
        $query->execute();
        
		
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
		

        return !empty($data)?$data:false;
    }
    
    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
	 
    public function insert($table,$data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
//           if(!array_key_exists('createdOn',$data)){
//                $data['createdOn'] = date("Y-m-d H:i:s");
//            }
//            if(!array_key_exists('updatedOn',$data)){
//                $data['updatedOn'] = date("Y-m-d H:i:s");
//            }

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
             $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
			//echo $sql;
            $query = $this->db->prepare($sql);
            foreach($data as $key=>$val){
                $val = htmlspecialchars(strip_tags($val));
                $query->bindValue(':'.$key, $val);
            }
            $insert = $query->execute();
            if($insert){
                $data['id'] = $this->db->lastInsertId();
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
	
    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$conditions){
		
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            if(!array_key_exists('updatedOn',$data)){
                $data['updatedOn'] = date("Y-m-d H:i:s");
            }
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $val = htmlspecialchars(strip_tags($val));
                $colvalSet .= $pre.$key."='".$val."'";
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
				
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = ".$value."";
                    $i++;
                }
            }
		
			if(!empty($conditions) && is_array($conditions)){
				
				
				  $columnString = implode(',', array_keys($conditions));
            $valueString = ":".implode(',:', array_values($conditions));
				
		        
				
			}
          echo  $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
			//echo $sql;
            $query = $this->db->prepare($sql);
            $update = $query->execute();
            return $update?$query->rowCount():false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions){
        $whereSql = '';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        $sql = "DELETE FROM ".$table.$whereSql;
        $delete = $this->db->exec($sql);
        return $delete?$delete:false;
    }
	
	 public function getSelectedDateRecords ($sql){
             $data="No Record Found";
            // echo $sql;
             $query = $this->db->prepare($sql);
             $query->execute();
             if($query->rowCount() > 0){
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
             return $data;
         }
		 
		 public function loginAdmin($tblName,$email,$password,$canname,$canpassword){
		  $sql ='SELECT *from  '.$tblName.' where '.$canname.'= "'.$email.'" and '.$canpassword.'="'.$password.'"';
		 
		 $query = $this->db->prepare($sql);
         $query->execute();
		 $data = $query->fetch(PDO::FETCH_ASSOC);
		   
		if (!empty($data)) {
			 session_start();
			// print_r($data);
			  $_SESSION["email"] = $data['email'];
			  return $data['email'];
			 
			/* if($tblName == 't_candidate_reg'){
				  
					  $_SESSION["canemail"] = $data['canemail'];
					    $_SESSION["canid"] = $data['canid'];
					  $_SESSION["canpassword"] = $data['canpassword'];
					   return $data['canid'];
			 }
			 
			 else if($tblName == 't_company_reg'){
				
			       $_SESSION["comid"] = $data['comid'];
					$_SESSION["cname"] = $data['cname'];
					$_SESSION["password"] = $data['password'];
					 return $data['comid'];
			 }*/
		  
		  }
		 else{
			 return false;
		 }
		
	  }
}
