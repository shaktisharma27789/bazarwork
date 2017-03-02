<?php
//include 'DB.php';
include 'BLloadropdownImpl.php';

$bl = new BLloadropdownImpl();
//$db = new DB();
//$tblName = 'users';
if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){
    $type = $_REQUEST['type'];
    switch($type){
		
		
        case "loadState":
		$data_jason['State']=$bl->loadState();
		echo json_encode($data_jason);
		 break;
		
		
		case "loadCity":	
		   $state= $_POST['state'];	
		   $data_jason['City']=$bl->loadCity($state);
		   echo json_encode($data_jason);
		    break;
			
			case "loadRegion":	
		     $state= $_POST['state'];	
		     $city= $_POST['city'];	
		     $data_jason['Region']=$bl->loadRegion($state,$city);
		     echo json_encode($data_jason);
		     break;
			 
			 case "loadCategory":	
		     $data_jason['Category']=$bl->loadCategory();
		     echo json_encode($data_jason);
		     break;
			 
			 case "loadSubCategory":	
			 $category= $_POST['category'];
		     $data_jason['SubCategory']=$bl->loadSubCategory($category);
		     echo json_encode($data_jason);
		     break;
		
		
		
		
		
		   //$records = $db->getRows('t_cities');
           // if($records){
              
			  
               /*  $empRec=(array_values($records));
            
                ?>
                <table class="table" id="example3" >
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  
                  </tr>
                </thead>
                <tbody>
                    	 <?php
			 
			foreach($empRec as $arrayValue)
{       
   
   ?>
                    
                    
                  <tr class="odd gradeX">
                    <td><?php echo $arrayValue['name']; ?></td>
                    <td><?php echo $arrayValue['email']; ?></td>
                    <td>
                      <?php if($arrayValue['active']==1){   ?>
                       <button type="button" id="<?php echo $arrayValue['wid']; ?>" onclick="activeInActive(<?php echo $arrayValue['wid']; ?>,<?php echo $arrayValue['active']; ?>);" class="btn btn-danger btn-cons">
                        Deactivate
                        </button>
                        <?php
                      }
                        else{
                        
                         ?>    
                            <button type="button" id="<?php echo $arrayValue['wid']; ?>" onclick="activeInActive(<?php echo $arrayValue['wid']; ?>,<?php echo $arrayValue['active']; ?>);" class="btn btn-primary btn-cons">
                        Activate
                        </button>
                    <?php  }?>
                       
                    </td>
                   
                  </tr>
                 <?php
   
   
			}
?>     
                </tbody>
              </table>
          <?php  }else{
                Echo "No  Record Found";
           }*/
            ?>
               <?php
            break;
            
            
              case "cusdetail":
			  
			   
			   $condition = array('where' => array('wid'=> 0));
			   
            $records = $db->getRows('t_cus',$condition);
            if($records){
               // print_r($records); 
                 $cusRec=(array_values($records));
              //   print_r($empRec);
                ?>
				 <div class="table-responsive"> 
                <table class="table" id="tablecustomer" >
                <thead>
                  <tr>
                    <th width="" >Name</th>
                    <th>Account No</th>
                    <th>Branch</th>
                    <th>Bank</th>
                    <th>Address</th>
                    <th>Aadhr No</th>
                     <th>PanNo</th>
                    <th>Mob No</th>
                    
                  </tr>
                </thead>
                <tbody>
                    	 <?php
			 
			foreach($cusRec as $arrayValue)
{       
   
   ?>
                    
                    
                  <tr class="odd gradeX">
                    <td><?php echo $arrayValue['cuntomername']; ?></td>
                    <td><?php echo $arrayValue['accountno']; ?></td>
                    <td><?php echo $arrayValue['branch']; ?></td>
                    <td><?php echo $arrayValue['bank']; ?></td>
                    <td><?php echo $arrayValue['address']; ?></td>
                    <td><?php echo $arrayValue['aadharno']; ?></td>
                    <td><?php echo $arrayValue['panno']; ?></td>
                    <td><?php echo $arrayValue['mobno']; ?></td>
                    
                   
                  </tr>
                 <?php
   
   
}
?>     
                </tbody>
              </table>
			  </div>
          <?php  }else{
                Echo "No  Record Found";
            }
            ?>
               <?php
            break;
            
        case "add":
            if(!empty($_POST['ename'])){
                $ename= $_POST['ename'];
                $epass= $_POST['epass'];
                 $email= $_POST['email'];
                
                $userData = array(
                    'name' => $_POST['ename'],
                    'password' => $_POST['epass'],
                    'email' => $_POST['email'],
                    
                );
			
               
                $tblName = 't_field_worker_detail';
                
                
		  $chekEmailExist = $db->getProfileInformation($tblName,$email,'email');
                  
                    if($chekEmailExist){
                        echo "Employee Already Registered";
                    }
            else {
     $insert = $db->insert($tblName,$userData);
			
                if($insert){
                   
                    echo  'Employee  has been added successfully.';
                }else{
                  
                     echo 'Some problem occurred, please try again.';
                }
 }
                
                
            }else{
               
                 echo'Some problem occurred, please try again.';
            }
                
            
            //echo json_encode($data);
            break;
        case "edit":
            if(!empty($_POST['data'])){
                $userData = array(
                    'name' => $_POST['data']['name'],
                    'email' => $_POST['data']['email'],
                    'phone' => $_POST['data']['phone']
                );
                $condition = array('id' => $_POST['data']['id']);
                $update = $db->update($tblName,$userData,$condition);
                if($update){
                    $data['status'] = 'OK';
                    $data['msg'] = 'User data has been updated successfully.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Some problem occurred, please try again.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Some problem occurred, please try again.';
            }
            echo json_encode($data);
            break;
        case "delete":
            if(!empty($_POST['id'])){
                $condition = array('id' => $_POST['id']);
                $delete = $db->delete($tblName,$condition);
                if($delete){
                    $data['status'] = 'OK';
                    $data['msg'] = 'User data has been deleted successfully.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Some problem occurred, please try again.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Some problem occurred, please try again.';
            }
            echo json_encode($data);
            break;
            
            
            case"activeInactive":
                  if(!empty($_POST['wid'])){
                      $userData = array('active' => $_POST['active']);
                     $condition = array('wid' => $_POST['wid']);              
                     $update = $db->update('t_field_worker_detail',$userData,$condition);
                      
                //echo $_POST['active'];
                  }
                  echo json_encode("Testing");
            break;
			
             case "selecteddateRange":
                  $sDate= $_POST['start_date'];
                  $eDate= $_POST['end_date'];
                  $query= "SELECT emp.name, count(cus.wid) as count FROM t_field_worker_detail emp INNER JOIN t_cus cus ON cus.wid=emp.wid where cus.updatedOn BETWEEN '$sDate' and '$eDate' group by cus.wid";

           // $records = $db->getRows('t_field_worker_detail');
                 $records = $db->getSelectedDateRecords($query);
            if($records){
              
                $recCount=(array_values($records));
                ?>
                    
                <table class="table table-striped" id="example2" >
                    <thead>
                        <tr>
                            <th>Uploded By</th>
                            <th>Total</th>
                        </tr>
                    </thead>  
                    <tbody>
                 <?php
                foreach($recCount as $arrayValue)
                {?>
                    
                     
                        <tr class="odd gradeX">
                          <td><?php echo $arrayValue['name']; ?></td>
                            <td><?php echo $arrayValue['count']; ?></td>
                       </tr>                   
               <?php }
               
			   ?>     
                </tbody>
              </table>
          <?php  }else{
                Echo "No  Record Found";
            }
          break;
			
			
			
			
                 
				    case "selecteddateRangeUplodedRecords":
                    $sDate= $_POST['start_date'];
                    $eDate= $_POST['end_date'];
				   $branchname= $_POST['branchname'];
				   if($branchname==''){ 
    $query= "select *From t_cus  where wid >0 and updatedOn BETWEEN '$sDate' and '$eDate'";
				   }else{
  $query= "select *From t_cus  where wid >0 and updatedOn BETWEEN '$sDate' and '$eDate' and branch LIKE '$branchname%'" ;
		   
				   }
				  
                

				 
           // $records = $db->getRows('t_field_worker_detail');
                 $records = $db->getSelectedDateRecords($query);
				 if($records== "No Record Found"){
					  echo $records;
				 }
				 else{
					 
				
			
            if($records){
              
			 // print_r($records);
                $recCount=(array_values($records));
                ?>
                 <div class="table-responsive">   
                <table class="table table-striped" id="example2" >
                     <thead>
                  <tr>
                    <th width="" >Name</th>
                    <th>Account No</th>
                    <th>Branch</th>
                    <th>Bank</th>
                    <th>Address</th>
                    <th>Aadhr No</th>
					 <th>LinKED Acc No</th>
                     <th>PanNo</th>
                    <th>Mob No</th>
                    <th>Image</th>
                  </tr>
                </thead>  
                    <tbody>
                 <?php
                foreach($recCount as $arrayValue)
                {
					$path = substr($arrayValue['imagepath'], 3);
					?>
                    
                     
                        <tr class="odd gradeX">
                    <td><?php echo $arrayValue['cuntomername']; ?></td>
                    <td><?php echo $arrayValue['accountno']; ?></td>
                    <td><?php echo $arrayValue['branch']; ?></td>
                    <td><?php echo $arrayValue['bank']; ?></td>
                    <td><?php echo $arrayValue['address']; ?></td>
					 <td><?php echo $arrayValue['aadharno']; ?></td>
					 <td><?php echo $arrayValue['linkedaccountno']; ?></td>
                    <td><?php echo $arrayValue['panno']; ?></td>
                    <td><?php echo $arrayValue['mobno']; ?></td>
                    <td>	<img src=<?php echo $path; ?> width="35" height="35" /> 
				</td>
                   
                  </tr>                   
               <?php }?>
			    </tbody>
				</table>
				</div>
			   <?php
                // print_r($recCount);
        
            }
	}
            break;
			
			 case "totalcount":
                  
                  $query= "SELECT emp.name, count(cus.wid) as count FROM t_field_worker_detail emp INNER JOIN t_cus cus ON cus.wid=emp.wid group by cus.wid";

           // $records = $db->getRows('t_field_worker_detail');
                 $records = $db->getSelectedDateRecords($query);
            if($records){
              
                $recCount=(array_values($records));
                ?>
                    
                <table class="table table-striped" id="countTotal" >
                    <thead>
                        <tr>
                            <th>Uploded By</th>
                            <th>Total</th>
                        </tr>
                    </thead>  
                    <tbody>
                 <?php
                foreach($recCount as $arrayValue)
                {?>
                    
                     
                        <tr class="odd gradeX">
                          <td><?php echo $arrayValue['name']; ?></td>
                            <td><?php echo $arrayValue['count']; ?></td>
                       </tr>                   
               <?php }
                // print_r($recCount);
        
            }
            break;
			case "loginadmin":
				 if(!empty($_POST['email'])){
					 $email =$_POST['email'];
					 $password =$_POST['pass'];
					
					 $login = $db->loginAdmin("t_admin_login",$email,$password,"email","password");
					 
				   if($login){
					 
					   echo "OK";
					 
					}
					  else{
                   
					echo "ERR";
                    
                }
					 
				 }
		    else{
                
				echo "Some problem occurred, please try again";
                
            }
			 break;
            
        default:
            echo '{"status":"INVALID"}';
    }
}