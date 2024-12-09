<?php
class payrollAdmin {
public $connection;

public function __construct(){
    $doc_path=$_SERVER["DOCUMENT_ROOT"];
    $file=$doc_path."/connection/payroll_conn.php";
    if(file_exists($file)){
        $dbpath=$doc_path."/lib/connection/payroll_conn.php";
    }else{

        $dbpath=$doc_path."/lib/connection/payroll_conn.php";
    }

include($dbpath);
$this->connection = new PDO('mysql:host=localhost;dbname='.$config['DBNAME'],$config['DBUSER'],$config['DBPASS'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
   function login($user,$pass){
        $sql = "select * from login_master where username ='".$user."' AND userpass='".$pass."'  ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row[0] = $stmt->fetch(PDO::FETCH_ASSOC);
        $row[1] = $stmt->rowCount();
        return $row;
    }
    function displayClient($cid)
    {
       $sql = "select * from mast_client WHERE mast_client_id='".$cid."'";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
	}
	function SearchEmployee($comp_id,$name)
    {
        $sql = "select DISTINCT * from employee WHERE comp_id='".$comp_id."' AND (first_name like '%$name%' OR  middle_name like '%$name%' OR last_name like '%$name%') ";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	function SearchEmployee3($comp_id,$name,$clientid)
    {
        $sql = "select DISTINCT * from employee WHERE comp_id='".$comp_id."' AND (first_name like '%$name%' OR  middle_name like '%$name%' OR last_name like '%$name%') AND client_id ='".$clientid."'";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	function showEployeedetails($id){
       $sql = "select * from employee WHERE emp_id='".$id."'";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
    }
    function showEployeeincome($id){
        $sql = "select * from `emp_income` WHERE emp_id='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function showEployeededuct($id){
        $sql = "select * from `emp_deduct` WHERE emp_id='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function showEployeeleave($id){
      $sql = "select * from `emp_leave` WHERE emp_id='".$id."'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row;
    }
    function showEployeeadnavcen($id){
      $sql = "select * from `emp_advnacen` WHERE emp_id='".$id."'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row;
    }
/*    function showClient1($comp_id,$user_id){
      $sql = "select * from mast_client where comp_id ='".$comp_id."' AND user_id='".$user_id."'  ORDER BY `mast_client_id` DESC";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
	}*/
	function showDesignation($comp_id){
      $sql = "select * from mast_desg where comp_id ='".$comp_id."' ORDER BY `mast_desg_id` DESC";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }
    function insertDesignation($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_desg`(mast_desg_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg='1';
        } else{
        $msg= '2';
        }
        return $msg;
    }
    
    function updateDesignation($id,$name,$comp_id,$user_id){
        $sql = "UPDATE mast_desg SET  `comp_id`='".$comp_id."',`user_id`='".$user_id."',mast_desg_name='".$name."' ,db_update=NOW() WHERE mast_desg_id='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    function displayDesignation($did){
        $sql = "SELECT * FROM mast_desg  WHERE mast_desg_id='".$did."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function showDepartment($comp_id){
        $sql = "select * from mast_dept where comp_id ='".$comp_id."' ORDER BY `mast_dept_name` DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function showQualification($comp_id){
        $sql = "select * from mast_qualif where comp_id ='".$comp_id."' ORDER BY `mast_qualif_name` ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function showBank($comp_id){
       $sql = "select * from mast_bank where comp_id ='".$comp_id."' ORDER BY `bank_name` ASC";
	   $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    function showLocation($comp_id){
        $sql = "select * from mast_location where comp_id ='".$comp_id."' ORDER BY `mast_location_id` DESC";
        $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    function showPayscalecode($comp_id){
       $sql = "select * from mast_paycode where comp_id ='".$comp_id."' ORDER BY `mast_paycode_id` DESC";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    function showIncomehead($comp_id){
       $sql = "select * from mast_income_heads where comp_id ='".$comp_id."' ORDER BY mast_income_heads_id ASC ";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    function showDeductionhead($comp_id){
       $sql = "select * from mast_deduct_heads where comp_id ='".$comp_id."' ORDER BY `mast_deduct_heads_id` ASC";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    function showLeavetype($comp_id){
       $sql = "select * from mast_leave_type where comp_id ='".$comp_id."' ORDER BY `mast_leave_type_id` DESC";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
   }
   function showAdvancetype($comp_id){
      $sql = "select * from mast_advance_type where comp_id ='".$comp_id."' ORDER BY `mast_advance_type_id` DESC";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
   }
   function showCalType($dbname){
      $sql = "select * from $dbname";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }
    function displayEmpincome($id){
       $sql = "SELECT * FROM `emp_income` WHERE emp_id='".$id."'  ORDER BY `emp_income_id` ASC";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    function displayIncomehead($id){
      $sql = "select * from mast_income_heads WHERE `mast_income_heads_id`='".$id."' ORDER BY mast_income_heads_id ASC ";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row;
    }
    public function getIncomeCalculationTypeByid($id){
	  $sql = "select name from caltype_income where id = '".$id."'";
	  $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row['name'];
	}
	function deleteEmpincome($id){
        $sql = "DELETE FROM emp_income WHERE `emp_income_id`='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    function showEployeeincomeall($id){
        $sql = "select * from `emp_income` WHERE emp_income_id='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function showEployeedeductall($id){
        $sql = "select * from emp_deduct WHERE `emp_deduct_id`='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function deleteEmpdeduct($id){
        $sql = "DELETE FROM emp_deduct WHERE `emp_deduct_id`='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    function updateEmployeeeduct($id,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank){
      $sql = "UPDATE `emp_deduct` SET  `comp_id`='".$comp_id."',`user_id`='".$user_id."',head_id='".$destid."',remark='".$destdremark."',calc_type='".$decaltype."',std_amt='".$destdamt."',bank_id='".$selbank."',db_update=NOW() WHERE emp_deduct_id='".$id."'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      return $stmt;
    }
    function insertEmployeeeduct($empid,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank){
        $sql1 = "select * from `emp_deduct` WHERE emp_id='".$empid."' AND head_id='".$destid."' ";
        $stmt = $this->connection->prepare($sql1);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $rowsdata = $stmt->rowCount();
        if($rowsdata=='0') {
              $sql = "INSERT INTO `emp_deduct`(`emp_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `comp_id`,`user_id`,bank_id, `db_addate`, `db_update`) VALUES ('".$empid."','".$destid."','".$decaltype."','".$destdamt."','".$destdremark."','".$comp_id."','".$user_id."','".$selbank."',Now(),Now())";
              $stmt = $this->connection->prepare($sql);
              $stmt->execute();
        }else{
        $sql = "UPDATE `emp_deduct` SET calc_type='".$decaltype."',std_amt='".$destdamt."',bank_id='".$selbank."',remark='".$destdremark."',db_update=NOW() WHERE  emp_deduct_id='".$rows['emp_deduct_id']."'";
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
        }
        return $stmt;
    }
    function displayQualification($qid){
        $sql = "SELECT * FROM `mast_qualif` WHERE mast_qualif_id='".$qid."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function displayDepartment($did){
        $sql = "SELECT * FROM `mast_dept`  WHERE mast_dept_id='".$did."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function getEmpIncome($id){
         $sql = "SELECT SUM(`std_amt`) as total FROM emp_income where emp_id='".$id."'  and ((calc_type <=5  or calc_type = 14)  and calc_type !=3)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function updateEmployee($id,$fname,$mname,$lname,$uname,$password,$gentype,$bdate,$joindate,$lodate,$incdate,$add1,$panno,$perdate,$pfdate,$client,$design,$depart,$category_id,$qualifi,$bank,$location,$bankacno,$paycid,$esistatus,$namerel,$prnsrno,$esicode,$pfcode,$adhaar,$drilno,$uan,$votid,$jobstatus,$emailtext,$phone,$duedate,$ticket_no,$comp_ticket_no,$married_status,$pay_mode,$pin_code,$handicap,$nation,$comp_id,$user_id,$qualification,$department){
     $passcode=substr(number_format(time() * rand(),0,'',''),0,6); 
     
     $sql = "UPDATE `employee` SET `passcode`='".$passcode."',`comp_id`='".$comp_id."',`user_id`='".$user_id."',email='".$emailtext."',`first_name`='".$fname."',`middle_name`='".$mname."',`last_name`='".$lname."',`user_name`='".$uname."',`password`='".$password."',`gender`='".$gentype."',`bdate`='".$bdate."',`joindate`='".$joindate."',`leftdate`='".$lodate."',`incrementdate`='".$incdate."',`permanentdate`='".$perdate."',`pfdate`='".$pfdate."',`client_id`='".$client."',`desg_id`='".$design."',`dept_id`='".$depart."',`category_id`='".$category_id."',`qualif_id`='".$qualifi."',`bank_id`='".$bank."',`loc_id`='".$location."',`paycode_id`='".$paycid."',`bankacno`='".$bankacno."',`middlename_relation`='".$namerel."',`prnsrno`='".$prnsrno."',`esino`='".$esicode."',`pfno`='".$pfcode."',`esistatus`='".$esistatus."',`adharno`='".$adhaar."',`panno`='".$panno."',`driving_lic_no`='".$drilno."',`uan`='".$uan."',`voter_id`='".$votid."',`job_status`='".$jobstatus."',`emp_add1`='".$add1."',`mobile_no`='".$phone."', `due_date`='".$duedate."', `ticket_no`='".$ticket_no."', `comp_ticket_no`='".$comp_ticket_no."', `married_status`='".$married_status."', `pay_mode`='".$pay_mode."', `nationality`='".$nation."', `handicap`='".$handicap."',`pin_code`='".$pin_code."',`dept`='".$department."',`qualif`='".$qualification."',db_update=NOW() WHERE emp_id='".$id."'";
     $stmt = $this->connection->prepare($sql);
     $stmt->execute();
    if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    
    function updateEmployeeincome($id,$caltype,$stdamt,$incomeid,$inremark,$comp_id,$user_id){
        $sql = "UPDATE `emp_income` SET `comp_id`='".$comp_id."',`user_id`='".$user_id."', head_id='".$incomeid."',remark='".$inremark."',calc_type='".$caltype."',std_amt='".$stdamt."',db_update=NOW() WHERE emp_income_id='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    function insertEmployeeincome($empid,$caltype,$stdamt,$incomeid,$inremark,$comp_id,$user_id){
         $sql1 = "select * from `emp_income` WHERE emp_id='".$empid."' AND head_id='".$incomeid."' ";
         $stmt = $this->connection->prepare($sql1);
         $stmt->execute();
         $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $rowsdata = $stmt->rowCount();
       if($rowsdata=='0') {
            $sql = "INSERT INTO `emp_income`(`emp_id`,`head_id`, `calc_type`, `std_amt`, `remark`,`comp_id`,`user_id`, `db_addate`, `db_update`) VALUES ('".$empid."','".$incomeid."','".$caltype."','".$stdamt."','".$inremark."','".$comp_id."','".$user_id."',Now(),Now())";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
       }else{
            $sql = "UPDATE `emp_income` SET calc_type='".$caltype."',std_amt='".$stdamt."',remark='".$inremark."',db_update=NOW() WHERE emp_income_id='".$rows['emp_income_id']."'";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
       }
        return $stmt;
    }
    function displayDedincome($id){
       $sql = "SELECT * FROM `emp_deduct` WHERE emp_id='".$id."'  ORDER BY `emp_deduct_id` ASC";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    function displayDeductionhead($id){
       $sql = "select * from mast_deduct_heads WHERE  `mast_deduct_heads_id`='".$id."' ";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
   }
   function displayEmpleave($id){
        $sql = "SELECT * FROM `emp_leave` WHERE emp_id='".$id."'  ORDER BY `emp_leave_id` ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function displayLeavetype($id){
       $sql = "select * from mast_leave_type WHERE mast_leave_type_id='".$id."' ";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
   }
   function deleteEmpleave($id){
        $sql = "DELETE FROM emp_leave WHERE `emp_leave_id`='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    function displayAdvances($id){
        $sql = "SELECT * FROM `emp_advnacen` WHERE emp_id='".$id."'  ORDER BY `emp_advnacen_id` ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function displayAdvancetype($id){
       $sql = "select * from mast_advance_type WHERE mast_advance_type_id='".$id."' ";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
   }
   function deleteEmpadvances($id){
        $sql = "DELETE FROM emp_advnacen WHERE `emp_advnacen_id`='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    function updateEmployeeadvances($id,$advamt,$advins,$comp_id,$user_id,$advdate,$advtype){
       $sql = "UPDATE emp_advnacen SET `date`='".$advdate."',`advance_type_id`='".$advtype."',`comp_id`='".$comp_id."',`user_id`='".$user_id."',adv_amount='".$advamt."', adv_installment='".$advins."',db_update=NOW() WHERE emp_advnacen_id='".$id."'";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
        return $stmt;
    }
    function insertEmployeeadvances($empid,$advamt,$advins,$comp_id,$user_id,$advdate,$advtype){
     $sql1 = "select * from `emp_advnacen` WHERE emp_id='".$empid."' AND advance_type_id='".$advtype."' AND date='".$advdate."' ";
     $stmt = $this->connection->prepare($sql1);
     $stmt->execute();
     $rows = $stmt->fetch(PDO::FETCH_ASSOC);
     $rowsdata = $stmt->rowCount();
        if($rowsdata=='0') {
         $sql = "INSERT INTO `emp_advnacen`(`emp_id`,`date`,`advance_type_id`,`adv_amount`,`adv_installment`,`comp_id`,`user_id`, `db_addate`, `db_update`) VALUES ('".$empid."','".$advdate."','".$advtype."','".$advamt."','".$advins."','".$comp_id."','".$user_id."',Now(),Now())";
         $stmt = $this->connection->prepare($sql);
         $stmt->execute();
      }
        else{
            $sql = "UPDATE emp_advnacen SET adv_amount='".$advamt."', adv_installment='".$advins."',db_update=NOW() WHERE emp_advnacen_id='".$rows['emp_advnacen_id']."'";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
        return $stmt;
    }
    function showEployeeadnavcenall($id){
        $sql = "select * from `emp_advnacen` WHERE emp_advnacen_id='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function insertEmployee($fname,$mname,$lname,$gentype,$bdate,$joindate,$lodate,$incdate,$add1,$panno,$perdate,$pfdate,$client,$design,$depart,$qualifi,$bank,$location,$bankacno,$paycid,$esistatus,$namerel,$prnsrno,$esicode,$pfcode,$adhaar,$drilno,$uan,$votid,$jobstatus,$email,$phoneno,$duedate,$ticket_no,$comp_ticket_no,$married_status,$pay_mode,$pin_code,$handicap,$nation,$comp_id,$user_id,$qualification,$department){
         $passcode=substr(number_format(time() * rand(),0,'',''),0,6); 
         $sql = "INSERT INTO `employee`(`first_name`, `middle_name`, `last_name`, `gender`, `bdate`, `joindate`, `leftdate`,`incrementdate`, `permanentdate`, `pfdate`, `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`,  `paycode_id`, `bankacno`, `middlename_relation`, `prnsrno`, `esino`, `pfno`, `esistatus`, `adharno`, `panno`,`driving_lic_no`, `uan`, `voter_id`, `job_status`, `email`,`emp_add1`,`mobile_no`,  `due_date`, `ticket_no`, `comp_ticket_no`, `married_status`, `pay_mode`, `nationality`, `handicap`,`pin_code`,`comp_id`,`user_id`, `dept`, `qualif`,`passcode`,`db_adddate`, `db_update`) VALUES ('".$fname."','".$mname."','".$lname."','".$gentype."','".$bdate."','".$joindate."','".$lodate."','".$incdate."','".$perdate."','".$pfdate."','".$client."','".$design."','".$depart."','".$qualifi."','".$bank."','".$location."','".$paycid."','".$bankacno."','".$namerel."','".$prnsrno."','".$esicode."','".$pfcode."','".$esistatus."','".$adhaar."','".$panno."','".$drilno."','".$uan."','".$votid."','".$jobstatus."','".$email."','".$add1."','".$phoneno."','".$duedate."','".$ticket_no."','".$comp_ticket_no."','".$married_status."','".$pay_mode."','".$nation."','".$handicap."','".$pin_code."','".$comp_id."','".$user_id."','".$department."','".$qualification."','".$passcode."',NOW(),NOW())"; 
         $stmt = $this->connection->prepare($sql);
         $stmt->execute();
       return $inserted = $this->connection->lastInsertId();
    }
    function deleteClient($cid){
            $sql = "DELETE FROM `mast_client` WHERE mast_client_id='".$cid."' ";
		    $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt;
    }
    function insertClient($name,$add1,$esicode,$pfcode,$tanno,$panno,$gstno,$mont,$parent,$comp_id,$user_id,$sc,$email){
        $sql = "INSERT INTO `mast_client`(`client_name`, `client_add1`,`esicode`, `pfcode`, `tanno`, `panno`, `gstno`, `current_month`,`parentId`, `valid_users`,`comp_id`,`email`, `ser_charges`,`db_adddate`, `db_update`) VALUES('".$name."','".$add1."','".$esicode."','".$pfcode."','".$tanno."','".$panno."','".$gstno."','".$mont."','".$parent."','".$user_id."','".$comp_id."','".$email."','".$sc."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    return $inserted = $this->connection->lastInsertId();
	}
	function updateClient($cid,$name,$add1,$esicode,$pfcode,$tanno,$panno,$gstno,$mont,$parent,$sc,$email,$comp_id,$user_id){
        $sql = "UPDATE `mast_client` SET `comp_id`='".$comp_id."',`user_id`='".$user_id."',`email`='".$email."',`ser_charges`='".$sc."',`client_name`='".$name."',`client_add1`='".$add1."',`esicode`='".$esicode."',`pfcode`='".$pfcode."',`tanno`='".$tanno."',`panno`='".$panno."',`gstno`='".$gstno."',`current_month`='".$mont."',`parentId`='".$parent."',`db_update`=NOW()  WHERE mast_client_id='".$cid."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    function deleteDepartment($did){
       $sql = "DELETE FROM `mast_dept` WHERE mast_dept_id='".$did."' ";
	   $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $rowsdata = $stmt->rowCount();
     
        return $rowsdata;
    }
    function insertDepartment($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_dept`(mast_dept_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $count=$stmt->rowCount();
        return $count;
    }
    function updateDepartment($did,$name,$comp_id,$user_id){
         $sql = "UPDATE `mast_dept` SET  `comp_id`='".$comp_id."',`user_id`='".$user_id."',`mast_dept_name`='".$name."' ,db_update=NOW() WHERE mast_dept_id='".$did."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    
       function displayCompany($id){
        $sql = "select * from mast_company WHERE `comp_id`='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

function getClientMonth($comp_id){
 	$sql = "select current_month from `mast_client` where comp_id='$comp_id' limit 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row;
}
    function insertQualification($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_qualif`(mast_qualif_name,comp_id,user_id,`db_adddate`, `db_update`) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg='0103';
        } else{
        $msg= '0052';
        }
        return $msg;
    }
    function updateQualification($id,$name,$comp_id,$user_id){
        $sql = "UPDATE `mast_qualif` SET  `comp_id`='".$comp_id."',`user_id`='".$user_id."', mast_qualif_name='".$name."' ,db_update=NOW() WHERE mast_qualif_id='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    
//********************************************************************Salary Menu commaon for attendance and Supervisor and admin ***********************   
    function showClient1($comp_id,$user_id){
       $sql = "select * from mast_client where comp_id ='".$comp_id."' AND  valid_users like '%".$user_id."%'   ORDER BY `mast_client_id` DESC";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
   	}
    function displayemployeeClientlmt($cid,$lmt){
        $sql = "select * from employee WHERE client_id='".$cid."' AND job_status!='L' order by emp_id, first_name,middle_name,last_name limit $lmt";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
   	}       
   function displayTranday($id){
        $sql = "SELECT * FROM `tran_days` WHERE emp_id='".$id."'";
       $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
   	}      
   	 function insertTranday($client,$tr_id,$emp,$smonth,$fp,$hp,$lw,$wo,$pr,$ab,$pl,$sl,$cl,$ol,$ph,$add,$oh,$ns,$extra_inc1,$extra_inc2,$leave_encash,$reward,$extra_ded1,$extra_ded2,$leftdate,$invalid,$comp_id,$user_id,$wagediff,$Allow_arrears,$Ot_arrears,$income_tax,$society,$canteen,$remarks){
        $i=0;
        foreach($emp as $e) {
          if($tr_id[$i]!=''){
		    $sql = "UPDATE `tran_days` SET `user_id`='".$user_id."',`comp_id`='".$comp_id."',extra_inc1='" . $extra_inc1[$i] . "',extra_inc2='" . $extra_inc2[$i] . "',leave_encash='" . $leave_encash[$i] . "',reward='" . $reward[$i] . "', extra_ded1='" . $extra_ded1[$i] . "',extra_ded2='" . $extra_ded2[$i] . "',leftdate='" . $leftdate[$i] . "',invalid='" . $invalid[$i] . "', `comp_id`='".$comp_id."',`user_id`='".$user_id."',`emp_id`='".$emp[$i]."',`client_id`='".$client."',`sal_month`='".$smonth."',`fullpay`='".$fp[$i]."',`halfpay`='".$hp[$i]."',`leavewop`='".$lw[$i]."',`present`='".$pr[$i]."',`absent`='".$ab[$i]."',`weeklyoff`='".$wo[$i]."',`pl`='".$pl[$i]."',`sl`='".$sl[$i]."',`cl`='".$cl[$i]."',`otherleave`='".$ol[$i]."',`paidholiday`='".$ph[$i]."',`additional`='".$add[$i]."',`othours`='".$oh[$i]."',`nightshifts`='".$ns[$i]."',`db_update`=NOW(),`updated_by`='".$user_id."',`wagediff`='".$wagediff[$i]."',`Allow_arrears`='".$Allow_arrears[$i]."',`Ot_arrears` ='".$Ot_arrears[$i]."',`incometax` ='".$income_tax[$i]."',`society` ='".$society[$i]."',`canteen` ='".$canteen[$i]."',`remarks` ='".$remarks[$i]."' WHERE `trd_id`='".$tr_id[$i]."' ";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
            else {
            $sql = "INSERT INTO `tran_days`(`user_id`,`client_id`, `comp_id`, `emp_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`,`present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`,`nightshifts`, `extra_inc1`, `extra_inc2`,leave_encash,reward, `extra_ded1`, `extra_ded2`, `leftdate`, `invalid`,`db_adddate`, `db_update`,`updated_by`,`wagediff`, `Allow_arrears`, `Ot_arrears`,incometax,society,canteen,remarks) VALUES('" . $user_id . "','" . $client . "','" .$comp_id  . "','" . $emp[$i]. "','" . $smonth . "','" . $fp[$i] . "','" . $hp[$i] . "','" . $lw[$i] . "','" . $pr[$i] . "','" . $ab[$i] . "','" . $wo[$i] . "','" . $pl[$i] . "','" . $sl[$i] . "','" . $cl[$i] . "','" . $ol[$i] . "','" . $ph[$i] . "','" . $add[$i] . "','" . $oh[$i] . "','" . $ns[$i] . "','" . $extra_inc1[$i] . "','" . $extra_inc2[$i] . "','" . $leave_encash[$i]. "','" . $reward[$i]. "','" . $extra_ded1[$i] . "','" . $extra_ded2[$i] . "','" . $leftdate[$i] . "','" . $invalid[$i] . "',NOW(),NOW(),'".$user_id."','".$wagediff[$i]."','".$Allow_arrears[$i]."','".$Ot_arrears[$i]."','".$income_tax[$i]."','".$society[$i]."','".$canteen[$i]."','".$remarks[$i]."')";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
            $i++;
        }
      return $i;
      //************************************************************************
      
        $cl_name = $this->displayClient($client);
        $cmonth = $cl_name['current_month'];
        
        $sql = "SELECT LAST_DAY('".$cmonth."') AS last_day";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $endmth = $row['last_day'];
        $monthdays= $row['last_day'];

        $sql = "SELECT date_add(date_add(LAST_DAY('".$cmonth."'),interval 1 DAY),interval -1 MONTH) AS first_day";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $startmth = $row['first_day'];

        // Checking data validity
        $sql = "update tran_days set invalid = '' where client_id ='".$client."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        // step 1. checking for left employees
        $sql = "SELECT emp_id,first_name,middle_name,last_name from `employee` emp WHERE  emp.client_id = '".$client_id."' and emp.job_status ='L' and emp.emp_id in (SELECT emp_id FROM tran_days)" ;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count=$stmt->rowCount();
       


        $row= mysql_query($sql);
        $row1= mysql_query($sql);

        if($count >0)
            {   echo "\n Days details are available for left employees.Records will be deleted.".chr(13).chr(10);
                foreach($row as $res){
                    echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
                    $sql  = "delete from  tran_days  where emp_id ='".$res['emp_id']."'";
                    $stmt = $this->connection->prepare($sql);
                    $stmt->execute();
                }
        };
        // Left employees ends here
        
        
        //Onjob employee but no tran day record
        $sql = "SELECT emp_id,first_name,middle_name,last_name from `employee`  emp WHERE  emp.client_id = '".$client."' and emp.job_status !='L' and emp.emp_id not in (SELECT emp_id FROM tran_days)" ;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count=$stmt->rowCount();
   
        if($count >0){
            echo "\n Records will be added for following employee.".chr(13).chr(10);
            foreach ($row as $res){
                    echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
                    $sql  = "insert into tran_days (emp_id,sal_month,client_id,comp_id,user_id,updatedby values ('".$res['emp_id']."','".$endmth."','".$client_id."','".$comp_id."','".$user_id."','".$user_id."'";
                    $stmt = $this->connection->prepare($sql);
                    $stmt->execute();
                }
            
        };


        //(presentday=0 .and. othours>0)
        $sql = "SELECT trd_id from tran_days WHERE  client_id = '".$client_id."' and present = 0 and othours >0" ;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count=$stmt->rowCount();

         if($count >0){
                echo "\nInvalid Othours.Please Check Transction Days Details.";
                 foreach($row as $res ){
                        $sql  = "update tran_days set invalid = concat(invalid,'OtHours-') where trd_id ='".$res['trd_id']."'";
                        $stmt = $this->connection->prepare($sql);
                         $stmt->execute();
                  }
            };

        //All days calculation - Regular emloyees
        $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != '".$monthdays."' and (td.leftdate ='0000-00-00' or isnull(td.leftdate) and  td.client_id = '".$client."' and emp.joindate< '".$startmth."'" ;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count=$stmt->rowCount();

         if($count >0){
                echo "\nInvalid Total Days for Regular Employee.Please Check Transaction Days Details.";
                foreach($row as $res){
                    $sql  = "update tran_days set invalid = concat(invalid,'Days Total(R)-') where trd_id ='".$res['trd_id']."'";
                    $stmt = $this->connection->prepare($sql);
                    $stmt->execute();
                }
        };


        //All days calculation - Newly joined emloyees
        $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ('".$monthdays ."'-day(emp.joindate))+1 and td.leftdate ='0000-00-00' and  td.client_id = '".$client."'and  emp.joindate> '".$startmth."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count=$stmt->rowCount();

         if($count >0){
            echo " Invalid Total Days.Please Check Transaction Days Details.";
            foreach($row as $res){
                $sql  = "update tran_days set invalid = concat(invalid,'Days Total(N)-') where trd_id ='".$res['trd_id']."'";
                $stmt = $this->connection->prepare($sql);
                $stmt->execute();
            }
        };

        //All days calculation - left emloyees

        $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ( day(td.leftdate) - day('".$startmth."'))+1 and td.leftdate !='0000-00-00' and  td.client_id = '".$client."' and  emp.joindate< '".$startmth."'" ;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count=$stmt->rowCount();

         if($count >0){
            echo "Invalid Total Days.Please Check Transaction Days Details.";
            foreach($row as $res){
                  $sql  = "update tran_days set invalid = concat(invalid,'Days Total(L)-') where trd_id ='".$res['trd_id']."'";
                  $stmt = $this->connection->prepare($sql);
                  $stmt->execute();
            }
        };

        // Days checking is over.
    }
    function blankExportTranDays($comp_id,$client_id){
     $sql ="select td_string from mast_company where comp_id = '".$comp_id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $head = $row['td_string'];
        $exhd = explode(',',$head);
        $j= count($exhd);
        $sql = "SELECT mc.mast_client_id , mc.client_name,date_format(mc.current_month,'%Y-%c-%d') as 'Sal_month', emp.`emp_id` as 'Emp_ID',concat(emp.first_name,' ',emp.middle_name,' ',emp.last_name) AS 'Employee_NAME' ";
        for($i=1; $i<$j; $i++ ){
	            $sql =$sql .", '' as ".$exhd[$i];
        }
         $sql .= ",emp.ticket_no,md.mast_dept_name as 'Dept_Name',emp.comp_ticket_no FROM `employee` emp inner join mast_client mc  on emp.client_id = mc.mast_client_id  inner join mast_dept md on emp.dept_id= md.mast_Dept_id where emp.client_id = '".$client_id."' and emp.job_status != 'L'  order by emp.emp_id";	
        $stmt = $this->connection->prepare($sql);
        //echo $sql;exit;
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $row1[0]= $exhd;
        $row1[1]=$row;
        return $row1;

 
    }
    //Import tranday transactions from excel file
    function gettd_string($comp_id){
        $sql ="select td_string from mast_company where comp_id = '".$comp_id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $head = $row['td_string'];
        return $head;
    }
    function getTranDayEmpCount($emp_id){
        $sql = "select count(emp_id) as cnt ,trd_id from tran_days where emp_id = $emp_id ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    
    
    
    
    
    
    
    function updateTranday($sql){
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= '1';
        } else{
        $msg= '0';
        }
        return $msg;
    }
    
    function executeQuery($sql){
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
        
    } 
    
    
    
    function insertLocation($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_location`(mast_location_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg='1';
        } else{
        $msg= '2';
        }
        return $msg;
    }
    function updateLocation($id,$name,$comp_id,$user_id){
        $sql = "UPDATE mast_location SET  `comp_id`='".$comp_id."',`user_id`='".$user_id."',mast_location_name='".$name."' ,db_update=NOW() WHERE mast_location_id='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    function displayLocation($lid){
        $sql = "SELECT * FROM mast_location WHERE mast_location_id='".$lid."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    function lastDay($cmonth){
        $sql = "SELECT LAST_DAY('".$cmonth."') AS last_day";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $endmth = $row['last_day'];
        $monthdays= $row['last_day'];
        return $monthdays;
    }
    function firstDay($cmonth){
        $sql = "SELECT date_add(date_add(LAST_DAY('".$cmonth."'),interval 1 DAY),interval -1 MONTH) AS first_day";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $first_day = $row['first_day'];
        return $first_day;

    }
    function showEmployeereport($comp_id,$user_id){
       
        $sql = "select * from employee where comp_id ='".$comp_id."' AND user_id='".$user_id."' ORDER BY Client_id,last_name,first_name,middle_name,Joindate ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function getSalMonthData($comp_id,$user_id,$zerosal,$empid,$emp,$tab_days,$tab_emp,$clientid,$frdt,$todt){
           $sql = "SELECT td.* FROM hist_days td inner join hist_employee te on td.emp_id = te.emp_id and te.sal_month = td.sal_month  WHERE td.client_id ='".$clientid."'   AND td.sal_month >= '$frdt' and td.sal_month <= '$todt' ";
        if($emp!='all'){
        $sql .= " AND td.emp_id=".$empid;
        }
        if($zerosal=='no'){
        $sql .= " AND te.gross_salary >0";
        }
      
          $sql .= " union ";
        $sql .= "SELECT td.* FROM tran_days td inner join tran_employee te on td.emp_id = te.emp_id and te.sal_month = td.sal_month  WHERE td.client_id ='".$clientid."'   AND td.sal_month >= '$frdt' and td.sal_month <= '$todt' ";
        if($emp!='all'){
        $sql .= " AND td.emp_id=".$empid;
        }
        if($zerosal=='no'){
        $sql .= " AND te.gross_salary >0";
        }
        // echo $sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function getPaySummery($tab_days,$comp_id,$user_id,$month,$frdt,$todt){
        $sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' "; 
        if($month=='current'){
        }else{
        $sql .= " AND sal_month >= '$frdt' AND sal_month <= '$todt' ";
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function showCompdetailsById($comp_id){
        $sql = "SELECT * FROM mast_company WHERE comp_id ='".$comp_id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function showtranhiEployeedetails($id,$sal_month){
      $sql = "select * from hist_employee WHERE emp_id='".$id."' and sal_month ='".$sal_month."' union  select * from tran_employee WHERE emp_id='".$id."' and sal_month ='".$sal_month."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
  function showEployeedetailsQ($id){
       $sql = "select emp.*,md.mast_desg_name from employee emp inner join mast_desg md on emp.desg_id = md.mast_desg_id WHERE emp.emp_id='".$id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
   function getEmployeeDetailsByClientIdAppont($clientid,$cmonth){
		$sql ="select emp.first_name,emp.middle_name,emp.last_name,emp.gender,emp.esistatus,emp.emp_add1,emp.pin_code,emp.emp_id,emp.joindate,md.mast_desg_name ,emp.due_date from employee emp	 inner join mast_desg md on md.mast_desg_id = emp.desg_id where emp.client_id='$clientid' and year(emp.joindate) = year('$cmonth') and month(emp.joindate) = month('$cmonth') ";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
	}
      function displayBank($bid){
        $sql = "select * from mast_bank WHERE `mast_bank_id`='".$bid."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function getEmployeeDeduction($empid){		
		$sql ="select eded.std_amt, eded.head_id,dedhd.deduct_heads_name from emp_deduct eded inner join mast_deduct_heads dedhd on eded.head_id = dedhd.mast_deduct_heads_id where eded.emp_id ='".$empid."'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
	}
    function getEmployeeIncome($empid){		
        $sql ="select eimc.std_amt,eimc.calc_type, eimc.head_id,inchd.income_heads_name from emp_income eimc inner join mast_income_heads inchd on eimc.head_id = inchd.mast_income_heads_id where emp_id ='".$empid."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
	  function getEmpTranIncome($comp_id,$tran_day_emp_id,$sal_month){
     $sql = "select * from (select ti.*,mi.income_heads_name from tran_income ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id inner join tran_employee  te on te.emp_id =ti.emp_id and te.sal_month = ti.sal_month where mi.comp_id = '$comp_id'  and ti.emp_id = '$tran_day_emp_id' and  ti.sal_month = '$sal_month' 
        	       union
        	       select ti.*,mi.income_heads_name from hist_income ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id inner join hist_employee  te on te.emp_id =ti.emp_id and te.sal_month = ti.sal_month where mi.comp_id = '$comp_id'  and ti.emp_id = '$tran_day_emp_id' and  ti.sal_month = '$sal_month') a   order by head_id";
	       $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
   }
	  function getEmpTranDeduct($comp_id,$tran_day_emp_id,$sal_month){
	       $sql = "select * from  ( select tdd.*,md.deduct_heads_name from tran_deduct tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id where md.comp_id = '$comp_id'  and tdd.emp_id = '$tran_day_emp_id' and  tdd.sal_month = '$sal_month'   
	               union
	               select tdd.*,md.deduct_heads_name from hist_deduct tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join hist_employee  te on te.emp_id =tdd.emp_id and te.sal_month = tdd.sal_month where md.comp_id = '$comp_id'  and tdd.emp_id = '$tran_day_emp_id' and  tdd.sal_month = '$sal_month' ) a   order by head_id";
	       $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;

	}
        function getEmpTranAdvance($comp_id,$tran_day_emp_id,$sal_month){
           $sql = "select * from  ( select tadv.*,mad.advance_type_name from tran_advance tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id  where mad.comp_id = '$comp_id'  and tadv.emp_id = '$tran_day_emp_id' and  tadv.sal_month = '$sal_month' and tadv.amount >0 
                    union
                    select tadv.*,mad.advance_type_name from hist_advance tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id inner join hist_employee  te on te.emp_id =tadv.emp_id and te.sal_month = tadv.sal_month  where mad.comp_id = '$comp_id'  and tadv.emp_id = '$tran_day_emp_id' and  tadv.sal_month = '$sal_month' and tadv.amount >0 ) a  order by  head_id";
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
        function getEmpTranDays($emp_id,$sal_month)
        {
            $sql = " select * from (
                    select sal_month, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`,`extra_inc2` from tran_days where emp_id='$emp_id' and sal_month = '$sal_month' 
                    union
                    select sal_month, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`,`extra_inc2` from hist_days where emp_id='$emp_id' and sal_month = '$sal_month' ) a
                    ";
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;

        }
        function getSummaryTranEmp($tab_emp,$emp,$clintid,$frdt){
           if($emp=='Parent')
           {
     		$sql = "select count(emp_id) as totalemp,sum(netsalary) as netsalary,sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(gross_salary) as gross_salary from $tab_emp inner join mast_client  on mast_client.mast_client_id = $tab_emp. client_id  where mast_client.parentid  =  '$clintid'  AND $tab_emp.sal_month = '$frdt' GROUP by parentid";
     	   }
    	   else{
     		  $sql = "select count(emp_id) as totalemp,sum(netsalary) as netsalary,sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(gross_salary) as gross_salary from $tab_emp inner join mast_client  on mast_client.mast_client_id = $tab_emp. client_id  where mast_client.mast_client_id   =  '$clintid'  AND $tab_emp.sal_month = '$frdt' GROUP by client_id";
           }
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
 
        }

     function getSummaryTranIncome($tab_empinc,$emp,$clintid,$frdt,$tab_emp){
    
      if($emp=='Parent'){
             $sql="select ti.head_id ,mi.income_heads_name,sum(ti.amount) as amount,sum(ti.std_amt) as std_amt,ti.sal_month  from $tab_empinc ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join $tab_emp e  on e.emp_id = ti.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clintid."'   AND ti.sal_month = '$frdt'  group by ti.head_id ";
           }
           else
           {
            $sql="select ti.head_id ,mi.income_heads_name,sum(ti.amount) as amount,sum(ti.std_amt) as std_amt,ti.sal_month from $tab_empinc ti  inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id inner join $tab_emp e  on e.emp_id = ti.emp_id  and e.sal_month=ti.sal_month inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clintid."'  AND ti.sal_month = '$frdt'  group by ti.head_id ";
    
           }
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
 
        }
        function getSummaryTranDeduct($tab_empded,$emp,$clintid,$frdt,$tab_emp){
         	if($emp=='Parent')
           {
    	 		$sql="select tdd.sal_month,tdd.head_id ,md.deduct_heads_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join $tab_emp e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clintid."'   AND tdd.sal_month = '$frdt'  group by tdd.head_id ";
           }
           else
           {
    			$sql="select tdd.sal_month,tdd.head_id ,md.deduct_heads_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join $tab_emp e  on e.emp_id = tdd.emp_id and e.sal_month = tdd.sal_month inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clintid."'  AND tdd.sal_month = '$frdt'  group by tdd.head_id ";
    
           }
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
        function getSummaryTranAdv($tab_adv,$emp,$clintid,$frdt,$tab_emp){
            	   if($emp=='Parent')
                   {
            	    $sql = "select sum(tadv.amount) as amount ,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id inner join mast_client mc on mc.mast_client_id = tadv.client_id where mc.parentId =  '".$clintid."' and  mad.comp_id = '$comp_id'   and  tadv.sal_month >= '$frdt' AND tadv.sal_month <= '$todt'   group by mc.parentId,mad.mast_advance_type_id";
            	   }
            	   else
            	   {
            	 $sql = "select sum(tadv.amount) as amount,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id inner join mast_client mc on mc.mast_client_id = tadv.client_id where tadv.client_id =  '".$clintid."' and  mad.comp_id = '$comp_id'   and  tadv.sal_month >= '$frdt' AND tadv.sal_month <= '$todt'   group by mc.mast_client_id,mad.mast_advance_type_id";
                           }
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;

        
        }
        function getSummaryTranDays($tab_days,$emp,$clintid,$frdt){
		
               if($emp=='Parent')
               {
         			$sql = "select sum(extra_inc2) as extra_inc2,sum(halfpay) as halfpay,sum(leavewop) as leavewop,sum(present) as present,sum(absent)as absent,sum(weeklyoff) as weeklyoff,sum(pl) as pl,sum(sl) as sl,sum(cl) as cl,sum(otherleave) as otherleave,sum(paidholiday) as paidholiday,sum(additional) as additional,sum(othours) as othours,sum(nightshifts) as nightshifts,sal_month from $tab_days inner join mast_client on mast_client.mast_client_id = $tab_days. client_id  where mast_client.parentid  =  '".$clintid."'  AND $tab_days.sal_month = '$frdt' GROUP by parentid";
               }
               else
               {
        			$sql = "select sum(extra_inc2) as extra_inc2,sum(halfpay) as halfpay,sum(leavewop) as leavewop,sum(present) as present,sum(absent)as absent,sum(weeklyoff) as weeklyoff,sum(pl) as pl,sum(sl) as sl,sum(cl) as cl,sum(otherleave) as otherleave,sum(paidholiday) as paidholiday,sum(additional) as additional,sum(othours) as othours,sum(nightshifts) as nightshifts,sal_month from $tab_days inner join mast_client on mast_client.mast_client_id = $tab_days. client_id  where mast_client.mast_client_id  =  '".$clintid."'  AND $tab_days.sal_month = '$frdt' GROUP by parentid";
               }

           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
        
        
        
        // function getPFstatement($emp,$tab_empded,$tab_days,$tab_emp,$clientid,$comp_id,$frdt){
		
        //     if($emp=='Parent')
        //     {
        //     $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1 inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month= t1.sal_month  inner join mast_client t3 on t4.client_id= t3.mast_client_id  where  t3.parentid='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
        //     }
        //     else{
        //     $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1  inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month = t1.sal_month where  t4.client_id='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
        //     }
        //     $sql .= " AND t1.sal_month='".$frdt."' ";
        //     $sql .="order by t4.emp_id,t2.first_name,t2.middle_name,t2.last_name";
        //     echo $sql;
        //   $stmt = $this->connection->prepare($sql);
        //   $stmt->execute();
        //   $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //   return $row;
        // }
        
          function getPFstatement($emp,$tab_empded,$tab_days,$tab_emp,$clientid,$comp_id,$frdt){
		
            if($emp=='Parent')
            {
            $sql = "
            SELECT t1.*, t2.first_name, t2.middle_name, t2.last_name, t2.uan, t4.pfno, t5.absent, t4.client_id
FROM $tab_empded t1
INNER JOIN $tab_days t5 ON t5.emp_id = t1.emp_id AND t5.sal_month = t1.sal_month
INNER JOIN employee t2 ON t1.emp_id = t2.emp_id
INNER JOIN $tab_emp t4 ON t4.emp_id = t1.emp_id AND t4.sal_month = t1.sal_month
INNER JOIN mast_client t3 ON t4.client_id = t3.mast_client_id
WHERE t3.parentid = '".$clientid."'
AND t1.head_id IN (
    SELECT mast_deduct_heads_id
    FROM mast_deduct_heads
    WHERE deduct_heads_name LIKE '%P.F.%'
    AND mast_deduct_heads.comp_id = '".$comp_id."'
)";
            }
            else{
            $sql .= "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1  inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month = t1.sal_month where  t4.client_id='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
            }
            $sql .= " AND t1.sal_month='".$frdt."' ";
            $sql .="order by t4.emp_id,t2.first_name,t2.middle_name,t2.last_name";
            echo $sql;
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
      
        function getCharges($frdt){
		
            $sql = "select * from pf_charges where '".$frdt."' >=from_date and '".$frdt."' <= to_date";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        function getPFSummary($emp,$tab_empded,$acno2,$clientid,$comp_id,$frdt){
		
            if($emp=='Parent')
            {
            $sql="select e.client_id,tdd.head_id ,mc.client_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 ,sum(round(std_amt*".$acno2." /100,0)) as acno2  from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clientid."'   AND tdd.sal_month = '$frdt' AND tdd.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and comp_id ='".$comp_id."') group by mc.mast_client_id  ";
            
            }
            else
            {
            $sql="select  e.client_id,tdd.head_id ,mc.client_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 ,sum(round(std_amt*".$acno2." /100,0)) as acno2  from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clientid."'  AND tdd.sal_month = '$frdt'   AND tdd.sal_month = '$frdt' AND tdd.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and comp_id ='".$comp_id."') group by mc.mast_client_id ";
            }
           // echo $sql;
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
        
        function getPFSummary1($tab_emp,$client_id,$comp_id,$frdt){
		
            $sql="SELECT count(*) as totemp FROM $tab_emp t inner join mast_client mc on t.client_id = mc.mast_client_id  where mc.mast_client_id = '".$client_id."' and  t.sal_month ='".$frdt."' group by mc.mast_client_id";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        function getPFSummary2($tab_empded,$client_id,$comp_id){
		
            $sql="SELECT count(*) as totpfemp FROM $tab_empded t inner join employee e on e.emp_id = t.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id = '".$row['client_id']."' and  t.sal_month ='".$frdt."'  AND t.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and comp_id ='".$comp_id."') and amount >0  group by mc.mast_client_id";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        function deleteUAN(){
            $sql="delete from uan_ecr";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt;
        }
        function getPFUAN($emp,$comp_id,$frdt,$tab_empded,$tab_days,$tab_emp,$clintid){
		
            if($emp=='Parent')
                {
                $sql = "select e.client_id,tdd.head_id ,mc.client_name,t4.gross_salary,tdd.amount as amount,tdd.std_amt as std_amt,tdd.employer_contri_1 as employer_contri_1,tdd.employer_contri_2 as employer_contri_2,e.uan,e.first_name,e.middle_name,e.last_name,round(t5.absent,0) as absent from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e on e.emp_id = tdd.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id inner join $tab_days t5  on tdd.emp_id = t5.emp_id and tdd.sal_month = t5.sal_month  inner join  $tab_emp t4 on t4.emp_id = tdd.emp_id  and t4.sal_month = tdd.sal_month where tdd.amount>0 and mc.parentId = '$clintid' AND tdd.sal_month = '$frdt' and  tdd.head_id in (select mast_deduct_heads_id from mast_deduct_heads where deduct_heads_name like '%P.F.%' and comp_id ='$comp_id') AND tdd.sal_month='$frdt'" ;
                }
            else{
                $sql = "select e.client_id,tdd.head_id ,mc.client_name,tdd.amount as amount,tdd.std_amt as std_amt,tdd.employer_contri_1 as employer_contri_1,tdd.employer_contri_2 as employer_contri_2,e.uan,e.first_name,e.middle_name,e.last_name from  tran_deduct tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e on e.emp_id = tdd.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id where tdd.amount>0 and  mc.mast_client_id = '$clintid'  AND tdd.sal_month = '$frdt'  and mc.comp_id ='$comp_id'  AND tdd.head_id in (select mast_deduct_heads_id from mast_deduct_heads where deduct_heads_name like '%P.F.%' and comp_id ='$comp_id') and tdd.sal_month='$frdt'" ;
               }
               echo $sql;
           $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
        function getPFUAN1($uan,$first_name,$middle_name,$last_name,$gross_salary,$std_amt,$amount,$employer_contri_2,$employer_contri_1,$absent){
        
            $sql1= "insert into uan_ecr (uan ,memname ,gross_wages ,epf_wages,eps_wages ,edli_wages,epf_contribution,eps_contribution,epf_eps_d ,ncp_days,refund) values (";
            
            $sql1= $sql1."concat(".chr(34).chr(39).chr(34).",'".$uan."'),concat('".$first_name." "."', '".$middle_name." "."', '".$last_name."'),'".$gross_salary."','".$std_amt;
            if ($std_amt>15000)
            {
            echo $sql1=$sql1."','15000','15000','";
            }
            else{
            $sql1=$sql1."','".$std_amt."','".$std_amt."','";
            }
            $sql1=$sql1.$amount."','".$employer_contri_2."','".$employer_contri_1."','".$absent."','0')";
            //echo $sql1;
           $stmt = $this->connection->prepare($sql1);
           $stmt->execute();
           return $stmt;
        }
        function getAllFUAN(){
            $sql="select * from uan_ecr";
            $stmt = $this->connection->prepare($sql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
        function getnewlyjoined($emp,$frdt,$clintid,$comp_id){
        
            if($emp=='Parent')
                {
                $setSql= "SELECT e.emp_id,concat(e.first_name,' ',e.middle_name,' ',e.last_name) as name,e.pfno,e.uan,e.esino,e.mobile_no,e.joindate,e.bdate,e.adharno,e.bankacno,mb.ifsc_code,mb.bank_name,mc.client_name from employee e inner join mast_client mc on mc.mast_client_id = e.client_id inner join mast_bank mb on e.bank_id = mb.mast_bank_id  where month(joindate)= month('$frdt')  and  year(joindate)= year('$frdt') and mc.parentid = $clintid   and e.comp_id = '$comp_id' order by joindate"; 
                }
            else{ 
                $setSql= "SELECT e.emp_id,concat(e.first_name,' ',e.middle_name,' ',e.last_name) as name,e.pfno,e.uan,e.esino,e.mobile_no,e.joindate,e.bdate,e.adharno,e.bankacno,mb.ifsc_code,mb.bank_name,mc.client_name from employee e inner join mast_client mc on mc.mast_client_id = e.client_id  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  where month(joindate)= month('$frdt')  and  year(joindate)= year('$frdt') and e.client_id = $clintid   and e.comp_id = '$comp_id' order by joindate";  
             }
           $stmt = $this->connection->prepare($setSql);
           $stmt->execute();
           $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $row;
        }
    function getleft($emp,$frdt,$clintid,$comp_id){
    
        if($emp=='Parent')
        {
        $setSql= "SELECT mc.client_name,e.emp_id,e.first_name,e.middle_name,e.last_name,e.pfno,e.uan,e.joindate,e.leftdate from employee e inner join mast_client mc on mc.mast_client_id = e.client_id  where month(leftdate)= month('$frdt')  and  year(joindate)= year('$frdt') and mc.parentid = $clintid  and e.comp_id = '$comp_id' order by leftdate"; 
        
        }
        else{ 	
        
        $setSql= "SELECT mc.client_name,e.emp_id,e.first_name,e.middle_name,e.last_name,e.pfno,e.uan,e.joindate,e.leftdate from employee e inner join mast_client mc on mc.mast_client_id = e.client_id  where month(leftdate)= month('$frdt')  and  year(joindate)= year('$frdt') and e.client_id = $clintid  and e.comp_id = '$comp_id' order by leftdate"; 
        
        }
        $stmt = $this->connection->prepare($setSql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function getform9($start_pfno,$end_pfno,$comp_id){
    
        $setSql= "select pfno,first_name,middle_name,last_name,joindate,leftdate,gender,bdate from employee where convert(pfno,unsigned integer)  >= '$start_pfno' and convert(pfno,unsigned integer)  <= '$end_pfno'  and comp_id = '$comp_id'  and comp_id = '$comp_id' order by pfno"; 
        $stmt = $this->connection->prepare($setSql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function deductEmpData($destid,$clientid){
          $sql = "SELECT DISTINCTROW emp_de.`std_amt`,emp_de.`calc_type`,emp_de.`remark`,emp_de.emp_deduct_id,emp.first_name as fn,emp.middle_name as mn,emp.last_name as ln,emp.emp_id FROM `employee` emp,emp_deduct emp_de where emp_de.head_id='".$destid."' AND emp_de.emp_id=emp.emp_id AND emp.client_id='".$clientid."' AND emp.job_status!='L' order by emp.emp_id,emp.first_name,emp.last_name";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
      
    }
    
    function incomeEmpData($incomeid,$clientid){
        $sql = "SELECT emp_in.`std_amt`,emp_in.`calc_type`,emp_in.`remark`,emp_in.emp_income_id,emp.first_name as fn,emp.middle_name as mn,emp.last_name as ln FROM `employee` emp,emp_income emp_in where emp_in.head_id='".$incomeid."' AND emp_in.emp_id=emp.emp_id AND emp.client_id='".$clientid."' AND emp.job_status!='L' order by emp.first_name,emp.last_name";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }     
    function getEmpData($clientid,$fielda,$fieldb,$fieldc,$fieldd){
         $sql = "SELECT $fielda,$fieldb,$fieldc,$fieldd,emp_id,first_name as fn,middle_name as mn,last_name as ln FROM `employee` where client_id='".$clientid."' AND job_status!='L' order by emp_id"; 
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    } 
      function getEmpDataFromTo($clientid,$fielda,$fieldb,$fieldc,$fieldd,$limitfrom,$limitto){
         $sql = "SELECT $fielda,$fieldb,$fieldc,$fieldd,emp_id,first_name as fn,middle_name as mn,last_name as ln FROM `employee` where client_id='".$clientid."' AND job_status!='L' order by emp_id limit $limitto offset $limitfrom"; 
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }  
    public function selectempstrdet(){
      $sql = "SHOW COLUMNS FROM employee";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
      function updateAllemp($empid,$fielda,$fieldb,$fieldc,$fieldd,$texta,$textb,$textc,$textd,$comp_id,$user_id){
        $i = 0;

        foreach($empid as $id1) {
        //if ($texta[$i]!='' && $textb[$i]!='' && $textc[$i]!='' && $textd[$i]!='') {}
        //else{
          echo "<br>";     echo  $sql = "UPDATE employee SET `comp_id`='".$comp_id."',`user_id`='".$user_id."',$fielda='$texta[$i]',$fieldb='$textb[$i]',$fieldc='$textc[$i]',$fieldd='$textd[$i]',db_update=NOW() WHERE emp_id='" . $empid[$i] . "' ";
                $stmt = $this->connection->prepare($sql);
                $stmt->execute();
          //  }

            $i++;
        }
       // exit;
        return $i;

    }
   function updateAllempincome($emp_ic_id,$texta,$caltype,$textc,$comp_id,$user_id){
        $i = 0;
       
        foreach ($emp_ic_id as $id1) :
             $sql = "UPDATE `emp_income` SET `comp_id`='".$comp_id."',`user_id`='".$user_id."',std_amt='$texta[$i]',calc_type='$caltype[$i]',remark='$textc[$i]',db_update=NOW()  WHERE emp_income_id='" . $emp_ic_id[$i] . "' ";
             $stmt = $this->connection->prepare($sql);
             $stmt->execute();
            $i++;
       endforeach;
        return $i;

    }
    function updateAllempeduct($emp_de_id,$texta,$caltype,$textc,$comp_id,$user_id){
      $i = 0;
        foreach ($emp_de_id as $id1) :
            $sql = "UPDATE `emp_deduct` SET `comp_id`='".$comp_id."',`user_id`='".$user_id."',std_amt='$texta[$i]',calc_type='$caltype[$i]',remark='$textc[$i]',db_update=NOW()  WHERE emp_deduct_id='" . $emp_de_id[$i] . "' ";
           
             $stmt = $this->connection->prepare($sql);
             $stmt->execute();
            $i++;
         endforeach;
        return $i;
    }
    
    function getEmpHeads($comp_id){
        $sql = "select mast_deduct_heads_id from mast_deduct_heads where (deduct_heads_name LIKE 'P.F.' OR deduct_heads_name LIKE 'E.S.I.' OR deduct_heads_name LIKE 'PROF. TAX' OR deduct_heads_name LIKE 'L.W.F.') and comp_id ='".$comp_id."' GROUP by deduct_heads_name ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
      
    }
    function getDeptId($dept,$comp_id){
        $sql = "select mast_dept_id from mast_dept WHERE mast_dept_name Like '".$dept."' and comp_id = '".$comp_id."'  ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row['mast_dept_id'];
        
    }
    function getQualifId($qualif,$comp_id){
        $sql = "select mast_qualif_id from mast_qualif WHERE mast_qualif_name Like '".$qualif."' and comp_id = '".$comp_id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row['mast_qualif_id'];
        
    }
    function getDesgIdNew($desg_name,$comp_id){
        $sql = "select mast_desg_id from mast_desg WHERE mast_desg_name Like '".$desg_name."' and comp_id = '".$comp_id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row['mast_desg_id'];
        
    }
    function getBankId($bank,$comp_id){
        $sql = "select mast_bank_id from mast_bank WHERE bank_name Like '".$bank."' and comp_id = '".$comp_id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row['mast_bank_id'];
        
    }
 function insertCSVWiseEmployee(
    $comp_id, $user_id, $user_name, $password, 
    $first_name, $middle_name, $last_name, 
    $gender, $bdate, $joindate, $due_date, $leftdate, 
    $pfdate, $pfno, $esistatus, $esino,
    $dept_id, $category_id, $qualif_id, 
    $mobile_no, $pay_mode, $bank_id, $bankacno, 
    $comp_ticket_no, $panno, $adharno, $uan, 
    $married_status, $emp_add1, $desg_id, $clientid
) {
    // SQL query
   $sql = "INSERT INTO `employee` (
       `comp_id`, `user_id`, `user_name`, `password`, `first_name`, `middle_name`, `last_name`,
       `gender`, `bdate`, `joindate`, `due_date`, `leftdate`, `pfdate`, `pfno`, `esistatus`, `esino`,
       `dept_id`, `category_id`, `qualif_id`, `mobile_no`, `pay_mode`, `bank_id`, `bankacno`, `comp_ticket_no`, `panno`,
       `adharno`, `uan`, `married_status`, `emp_add1`, `desg_id`, `client_id`,`role`
   ) VALUES (
       '$comp_id', '$user_id', '$user_name', '$password', '$first_name', '$middle_name', '$last_name',
       '$gender', '$bdate', '$joindate', '$due_date', '$leftdate', '$pfdate', '$pfno', '$esistatus', '$esino',
       '$dept_id', '$category_id', '$qualif_id', '$mobile_no', '$pay_mode', '$bank_id', '$bankacno', '$comp_ticket_no', '$panno',
       '$adharno', '$uan', '$married_status', '$emp_add1', '$desg_id', '$clientid','5'
   )";

    // Debugging: Print the SQL query to ensure it's correctly formatted
    //echo $sql . "<br>";

    // Assuming $this->connection is a valid PDO connection
    try {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $this->connection->lastInsertId();
    } catch (PDOException $e) {
        // Error handling
       // echo "Error: " . $e->getMessage() . "<br>";
       echo "0";
        return false;
    }
}



    function insertCSVWiseDeduct($comp_id,$empid,$user_id,$pfid,$esiid,$proftaxid,$lwfid){
        $sql = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$pfid."',7,0) ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
		
		$sql2 = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$esiid."',7,0) ";
        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->execute();
		
		$sql3 = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$proftaxid."',7,0) ";
        $stmt3 = $this->connection->prepare($sql3);
        $stmt3->execute();
		
		$sql4 = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$lwfid."',7,0) ";
        $stmt4 = $this->connection->prepare($sql4);
        $stmt4->execute();
	
	}
    function getIncomeEmpDetails($comp_id,$user_id,$clint_id){
      echo  $setSql= "select 'Emp_id','first_name','middle_name','last_name','Std_amt','Remark' union all SELECT emp_id as 'Employee ID',`first_name` as 'First Name',`middle_name` as 'Middle Name',`last_name` as 'Last Name','0','0' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";
        //$setSql= " SELECT distinct emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";
        $stmt = $this->connection->prepare($setSql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
	
	}
    function getIncomeEmpDetails_import($comp_id,$user_id,$clint_id){
        $setSql= "SELECT emp_id as 'Employee ID',`first_name` as 'First Name',`middle_name` as 'Middle Name',`last_name` as 'Last Name','0','0' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' order by first_name,last_name";
        //$setSql= " SELECT distinct emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";
        $stmt = $this->connection->prepare($setSql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
	
	}
 
    function countEmpIncome($emapData0,$incomeid){
        $setSql= "SELECT * FROM `emp_income` WHERE `emp_id`='".$emapData0."' AND `head_id`='".$incomeid."' ";
        $stmt = $this->connection->prepare($setSql);
        $stmt->execute();
        $row = $stmt->rowCount();
        return $row;
	
	}
    function updateEmpIncome($std_amt,$ct,$remark,$emp_id,$incomeid,$comp_id,$user_id,$countch){
        if($countch>0) {
            $sql = "update emp_income set std_amt = '$std_amt',`calc_type`='$ct',remark='$remark' where `emp_id`='$emp_id' AND `head_id`='$incomeid' ";
        }else{								
            $sql = "INSERT INTO `emp_income`(`comp_id`, `user_id`,`emp_id`,`head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`) VALUES ('$comp_id','$user_id','$emp_id','$incomeid','$ct','$std_amt','$remark',Now(),Now())";
        }
       // echo "<br>".$sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->rowCount();
        return $row;
	
	}
    function countEmpDeduct($emapData0,$deductid){
      $setSql= "SELECT * FROM `emp_deduct` WHERE `emp_id`='".$emapData0."' AND `head_id`='".$deductid."' ";
        $stmt = $this->connection->prepare($setSql);
        $stmt->execute();
        $row = $stmt->rowCount();
        return $row;
	
	}
    function updateEmpDeduct($emapData4,$ct,$emapData5,$emapData0,$incomeid,$comp_id,$user_id,$countch){
        if($countch>0) {
            $sql = "update emp_deduct set std_amt = '$emapData4',`calc_type`='$ct',remark='$emapData5' where `emp_id`='$emapData0' AND `head_id`='$incomeid' ";
        }else{								
            $sql = "INSERT INTO `emp_deduct`(`comp_id`, `user_id`,`emp_id`,`head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`) VALUES ('$comp_id','$user_id','$emapData0','$incomeid','$ct','$emapData4','$emapData5',Now(),Now())";
        }
       // echo "<br>".$sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->rowCount();
        return $row;
	
	}
    function getEmpByCompId($comp_id,$user_id,$clint_id){
        $sql = "select 'Employee_ID','Last Name','First Name','Middle Name','Std_amt','Remark' union all SELECT distinct emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name','0','0' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
        
    }
    function getEmpImportDetails($comp_id){
      //   $sql = "SELECT emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name`  as 'Last Name',emp.`gender` as Gender,emp.`bdate` as 'Birth Date',emp.`joindate` as 'Join Date',emp.`due_date` as 'Due Date',emp.`leftdate` as 'Left Date',emp.`pfdate` as 'PF Date',emp.`pfno` as 'PF No','Y' as 'ESI Status' ,`esino` as  'ESI No', mde.mast_dept_name as 'Department',mq.mast_qualif_name as 'Qualification', emp.`mobile_no` as 'Phone No',emp.`pay_mode`  as 'Pay Mode' ,emp.`bank_id`as 'Bank Name',emp.`bankacno`  as 'Bank Ac no',emp.`comp_ticket_no`  as 'Comp Ticket No',emp.`panno`  as 'PAN no',emp.`adharno`  as 'Adhar No',emp.`uan`  as 'UAN',emp.`married_status` as 'Married Status' ,emp_add1 as 'Employee Address',emp.desg_id as 'Designation' FROM `employee` emp,mast_client mc,mast_desg md,`mast_dept` mde,mast_bank mb,mast_paycode mp,mast_qualif mq,mast_location ml WHERE 1=2";
         //emp.client_id=mc.mast_client_id AND emp.desg_id=md.mast_desg_id  AND emp.`comp_id`='".$comp_id."' 
    
      //  $sql = "SELECT emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name`  as 'Last Name',emp.`gender` as Gender,emp.`bdate` as 'Birth Date',emp.`joindate` as 'Join Date',emp.`due_date` as 'Due Date',emp.`leftdate` as 'Left Date',emp.`pfdate` as 'PF Date',emp.`pfno` as 'PF No','Y' as 'ESI Status' ,`esino` as  'ESI No', mde.mast_dept_name as 'Department',mq.mast_qualif_name as 'Qualification', emp.`mobile_no` as 'Phone No',emp.`pay_mode`  as 'Pay Mode' ,emp.`bank_id`as 'Bank Name',emp.`bankacno`  as 'Bank Ac no',emp.`comp_ticket_no`  as 'Comp Ticket No',emp.`panno`  as 'PAN no',emp.`adharno`  as 'Adhar No',emp.`uan`  as 'UAN',emp.`married_status` as 'Married Status' ,emp_add1 as 'Employee Address',emp.desg_id as 'Designation' FROM `employee` emp,mast_client mc,mast_desg md,`mast_dept` mde,mast_bank mb,mast_paycode mp,mast_qualif mq,mast_location ml WHERE emp.client_id=mc.mast_client_id AND emp.desg_id=md.mast_desg_id AND mde.mast_dept_id=emp.dept_id AND emp.`qualif_id`=mq.mast_qualif_id AND emp.`bank_id`=mb.mast_bank_id AND emp.`loc_id`=ml.mast_location_id AND emp.`paycode_id`= mp.mast_paycode_id  AND emp.`comp_id`='".$comp_id."' ";
     $sql = "SELECT 
            emp.`first_name` as 'First Name',
            emp.`middle_name` as 'Middle Name',
            emp.`first_name` as 'First Name',
            emp.`last_name` as 'Last Name',
            emp.`gender` as Gender,
            emp.`bdate` as 'Birth Date',
            emp.`joindate` as 'Join Date',
            emp.`due_date` as 'Due Date',
            emp.`leftdate` as 'Left Date',
            emp.`pfdate` as 'PF Date',
            emp.`pfno` as 'PF No',
            'Y' as 'ESI Status',
            `esino` as 'ESI No',
            mde.mast_dept_name as 'Department',
            mq.mast_qualif_name as 'Qualification',
            emp.`mobile_no` as 'Phone No',
            emp.`pay_mode` as 'Pay Mode',
            emp.`bank_id` as 'Bank Name',
            emp.`bankacno` as 'Bank Ac no',
            emp.`comp_ticket_no` as 'Comp Ticket No',
            emp.`panno` as 'PAN no',
            emp.`adharno` as 'Adhar No',
            emp.`uan` as 'UAN',
            emp.`married_status` as 'Married Status',
            emp.`emp_add1` as 'Employee Address',
            emp.desg_id as 'Designation',
            mcg.mast_category_name as 'Category Name'
        FROM 
            `employee` emp
        JOIN
            mast_client mc ON emp.client_id = mc.mast_client_id
        JOIN
            mast_desg md ON emp.desg_id = md.mast_desg_id
        JOIN
            mast_dept mde ON emp.dept_id = mde.mast_dept_id
        JOIN
            mast_bank mb ON emp.bank_id = mb.mast_bank_id
        JOIN
            mast_paycode mp ON emp.paycode_id = mp.mast_paycode_id
        JOIN
            mast_qualif mq ON emp.qualif_id = mq.mast_qualif_id
        JOIN
            mast_location ml ON emp.loc_id = ml.mast_location_id
        JOIN
            mast_category mcg ON emp.category_id = mcg.mast_category_id
        WHERE 
            emp.comp_id = :comp_id";

              $sql=   "select 'First Name','Middle Name','Last Name','Gender','Birth Date','Join Date','Due Date','Left Date','PF Date','PF No','ESI Status' ,'ESI No','Department','Category Name','Qualification', 'Phone No','Pay Mode' ,'Bank Name','Bank Ac no','Comp Ticket No','PAN no','Adhar No','UAN','Married Status' ,'Employee Address','Designation' FROM `employee`where emp_id = 1";
                 
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }

    function bank_excel($client_id,$frdt,$tab_emp){
         $sql= "SELECT te.netsalary as netsalary ,te.bankacno,trim(mb.ifsc_code) as ifsc_code,te.`bank_id` ,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'empname' FROM $tab_emp te inner join employee e on e.emp_id = te.emp_id inner JOIN mast_bank mb on te.bank_id = mb.mast_bank_id where te.client_id in (".$client_id.")  and sal_month = '$frdt' and te.netsalary >0   group by te.emp_id ORDER BY te.emp_id, te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC"; 
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }

    function getEsicode($emp,$comp_id,$clientid){
        if($emp=='Parent')
        {
        $sql = "select distinct esicode from mast_client where comp_id = '$comp_id' and esicode!= '.' order by esicode";	}
        else{
        $sql = "select distinct esicode from mast_client where mast_client_id = '$clientid' and esicode!= '.' order by esicode";	
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }

    function getEsicodeEmp($emp,$comp_id,$clientid,$tab_empded,$tab_days,$esicode){
        if($emp=='Parent')
		{ 
	        $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$esicode."' and t1.amount>0  AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."')  ";
	
		}
		else{
		$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$esicode."' and  t5.mast_client_id='".$clientid."' and t1.amount>0  AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."') ";
		
		}
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }
    function getCountESICode($comp_id){
        $sql = "select distinct esicode from mast_client where comp_id =$comp_id order by esicode";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $row;
        
    }
    function getESICode1($comp_id,$tab_empded,$tab_emp,$frdt){
        $sql = "SELECT d.esicode,te.client_id,d.client_name,sum(t.std_amt) as std_amt,sum(t.amount) as amount,sum(te.gross_salary) as gross_salary ,sum(t.employer_contri_1) as employer,count(t.emp_id) as cnt  FROM $tab_empded t  inner join $tab_emp te on te.emp_id = t.emp_id  and t.sal_month = te.sal_month inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id inner join mast_client d on te.client_id = d.mast_client_id WHERE md.`deduct_heads_name` LIKE '%E.S.I.%' and d.esicode = '".$esicode1['esicode']."' and md.comp_id =$comp_id ";
		
        $sql .=" and t.sal_month ='$frdt' and t.amount >0 ";		
        $sql .=" group by te.client_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $row;
        
    }
    function getESICode2($tab_emp,$frdt,$tab_empded,$comp_id){
        $sql = "select td.sal_month,c.client_name,c.mast_client_id,c.client_name,td.emp_id,  e.first_name,e.middle_name,e.last_name,td.gross_salary from $tab_emp td inner join employee e on td.emp_id = e.emp_id inner join mast_client c on td.client_id = c.mast_client_id where  td.sal_month = '$frdt' and td.netsalary >0 and  td.comp_id= '$comp_id'   and td.emp_id not in (select emp_id from $tab_empded where sal_month = '$frdt' and amount>0 and head_id in (select md.mast_deduct_heads_id from mast_deduct_heads md where md.deduct_heads_name like '%E.S.I.%'and  comp_id= '$comp_id'  ) ) order by td.sal_month,td.client_id,td.emp_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $row;
        
    }
    function getWithoutESI1($comp_id,$tab_empded,$tab_emp,$frdt,$todt,$clientid){
        $sql = "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.esino,sum(te.payabledays) as payabledays, sum(tdd.std_amt) as wages,round(sum(tdd.amount),0) as employee_contri , round(sum(tdd.std_amt)/sum(te.payabledays),2) as daiily_wages,e.leftdate,e.joindate  FROM $tab_empded tdd inner join employee e on e.emp_id = tdd.emp_id inner join $tab_emp te on te.sal_month = tdd.sal_month and te.emp_id=tdd.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = tdd.head_id   WHERE tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and te.client_id = $clientid and md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id group by tdd.emp_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $row;
        
    }
    function getWithoutESI2($comp_id,$tab_empded,$tab_emp,$frdt,$todt,$clientid){
        $sql = "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.esino,sum(te.payabledays) as payabledays, sum(tdd.std_amt) as wages,round(sum(tdd.amount),0) as employee_contri , round(sum(tdd.std_amt)/sum(te.payabledays),2) as daiily_wages,e.leftdate,e.joindate  FROM $tab_empded tdd inner join employee e on e.emp_id = tdd.emp_id inner join $tab_emp te on te.sal_month = tdd.sal_month and te.emp_id=tdd.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = tdd.head_id   WHERE tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and te.client_id = $clientid and md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id group by te.client_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row;
        
    }
    function ESIStatement($tab_empded,$tab_emp,$comp_id,$frdt){
        $sql = "SELECT mc.esicode, '1' as  SNO,te.esino,concat(e.first_name,' ',e.middle_name,' ',e.last_name) as name,te.payabledays as Days, tdd.std_amt as wages ,tdd.amount as EE_Con, tdd.employer_contri_1 as ER_Con,tdd.employer_contri_1+tdd.amount as Total  FROM $tab_empded tdd inner join employee e on e.emp_id = tdd.emp_id inner join $tab_emp te on te.sal_month = tdd.sal_month and te.emp_id=tdd.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = tdd.head_id inner join mast_client mc on te.client_id=mc.mast_client_id  WHERE tdd.sal_month = '$frdt' and md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id  and tdd.amount >0 order by mc.esicode,te.esino";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $row;
        
    }
    function professionTax($emp,$tab_empded,$clintid,$comp_id,$month,$frdt,$todt){
        if($emp=='Parent')
        {
        $sql .= "SELECT t1.amount,t2.first_name,t2.middle_name,t2.last_name,t2.emp_id FROM $tab_empded t1 inner join employee t2 on t2.emp_id = t1.emp_id  inner join  mast_client t3 on t3.mast_client_id = t2.client_id where t3.parentid = '".$clintid."' and  head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%Prof. Tax%'  and comp_id ='".$comp_id."') ";
        }
        else{
        $sql .= "SELECT t1.amount,t2.first_name,t2.middle_name,t2.last_name,t2.emp_id FROM $tab_empded t1 inner join employee t2 on t2.emp_id = t1.emp_id  where t2.client_id = '". $clintid."' and  head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%Prof. Tax%'  and comp_id ='".$comp_id."') ";
        
        }
        
        if($month=='current'){
        $sql .= " AND t1.sal_month='".$frdt."' ";}
        else{
        $sql .= " AND t1.sal_month>='".$frdt."' AND t1.sal_month<='".$todt."'";
        }
        
        $sql .="order by t2.last_name,t2.first_name,t2.middle_name";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $row;
        
    }
    function getptSummary($comp_id,$tab_empded,$tab_emp,$frdt){
        $sql = "SELECT mc.client_name, sum(te.gross_salary) as ssalary ,sum(tdd.amount) as amount,tdd.amount as slab ,count(tdd.amount) as count,e.gender FROM  $tab_empded tdd inner join employee e on tdd.emp_id = e.emp_id inner join $tab_emp te on tdd.sal_month = te.sal_month and tdd.emp_id = te.emp_id  inner join mast_client mc on mc.mast_client_id = te.client_id where head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%Prof. Tax%'  and comp_id =$comp_id) and te.sal_month = '$frdt' group by te.client_id ,e.gender,tdd.amount ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
        
    }
    function getlwfStatement($emp,$tab_empded,$tab_days,$tab_emp,$clientid,$comp_id,$frdt){
        if($emp=='Parent')
        {
        $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1 inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month= t1.sal_month  inner join mast_client t3 on t4.client_id= t3.mast_client_id  where  t1.amount > 0 and t3.parentid='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%L.W.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
        }
        else{
        $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1  inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month = t1.sal_month where   t1.amount > 0 and  t4.client_id='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%L.W.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
        
        }
        
        $sql .= " AND t1.sal_month='".$frdt."' ";
        
        $sql .="order by t4.emp_id,t2.first_name,t2.middle_name,t2.last_name";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
        
    }
    function getlwfSummary($tab_empded,$tab_emp,$frdt,$clientid){
        $sql = "SELECT hdd.amount,count(hdd.emp_id)as cnt,sum(hdd.amount) as amount1,sum(employer_contri_1) as employer_contri_1 FROM $tab_empded hdd inner join $tab_emp he on  he.emp_id = hdd.emp_id and he.sal_month = hdd.sal_month   WHERE (hdd.`head_id` = 4 or hdd.head_id = 23 )and hdd.sal_month = '$frdt' and he.client_id = '".$clientid."' and hdd.amount >0  group by hdd.amount";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
        
    }
    function getAdvancesList($emp,$advtype,$tab_adv,$clientid,$comp_id,$month,$frdt,$todt){
        if($emp=='Parent')
        {
        if ($advtype ==0)
        {
        $sql = "SELECT t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t3.parentId = '".$clientid."'  and t2.comp_id ='".$comp_id."'  and t1.amount >0  ";
        
        }
        else{
        $sql = "SELECT  t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t3.parentId = '".$clientid."' and t1.head_id = '".$advtype."' and   t2.comp_id ='".$comp_id."'  and t1.amount >0";}
        }
        else
        {
        if ($advtype ==0)
        {
        $sql = "SELECT  t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t2.client_id = '".$clientid."'  and t2.comp_id ='".$comp_id."'  and t1.amount >0  ";
        
        }
        else{
        $sql = "SELECT  t1.emp_id,t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name,t1.emp_id from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id  inner join mast_client t3 on t3.mast_client_id= t2.client_id where  t2.client_id = '".$clientid."' and t1.head_id = '".$advtype."' and   t2.comp_id ='".$comp_id."'  and t1.amount >0    ";
        }
        }
        if($month=='current'){
        $sql .= " AND t1.sal_month='".$frdt."' ";}
        else{
        $sql .= " AND t1.sal_month>='".$frdt."' AND t1.sal_month<='".$todt."'";
        }
        
        $sql.=" order by t1.head_id,t2.emp_id,t2.first_name,t2.middle_name,t2.last_name ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
        
    }
    function getadvanceTypeName($advtype){
        $sql = "select advance_type_name from mast_advance_type where mast_advance_type_id = '$advtype'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
         return $row;
        
    }
    function getadvanceTypeName1($advid){
        $sql = "select t1.*,t2.advance_type_name from emp_advnacen t1 inner join mast_advance_type t2 on t1.advance_type_id = t2.mast_advance_type_id where t1.emp_advnacen_id = '".$advid."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
         return $row;
        
    }
    function getadvanceTypeName2($empId,$frdt,$emp_advance_id){
        $sql = "select sal_month,amount  from hist_advance t1 inner join emp_advnacen ea on ea.emp_advnacen_id = t1.emp_advance_id where t1.emp_id = '".$empId."' and t1.sal_month<= '$frdt' and  t1.emp_advance_id = '".$emp_advance_id."' order by sal_month";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
        
    }
    function getadvdates($emp_id){
		$sql = "select distinct  date from emp_advnacen where emp_id='$emp_id' order by date desc  "; 
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
	}
	function empAdvanceList($advdate1,$emp){
		$sql = "select t1.*,t2.first_name,t2.middle_name,t2.last_name,t1.emp_id from emp_advnacen t1 inner join employee t2 on t2.emp_id= t1.emp_id  inner join mast_client t3 on t3.mast_client_id= t2.client_id where t1.date ='$advdate1' and t1.emp_id = $emp  ";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
         return $row;
	}
	function getHistAdvance($emp_advnacen_id){
    	$sql  = "SELECT * FROM `hist_advance` WHERE emp_advance_id = ".$emp_advnacen_id." order by sal_month ";
    	$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
	}
	function getTranAdvance($emp_advnacen_id){
    	$sql  = "SELECT * FROM `tran_advance` WHERE emp_advance_id = ".$emp_advnacen_id." order by sal_month ";
    	$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
	}
	function getSocietyLetter($bank_id,$tab_deduct,$frdt){
    	$sql = "select tdd.emp_id,tdd.amount,e.first_name,e.middle_name,e.last_name from $tab_deduct tdd inner join employee e on tdd.emp_id = e.emp_id  where tdd.bank_id='".$bank_id."'  and tdd.sal_month = '$frdt' and tdd.amount > 0  ORDER BY e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
    	$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
         return $row;
	}
	function getSocietyLetter2($bank_id,$tab_deduct,$frdt){
    	$sql = "select sum(tdd.amount) as amount from $tab_deduct tdd  where  bank_id='".$bank_id."'   and tdd.sal_month = '$frdt' ";
    	$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
         return $row;
	}
    function convertNumberTowords($number)
    {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
        " " . $digits[$counter] . $plural . " " . $hundred
        :
        $words[floor($number / 10) * 10]
        . " " . $words[$number % 10] . " "
        . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
        "." . $words[$point / 10] . " " . 
        $words[$point = $point % 10] : '';
        return  $result . " " . $points;
    }
    public function getEmployeeDetailsByClientId($clientid){
        $sql ="select emp.first_name,emp.middle_name,emp.last_name,emp.gender,emp.emp_add1,emp.pin_code,emp.emp_id,emp.joindate,emp.leftdate from employee emp	where emp.client_id='$clientid' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
	}
	function pfDed($empId){
		$sql ="select std_amt,head_id from emp_income where emp_id='".$empId."' and head_id in(5,6) group by head_id";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $res1 = $stmt->fetchAll();
		$basic="";
		$orda="";
		foreach($res1 as $row)
		{			
				 if($row['head_id']==5){
					$basic = $row['std_amt'];
				} if($row['head_id']==6){
					$orda = $row['std_amt'];
				}				
		}
		 if($orda !=""){
			 $da = round(($basic + $orda)*12/100);
		}else{
			$da=0;
		}
		
		return $da;
		
	}
	function ptDed($emp){
		$sql ="select head_id from emp_deduct where emp_id ='".$emp."' and head_id='3'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row['head_id'];
        
	}
	function displayOtherFieldsData($selname,$table,$prid,$tableprid,$comp_id,$cl_id)
    { 
	     $sql = "SELECT e.emp_id,e.first_name as fn,e.middle_name as mn,e.last_name as ln,".$selname.",".$prid.",bankacno FROM employee e inner join $table on e.".$prid."=".$table.".".$tableprid."  where (e.job_status!='L'   and e.job_status !='E'  and e.job_status !='R' ) and  e.comp_id='".$comp_id."' and client_id = '$cl_id' order by e.emp_id"; 
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
		$row = $stmt->fetchAll();
		return $row;
	}
	function gettabdataOther($table,$comp_id)
	{
	     $sqldataall = "select * from ".$table." where    comp_id='".$comp_id."' ";
		$stmt = $this->connection->prepare($sqldataall);
        $stmt->execute();
		$row = $stmt->fetchAll();
		return $row;
	}
	function updateEmpOtherData($fld,$fldid,$emp_id,$comp_id)
	{
	    $sqldataall = "update employee set $fld='".$fldid."' where emp_id='".$emp_id."'  and  comp_id='".$comp_id."'";
		$stmt = $this->connection->prepare($sqldataall);
        $stmt->execute();
	    return $stmt;
	}
	function updateBankEmpOtherData($fld,$fldid,$bank_no,$emp_id,$comp_id)
	{
	    $sqldataall = "update employee set $fld='".$fldid."', bankacno='".$bank_no."' where emp_id='".$emp_id."'  and  comp_id='".$comp_id."'  ";
		$stmt = $this->connection->prepare($sqldataall);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistEmp($comp_id)
	{
	    $sql = "insert into  hist_employee select * from tran_employee where comp_id = '$comp_id'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistDays($comp_id)
	{
	    $sql = "insert into  hist_days  ( `emp_id`, `client_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `wagediff`, `Allow_arrears`, `Ot_arrears`, `invalid`, `comp_id`, `user_id`) select  `emp_id`, `client_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `wagediff`, `Allow_arrears`, `Ot_arrears`, `invalid`, `comp_id`, `user_id`  from tran_days where comp_id = '".$comp_id."'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistIncome($comp_id)
	{
	    $sql = "insert into hist_income ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`) select  t1.emp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount from tran_income t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id' ";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistDeduct($comp_id)
	{
	    $sql = "insert into hist_deduct  ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `employer_contri_1`, `employer_contri_2`, `bank_id`)select t1.emp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount, t1.employer_contri_1, t1.employer_contri_2, t1.bank_id from tran_deduct t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistAdvance($comp_id)
	{
	    $sql = "insert into hist_advance ( `emp_id`, `client_id`, `comp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `paid_amt`, `emp_advance_id`)select  t1.emp_id, t1.client_id, t1.comp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount, t1.paid_amt, t1.emp_advance_id from tran_advance t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function updateEmployeeMonthC($comp_id)
	{
	    $sql = "update employee e inner join tran_employee te on te.emp_id = e.emp_id set e.esistatus = te.esistatus where  e.comp_id = '$comp_id' ";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function deleteTranTables($comp_id,$table)
	{
	    $sql = "DELETE FROM $table  WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function deleteTranDays($comp_id)
	{
	    $sql = "DELETE FROM tran_days WHERE comp_id = '".$comp_id. "'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function UpdateMastClients($comp_id)
	{
	    $sql = "update mast_client set current_month =last_day(DATE_ADD( current_month, INTERVAL 1 month )) WHERE comp_id = '".$comp_id. "'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistEmersonBill1214()
	{
	    $sql = "INSERT INTO `hist_emerson_bill1214`(`emp_id`, `sal_month`, `dept_id`, `desg_id`, `client_id`, `client_name`, `dept_name`, `desg_name`, `emp_name`, `payabledays_sal`, `othours_sal`, `otrate_sal`, `basic_sal`, `hra_sal`, `da_sal`, `supplli_allow_sal`, `other_allow_sal`, `super_skill_allow_sal`, `overtime_sal`, `gross_monthly_annex`, `basic_daily_annex`, `da_daily_annex`, `hra_daily_annex`, `super_skill_allow_daily_annex`, `supplli_allow_daily_annex`, `other_allow_daily_annex`, `total_a_annex`, `pf_annex`, `bonus_Annex`, `total_b_annex`, `esi_annex`, `lww_annex`, `lwf_annex`, `safety_annex`, `soap_annex`, `training_annex`, `total_c_annex`, `total_ABC_annex`, `tds_Annex`, `total_d_annex`, `rounded_annex`, `emp_cnt_annex`, `bill_rate_annex`, `ot_hours_annex`, `ot_rate_annex`, `ot_conv_annex`, `ot_days_annex`, `ot_days_percent_annex`, `payable_days_annex`, `tot_payable_days_annex`, `no_of_units_annex`, `servicecharges`, `supervisioncharges`, `amount_annex`, `sgst_annex`, `cgst_annex`, `igst_annex`, `tot_amount_annex`, `spl_allow_ip`, `pf_percent_ip`, `bonus_percent_ip`, `esi_percent_ip`, `lww_percent_ip`, `lwf_percent_ip`, `safetyapp_percent_ip`, `other_charges_percent_ip`, `trainingcharg_percent_ip`, `tds_percent_ip`, `monthlysup_ip`, `servicecharge_percent_ip`, `cgst_percent_ip`, `sgst_percent_ip`, `igst_percent_ip`, `db_adddate`) select  `emp_id`, `sal_month`, `dept_id`, `desg_id`, `client_id`, `client_name`, `dept_name`, `desg_name`, `emp_name`, `payabledays_sal`, `othours_sal`, `otrate_sal`, `basic_sal`, `hra_sal`, `da_sal`, `supplli_allow_sal`, `other_allow_sal`, `super_skill_allow_sal`, `overtime_sal`, `gross_monthly_annex`, `basic_daily_annex`, `da_daily_annex`, `hra_daily_annex`, `super_skill_allow_daily_annex`, `supplli_allow_daily_annex`, `other_allow_daily_annex`, `total_a_annex`, `pf_annex`, `bonus_Annex`, `total_b_annex`, `esi_annex`, `lww_annex`, `lwf_annex`, `safety_annex`, `soap_annex`, `training_annex`, `total_c_annex`, `total_ABC_annex`, `tds_Annex`, `total_d_annex`, `rounded_annex`, `emp_cnt_annex`, `bill_rate_annex`, `ot_hours_annex`, `ot_rate_annex`, `ot_conv_annex`, `ot_days_annex`, `ot_days_percent_annex`, `payable_days_annex`, `tot_payable_days_annex`, `no_of_units_annex`, `servicecharges`, `supervisioncharges`, `amount_annex`, `sgst_annex`, `cgst_annex`, `igst_annex`, `tot_amount_annex`, `spl_allow_ip`, `pf_percent_ip`, `bonus_percent_ip`, `esi_percent_ip`, `lww_percent_ip`, `lwf_percent_ip`, `safetyapp_percent_ip`, `other_charges_percent_ip`, `trainingcharg_percent_ip`, `tds_percent_ip`, `monthlysup_ip`, `servicecharge_percent_ip`, `cgst_percent_ip`, `sgst_percent_ip`, `igst_percent_ip`, `db_adddate` from tran_emerson_bill1214";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistEmersonBill15()
	{
	    $sql = "INSERT INTO `hist_emerson_bill15`(`emp_id`, `sal_month`, `dept_id`, `desg_id`, `client_id`, `client_name`, `dept_name`, `desg_name`, `emp_name`, `payabledays_sal`, `othours_sal`, `otrate_sal`, `basic_sal`, `hra_sal`, `da_sal`, `supplli_allow_sal`, `other_allow_sal`, `super_skill_allow_sal`, `overtime_sal`, `gross_monthly_annex`, `basic_daily_annex`, `da_daily_annex`, `hra_daily_annex`, `super_skill_allow_daily_annex`, `supplli_allow_daily_annex`, `other_allow_daily_annex`, `total_a_annex`, `pf_annex`, `bonus_Annex`, `total_b_annex`, `esi_annex`, `lww_annex`, `lwf_annex`, `safety_annex`, `soap_annex`, `training_annex`, `total_c_annex`, `total_ABC_annex`, `tds_Annex`, `total_d_annex`, `rounded_annex`, `emp_cnt_annex`, `bill_rate_annex`, `ot_hours_annex`, `ot_rate_annex`, `ot_conv_annex`, `ot_days_annex`, `ot_days_percent_annex`, `payable_days_annex`, `tot_payable_days_annex`, `no_of_units_annex`, `servicecharges`, `supervisioncharges`, `amount_annex`, `sgst_annex`, `cgst_annex`, `igst_annex`, `tot_amount_annex`, `spl_allow_ip`, `pf_percent_ip`, `bonus_percent_ip`, `esi_percent_ip`, `lww_percent_ip`, `lwf_percent_ip`, `safetyapp_percent_ip`, `other_charges_percent_ip`, `trainingcharg_percent_ip`, `tds_percent_ip`, `monthlysup_ip`, `servicecharge_percent_ip`, `cgst_percent_ip`, `sgst_percent_ip`, `igst_percent_ip`, `db_adddate`) select  `emp_id`, `sal_month`, `dept_id`, `desg_id`, `client_id`, `client_name`, `dept_name`, `desg_name`, `emp_name`, `payabledays_sal`, `othours_sal`, `otrate_sal`, `basic_sal`, `hra_sal`, `da_sal`, `supplli_allow_sal`, `other_allow_sal`, `super_skill_allow_sal`, `overtime_sal`, `gross_monthly_annex`, `basic_daily_annex`, `da_daily_annex`, `hra_daily_annex`, `super_skill_allow_daily_annex`, `supplli_allow_daily_annex`, `other_allow_daily_annex`, `total_a_annex`, `pf_annex`, `bonus_Annex`, `total_b_annex`, `esi_annex`, `lww_annex`, `lwf_annex`, `safety_annex`, `soap_annex`, `training_annex`, `total_c_annex`, `total_ABC_annex`, `tds_Annex`, `total_d_annex`, `rounded_annex`, `emp_cnt_annex`, `bill_rate_annex`, `ot_hours_annex`, `ot_rate_annex`, `ot_conv_annex`, `ot_days_annex`, `ot_days_percent_annex`, `payable_days_annex`, `tot_payable_days_annex`, `no_of_units_annex`, `servicecharges`, `supervisioncharges`, `amount_annex`, `sgst_annex`, `cgst_annex`, `igst_annex`, `tot_amount_annex`, `spl_allow_ip`, `pf_percent_ip`, `bonus_percent_ip`, `esi_percent_ip`, `lww_percent_ip`, `lwf_percent_ip`, `safetyapp_percent_ip`, `other_charges_percent_ip`, `trainingcharg_percent_ip`, `tds_percent_ip`, `monthlysup_ip`, `servicecharge_percent_ip`, `cgst_percent_ip`, `sgst_percent_ip`, `igst_percent_ip`, `db_adddate` from tran_emerson_bill15";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function insertHistEmersonBill16()
	{
	    $sql = "INSERT INTO `hist_emerson_bill16`(`emp_id`, `sal_month`, `dept_id`, `desg_id`, `client_id`, `client_name`, `dept_name`, `desg_name`, `emp_name`, `payabledays_sal`, `othours_sal`, `otrate_sal`, `basic_sal`, `hra_sal`, `da_sal`, `supplli_allow_sal`, `other_allow_sal`, `super_skill_allow_sal`, `overtime_sal`, `gross_monthly_annex`, `basic_daily_annex`, `da_daily_annex`, `hra_daily_annex`, `super_skill_allow_daily_annex`, `supplli_allow_daily_annex`, `other_allow_daily_annex`, `total_a_annex`, `pf_annex`, `bonus_Annex`, `total_b_annex`, `esi_annex`, `lww_annex`, `lwf_annex`, `safety_annex`, `soap_annex`, `training_annex`, `total_c_annex`, `total_ABC_annex`, `tds_Annex`, `total_d_annex`, `rounded_annex`, `emp_cnt_annex`, `bill_rate_annex`, `ot_hours_annex`, `ot_rate_annex`, `ot_conv_annex`, `ot_days_annex`, `ot_days_percent_annex`, `payable_days_annex`, `tot_payable_days_annex`, `no_of_units_annex`, `servicecharges`, `supervisioncharges`, `amount_annex`, `sgst_annex`, `cgst_annex`, `igst_annex`, `tot_amount_annex`, `spl_allow_ip`, `pf_percent_ip`, `bonus_percent_ip`, `esi_percent_ip`, `lww_percent_ip`, `lwf_percent_ip`, `safetyapp_percent_ip`, `other_charges_percent_ip`, `trainingcharg_percent_ip`, `tds_percent_ip`, `monthlysup_ip`, `servicecharge_percent_ip`, `cgst_percent_ip`, `sgst_percent_ip`, `igst_percent_ip`, `db_adddate`) select  `emp_id`, `sal_month`, `dept_id`, `desg_id`, `client_id`, `client_name`, `dept_name`, `desg_name`, `emp_name`, `payabledays_sal`, `othours_sal`, `otrate_sal`, `basic_sal`, `hra_sal`, `da_sal`, `supplli_allow_sal`, `other_allow_sal`, `super_skill_allow_sal`, `overtime_sal`, `gross_monthly_annex`, `basic_daily_annex`, `da_daily_annex`, `hra_daily_annex`, `super_skill_allow_daily_annex`, `supplli_allow_daily_annex`, `other_allow_daily_annex`, `total_a_annex`, `pf_annex`, `bonus_Annex`, `total_b_annex`, `esi_annex`, `lww_annex`, `lwf_annex`, `safety_annex`, `soap_annex`, `training_annex`, `total_c_annex`, `total_ABC_annex`, `tds_Annex`, `total_d_annex`, `rounded_annex`, `emp_cnt_annex`, `bill_rate_annex`, `ot_hours_annex`, `ot_rate_annex`, `ot_conv_annex`, `ot_days_annex`, `ot_days_percent_annex`, `payable_days_annex`, `tot_payable_days_annex`, `no_of_units_annex`, `servicecharges`, `supervisioncharges`, `amount_annex`, `sgst_annex`, `cgst_annex`, `igst_annex`, `tot_amount_annex`, `spl_allow_ip`, `pf_percent_ip`, `bonus_percent_ip`, `esi_percent_ip`, `lww_percent_ip`, `lwf_percent_ip`, `safetyapp_percent_ip`, `other_charges_percent_ip`, `trainingcharg_percent_ip`, `tds_percent_ip`, `monthlysup_ip`, `servicecharge_percent_ip`, `cgst_percent_ip`, `sgst_percent_ip`, `igst_percent_ip`, `db_adddate` from tran_emerson_bill16";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function updateEmpAdv($comp_id)
	{
	    $sql = "update emp_advnacen ea inner join ( select `emp_advance_id`,emp_id,sum(amount) as amt from hist_advance group by emp_id,emp_advance_id) hadv on hadv.emp_advance_id = ea.emp_advnacen_id set ea.received_amt = hadv.amt where comp_id = '$comp_id' ";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
	    return $stmt;
	}
	function getEmpAdv($comp_id)
	{
	    $sql = "select * from emp_advnacen where adv_amount<=received_amt and comp_id ='$comp_id'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
		$row = $stmt->fetchAll();
		return $row;
	}
	function getHistAdv($emp_advnacen_id)
	{
	    $sql = "select * from hist_advance where  emp_advance_id = '".$emp_advnacen_id."' order by `tradv_id` desc limit 1";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
		$row = $stmt->fetch();
		return $row;
	}
	function updateEmpadvnacen($sal_month,$emp_advnacen_id)
	{
	    $sql = "update emp_advnacen set closed_on = '".date('Y-m-d',strtotime($sal_month))."' where `emp_advnacen_id` = '".$emp_advnacen_id."'";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
		return $stmt;
	}
	function showLeaveEmployee($frdt,$todt,$clintid,$leave_type,$emp,$empid,$lmt){
     $sqlli = "select distinct he.emp_id,e.dept_id,e.desg_id,e.first_name,e.middle_name,e.last_name,e.leftdate,e.job_status,e.joindate from hist_employee he inner join employee e on e.emp_id = he.emp_id  where he.client_id=$clintid and he.sal_month>= '$frdt' and he.sal_month <= '$todt'  union  select distinct he.emp_id,e.dept_id,e.desg_id,e.first_name,e.middle_name,e.last_name,e.leftdate,e.job_status,e.joindate from tran_employee he inner join employee e on e.emp_id = he.emp_id  where he.client_id=$clintid and he.sal_month>= '$frdt' and he.sal_month <= '$todt' limit $lmt";
     $stmt = $this->connection->prepare($sqlli);
     $stmt->execute();
     $row[0] = $stmt->fetchAll();
     $row[1] = $stmt->rowCount();
     return $row;
		
	}
	function getCalculated($calculationfrm,$calculationto,$emp,$clintid)
	{
     $sql ="select sum(present+sl+additional) as present from hist_days where emp_id =$emp and sal_month between '$calculationfrm' and '$calculationto' and client_id='$clintid'";
	 $stmt = $this->connection->prepare($sql);
	 $stmt->execute(array('calfrm'=>$calculationfrm,'calto'=>$calculationto,'emp'=>$emp,'clintid'=>$clintid));
	 $res = $stmt->fetch();
	 return $res['present'];
   }
   function getCalculated_curr($calculationfrm,$calculationto,$emp,$clintid)
   {
	  $sql ="select sum(present+sl+additional) as present from tran_days where emp_id =:emp and sal_month between :calfrm and :calto  and client_id=:clintid";
	  $stmt = $this->connection->prepare($sql);
  	  $stmt->execute(array('calfrm'=>$calculationfrm,'calto'=>$calculationto,'emp'=>$emp,'clintid'=>$clintid));
	  $res = $stmt->fetch();
	  return $res['present'];
   }
   function getAmountForEncashmentNoLeftEmp($empid,$salmonth,$compid,$tab,$tab_emp,$clintid,$calc_month)
   {
       	$sql = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM $tab hi inner JOIN $tab_emp he on hi.emp_id =he.emp_id and hi.sal_month =he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$calc_month' and hi.calc_type in (1,2,3,4,5,14)";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
		$row = $stmt->fetch();
		return $row;
	
   }
    function getAmountForEncashmentLeftEmp($empid,$frdt,$todt)
    {
        $sql1 = "select sal_month  from hist_employee where emp_id = $empid and sal_month >= '$frdt' and  sal_month <='$todt' and gross_salary >0 order by sal_month desc  limit 1";
        $stmt = $this->connection->prepare($sql1);
        $stmt->execute();
		$row = $stmt->fetch();
        $sal_month = $row['sal_month'];
        $calc_type = "gross";
        if ($calc_type =="gross"){ 
        $sql = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM hist_income hi inner JOIN hist_employee he on hi.emp_id =he.emp_id and hi.sal_month =  he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$sal_month' and hi.calc_type in (1,2,3,4,5,14)";
        }
        else{
        $sql = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM $tab hi inner JOIN $tab_emp he on hi.emp_id =he.emp_id and hi.sal_month =he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$sal_month' and hi.head_id in (select mast_income_heads_id from mast_income_heads where (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = $compid )";
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
		$row1 = $stmt->fetch();
		return $row1;
    
    }
    function getOB($emp,$clintid,$leave_type,$frdt,$todt)
    {
        $sql = "select cb from leave_details where client_id=:client and leave_type=:type and emp_id=:emp  order by to_date desc limit 1 ";	
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('client'=>$clintid,'type'=>$leave_type,'emp'=>$emp));
        $row = $stmt->fetch();
        if($row['cb'] ==""){
        $ob = 0;
        }else{
        $ob = $row['cb'];
        }
        return $ob;
    }
    function getDetailsFromLDays($emp,$clintid,$leave_type,$frdt,$todt)
    {
        $type =$leave_type;
        $type1="";
        if($type=="4" || $type=="1"){
        $type1 = 'pl';
        }else if($type=="5" || $type=="2"){
        $type1 = 'cl';
        }else if($type=="6" || $type=="3" ){
        $type1 = 'sl';
        }else{
        $type1 = '';
        }
        if($type1 !=""){
        $sql = "select sum($type1) as sumt,sum(present) as presentsum from hist_days where client_id=:client and emp_id=:emp and sal_month between :frdt and :todt";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('client'=>$clintid,'emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt));
        $row = $stmt->fetch();
        }else{
        $row =0;
        }
        return $row;
    }
    function getDetailsFromLDays_curr($emp,$clintid,$leave_type,$frdt,$todt)
    {
        $type =$leave_type;
        $type1="";
        if($type=="4" || $type=="1"){
        $type1 = 'pl';
        }else if($type=="5" || $type=="2"){
        $type1 = 'cl';
        }else if($type=="6" || $type=="3" ){
        $type1 = 'sl';
        }else{
        $type1 = '';
        }
        if($type1 !=""){
        $sql = "select $type1 as sumt,sum(present) as presentsum from tran_days where client_id=:client and emp_id=:emp and sal_month between :frdt and :todt";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('client'=>$clintid,'emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt));
        $row = $stmt->fetch();
        }else{
        $row =0;
        }
        return $row;
    }
    function checkEncashment($frdt,$todt,$emp,$client,$leavetype)
    {
        $sql = "SELECT * from leave_details where from_date=:frdt and to_date=:todt and emp_id=:emp and client_id=:client and leave_type=:leavetype";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt,'client'=>$client,'leavetype'=>$leavetype));
        $row =$stmt->fetch();
        return $row;
    }
    function checkEncashmentRow($frdt,$todt,$emp,$client,$leavetype)
    { 
        $sql = "SELECT * from leave_details where from_date=:frdt and to_date=:todt and emp_id=:emp and client_id=:client and leave_type=:leavetype";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt,'client'=>$client,'leavetype'=>$leavetype));
        $row =$stmt->fetch();
        return $row;
    
    }
    function getOpeningTypeDate($client,$leavetype)
    {
        $sql = "select from_date,to_date from emp_leave where client_id=:client and leave_type=:type";	
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('client'=>$client,'type'=>$leavetype));
        $row = $stmt->fetch();
        return $row;
    }
    function getBankDetails($empid,$clientid)
    {
		$sql = "select * from employee where emp_id=:empid ";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('empid'=>$empid));
		return $row = $stmt->fetch();
	}
    function updateEncashment($emp,$preday,$obday,$earned,$enjoyed,$balance,$encashed,$rate,$amount,$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid,$payment_date)
    { 
        $sql = "update leave_details set bank_id=:bankid,bankacno=:bno,pay_mode=:paymode,present=:pres,ob=:ob,earned=:earn,enjoyed=:enjoy,balanced=:balance,encashed=:encash,rate=:rate,amount=:amount,comp_id=:comp,payment_date =:pay_date, db_update_date=now() where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type=:ltype ";	
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('emp'=>$emp,'pres'=>$preday,'ob'=>$obday,'earn'=>$earned,'enjoy'=>$enjoyed,'balance'=>$balance,'encash'=>$encashed,'rate'=>$rate,'amount'=>$amount,'bankid'=>$bid,'bno'=>$bankacno,'paymode'=>$paymode,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt,'comp'=>$compid,'pay_date'=>$payment_date));	
        $sql = "update leave_details set cb = balanced- encashed  where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type_id=:ltype";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('emp'=>$emp,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt));	
    }
    function insertEncashment($emp,$preday,$obday,$earned,$enjoyed,$balance,$encashed,$rate,$amount,$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid,$payment_date)
    {
    	 $slq1 ="update emp_leave el  set el.encashed=:encash where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type_id=:ltype";
    	$stmt1 = $this->connection->prepare($slq1);
    	$stmt1->execute(array('encash'=>$encashed,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt,'emp'=>$emp));
    	$sql = "insert into  leave_details(emp_id,client_id,bank_id,bankacno,pay_mode,from_date,to_date,leave_type,present,ob,earned,enjoyed,balanced,encashed,rate,amount,db_add_date,comp_id,payment_date,cb) values(:emp,:client,:bankid,:bno,:paymode,:from,:todate,:ltype,:pres,:ob,:earn,:enjoy,:balance,:encash,:rate,:amount,now(),:comp,:payment,:cb)";	
    	$stmt = $this->connection->prepare($sql);
    	$stmt->execute(array('emp'=>$emp,'pres'=>$preday,'ob'=>$obday,'earn'=>$earned,'enjoy'=>$enjoyed,'balance'=>$balance,'encash'=>$encashed,'rate'=>$rate,'amount'=>$amount,'bankid'=>$bid,'bno'=>$bankacno,'paymode'=>$paymode,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt,'comp'=>$compid,'payment'=>$payment_date,'cb'=>$balance-$encashed));	
    	return $stmt;
    }
    function getEmployeeAllDetailsByClientId($clientid)
    {
        $sql ="select emp.first_name,emp.middle_name,emp.last_name,emp.gender,emp.gender,emp.bdate,mde.mast_desg_name, emp.joindate from employee emp inner join mast_desg mde on mde.mast_desg_id= emp.desg_id where emp.client_id='$clientid' and (emp.leftdate IS NULL or emp.leftdate ='0000-00-00')";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }
    function getLeaveChequeEmployeeByEmpId($empid1,$frdt1,$to)
    {
        $sql ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.amount ,te.payment_date from leave_details te inner join employee e on e.emp_id = te.emp_id where te.emp_id = :emp and te.pay_mode = 'C' and te.amount >0 and from_date = :frm and to_date=:to order by te.emp_id"; 
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('emp'=>$empid1,'frm'=>$frdt1,'to'=>$to));
        $row = $stmt->fetchAll();
        return $row;
    }
    function getLeaveChequeEmployeeByClientId($clientid,$tab_emp,$frdt1,$to)
    {
        $sql ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.amount,te.payment_date from $tab_emp te  inner join employee e on e.emp_id = te.emp_id where te.client_id=:client  and te.pay_mode = 'C' and te.amount >0 and payment_date>=:from and payment_date<=:to order by te.emp_id"; 		
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('client'=>$clientid,'from'=>$frdt1,'to'=>$to));
        $row = $stmt->fetchAll();
        return $row;	
    }
    function chkLeaveChequeDetails($emp,$payment_date,$type){		
		$sql="select * from cheque_details where emp_id =:emp and payment_date = :payment_date and type = :type";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$emp,'payment_date'=>$payment_date,'type'=>$type));
		$row =$stmt->fetch();
		return $row;	
		
	}
	function chkLeaveChequeRowDetails($emp,$payment_date,$type)
	 {		
		$sql="select * from cheque_details where emp_id =:emp and payment_date = :payment_date  and type = :type";
	    $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$emp,'payment_date'=>$payment_date,'type'=>$type));
		$row =$stmt->rowCount();
		return $row;
	}
	function insertLeaveCheckDetail($emp,$check_no,$fromdate,$amount,$date1){	
		$sql = "insert into cheque_details(emp_id,check_no,amount,payment_date,date,type,db_addate) values(:emp,:ckno,:amount,:from,:date,'L',now())"; 
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$emp,'ckno'=>$check_no,'from'=>$fromdate,'amount'=>$amount,'date'=>$date1));
		return $stmt;
	 }
    function updateLeaveCheckDetail($emp,$check_no,$payment_date,$amount,$date1)
    {	
        $sql = "update cheque_details set check_no=:ckno,amount=:amount,date=:date,db_update=now() where type='L' and payment_date=:payment_date and emp_id =:emp";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('emp'=>$emp,'ckno'=>$check_no,'payment_date'=>$payment_date,'amount'=>$amount,'date'=>$date1));
        return $stmt;		
    }
    function getLeaveCheckPre($type,$cmonth,$startday,$endday,$payment_date,$empid,$client)
    {	
        if ($type =="S"){
        
        $sql ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='S' and e.pay_mode = 'C' and sal_month='$cmonth' ";}
        if ($type== "B")
        {
        $sql ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='B' and 
        from_date='$startday' and to_date = '$endday'";
        }
        if ($type== "L")
        {
        $sql ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='L' and 
        payment_date='$payment_date'";
        }		
        if($empid> 0){
        $sql .=" and c.emp_id ='".$empid."'";	
        }else{
        $sql .=" and e.client_id='".$client."' ";
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
		return $row;	
    }
    function insertBank($name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id)
    {
        $sql = "INSERT INTO `mast_bank`( `bank_name`, `ifsc_code`, `add1`, `branch`, `city`, `pin_code`,`comp_id`, `user_id`, `db_adddate`, `db_update`) VALUES('".$name."','".$ifsccode."','".$add."','".$branch."','".$city."','".$pincode."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    function updateBank($bid,$name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id){
        $sql = "UPDATE mast_bank SET `comp_id`='".$comp_id."', `user_id`='".$user_id."',bank_name='".$name."',`ifsc_code`='".$ifsccode."',`add1`='".$add."',`branch`='".$branch."',`city`='".$city."',`pin_code`='".$pincode."',db_update=NOW() WHERE `mast_bank_id`='".$bid."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    function sqlcontlabw($tab_emp,$clientid,$frdt){
        $sql = "select sum(gross_salary) gsal from $tab_emp te inner join mast_company mc on te.comp_id = mc.comp_id where te.client_id='".$clientid."' and te.sal_month ='".$frdt."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
		return $row;
    }
    function sqlesi($tab_empded,$tab_emp,$clientid,$frdt){
        $sql = "select sum(std_amt) esi from 	
        $tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id
        inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
        inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 		
        where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%E.S.I.%'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
        return $row;
    }
    function sqlpf($tab_empded,$tab_emp,$clientid,$frdt){
        $sql = "select sum(std_amt) pfsum from 	
    	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
    	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%P.F.%'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
		return $row;
    }
    function sqlovertime($tab_empinc,$tab_emp,$clientid,$frdt){
        $sql = "select sum(amount) ot from 	
    	$tab_empinc te inner join $tab_emp em on te.emp_id = em.emp_id
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
    	inner join mast_income_heads mih on mih.mast_income_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.income_heads_name like '%OVERTIME%'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
		return $row;
    }
    function sqlcanteen($tab_empded,$tab_emp,$clientid,$frdt){
        $sql = "select sum(amount) canteen from 	
    	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id and te.sal_month=em.sal_month
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
    	inner join mast_deduct_heads mih on mih.mast_deduct_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.deduct_heads_name like '%CANTEEN%'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
		return $row;
    }
    function sqltransport($tab_empded,$tab_emp,$clientid,$frdt){
        $sql = "select sum(amount) trans from 	
    	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id and te.sal_month=em.sal_month
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
    	inner join mast_deduct_heads mih on mih.mast_deduct_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.deduct_heads_name like '%TRANSPORT%'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
		return $row;
    }
    function sqllwf($tab_empded,$tab_emp,$clientid,$frdt){
        $sql = "select sum(employer_contri_1) lwfs from 	
    	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id and te.sal_month=em.sal_month
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
    	inner join mast_deduct_heads mih on mih.mast_deduct_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.deduct_heads_name like '%L.W.F.%'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
		return $row;
    }
     function showOtherPayment($comp_id){
        $sql = "select * from mast_other_payment where comp_id ='".$comp_id."' ORDER BY `op_name` ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
		return $row;
    }
    function insertOtherPayment($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_other_payment`(op_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    function displayOtherPayment($did){
        $sql = "SELECT * FROM `mast_other_payment` WHERE op_id='".$did."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
		return $row;
    }
    function updateOtherPayment($did,$name){
        $sql = "UPDATE `mast_other_payment` SET  `op_name`='".$name."' ,db_update=NOW() WHERE op_id='".$did."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    function showOtherPaymentEmployee($clientid){	
        $sql = "SELECT emp_id,first_name,middle_name,last_name FROM employee e WHERE client_id='".$clientid."' order by emp_id ";		
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
    }
    function checkEmpDetailsinOP($empid,$billno,$optype,$clientid){	
		$sql = "SELECT count(*) cnt FROM op_details WHERE emp_id='".$empid."' and bill_no='".$billno."' and op_id='".$optype."' and client_id='".$clientid."'";		
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
        return $row['cnt'];	
    }
    function getOtherPaymentEmployee($empid,$billno,$optype,$clientid){		
		$sql = "SELECT * FROM op_details WHERE emp_id='".$empid."' and op_id='".$optype."' and client_id='".$clientid."'";	
		if($billno !=""){
			$sql .= " and bill_no='".$billno."'";
		}	
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
        return $row;	
    }
    function insertopdetails($amount,$billno,$emp,$client,$opid,$paymentdate){
        $sql = "INSERT INTO `op_details`(op_id,client_id,emp_id,payment_date,amount,bill_no,db_adddate,db_update) VALUES('".$opid."','".$client."','".$emp."','".$paymentdate."','".$amount."','".$billno."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
	}
	function updateOtherPaymentDetails($id,$amount){
		$sql = "UPDATE `op_details` SET  amount='".$amount."',db_update=NOW() WHERE id='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
	}
	function deleteotherpaymentdetails($id){
        $sql = "DELETE FROM `op_details` WHERE id='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
	}
	function savenewbillno($billno,$billdate,$newbillno,$newbilldate){
        $sql = "UPDATE `op_details` SET bill_no = '$newbillno',payment_date ='$newbilldate'  WHERE bill_no='".$billno."' and payment_date = '$billdate' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt;
	}
	function getOpdetails($client_id,$invoiceno){	
        $sql = "SELECT sum(round(od.amount,0)) total, mop.op_name name FROM op_details od inner join mast_other_payment mop on od.op_id = mop.op_id where od.client_id='".$client_id."' and od.bill_no = '".$invoiceno."' group by od.op_id";		
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
    }
    function getOpbildate($billno){	
		$sql = "SELECT payment_date FROM op_details where bill_no='".$billno."' limit 1";		
		$stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
        return $row['payment_date'];
    }
    function getOptype($clientid,$billno)
	{
        $sql = "select  od.op_id,mop.op_name,sum(round(od.amount,0)) as amount,payment_date from op_details od  inner join mast_other_payment mop on mop.op_id = od.op_id where od.bill_no = '$billno' and od.client_id ='$clientid' group by od.op_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
		
	}
    function getOptype1($clientid,$billno)
	{
        $sql = "select  od.op_id,mop.op_name,sum(round(od.amount,0)) as amount,payment_date from op_details od  inner join mast_other_payment mop on mop.op_id = od.op_id where od.bill_no = '$billno' and od.client_id ='$clientid' group by od.op_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
        return $row;
		
	}
	function getEmpOpdetails($clientid,$invoice,$opid)
	{
        $sql = "select  od.op_id, od.client_id, od.emp_id, od.payment_date, round(od.amount,0) as amount, od.bill_no, od.loc ,concat(e.first_name,' ',e.middle_name,' ' ,e.last_name) as emp_name from op_details od inner join employee e on od.emp_id = e.emp_id where od.bill_no = '$invoice' and od.client_id ='$clientid' and od.op_id = '$opid'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
		
	}
	function getdates($client_id){
        $sql = "select distinct  payment_date from leave_details where client_id='$client_id' order by payment_date desc  ";  
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
	}
	function getLDFTdate($client_id,$frdt1){
        $sql = "SELECT leave_details.from_date,leave_details.to_date  FROM leave_details INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$client_id."' AND leave_details.payment_date='".$frdt1."' order by employee.emp_id ";  
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
        return $row;
	}
	function getPaymentDate($client_id,$frdt,$todt){
        $sql = "SELECT distinct payment_date from leave_details WHERE client_id= '".$client_id."' AND leave_details.payment_date>='".$frdt."' and  payment_date<='".$todt."'";  
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
	}
	function getPaymentDate2($client_id,$payment_date){
        $sql = "SELECT leave_details.emp_id,leave_details.client_id,leave_details.payment_date,leave_details.encashed,leave_details.rate,leave_details.amount,employee.emp_id,employee.client_id,employee.first_name,employee.middle_name,employee.last_name,employee.joindate,employee.leftdate FROM leave_details INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$client_id."' AND leave_details.payment_date='".$payment_date."' order by employee.emp_id ";  
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
	}
	function getvoucherDetails($clientid,$payment_date){
        $sql = "SELECT leave_details.emp_id,leave_details.client_id,leave_details.payment_date,leave_details.encashed,leave_details.rate,leave_details.amount,employee.emp_id,employee.client_id,employee.first_name,employee.middle_name,employee.last_name,employee.joindate,employee.leftdate,mc.client_name FROM leave_details inner join mast_client mc on mc.mast_client_id = leave_details.client_id INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$clientid."' AND leave_details.payment_date='".$payment_date."' ";  
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
	}
	function getEmpExportDetails($clintid,$frdt,$todt){
        $sql = "SELECT ld.client_id,ld.emp_id,concat(e.first_name,' ',e.middle_name,' ',e.last_name ) as name,ld.from_date,ld.to_date,ld.present,ld.ob,ld.earned,ld.enjoyed,ld.encashed,ld.rate,ld.amount,  ld.payment_date,e.joindate,e.leftdate FROM leave_details ld  INNER JOIN employee e ON ld.emp_id=e.emp_id WHERE ld.client_id in  ($clintid) AND ld.payment_date>='$frdt' and  ld.payment_date <='$todt' order by ld.payment_date ,ld.emp_id";  
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll();
        return $row;
	}

	function showEmployeeleave($clintid,$frdt,$todt){
	   //echo $sql = "select pl,emp_id,sal_month from hist_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' union select pl,emp_id,sal_month from tran_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' order by emp_id,sal_month";
      $sql = "SELECT trd_id ,MONTHNAME(sal_month) AS SAL_MONTH1,sal_month, sum(pl) AS 'PL',emp_id FROM hist_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' GROUP BY emp_id,sal_month union select trd_id,MONTHNAME(sal_month) AS SAL_MONTH,sal_month, sum(pl) AS 'PL',emp_id from tran_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' GROUP BY emp_id,sal_month order by emp_id,sal_month"; 
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
	}
		function showEmployeeleavebyempID($clintid,$frdt,$todt,$empid){
	  
 //$sql = "SELECT trd_id ,MONTHNAME(sal_month) AS SAL_MONTH, sum(pl) AS 'PL',emp_id FROM hist_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' and emp_id='$empid' GROUP BY emp_id,MONTH(sal_month) union select trd_id,MONTHNAME(sal_month) AS SAL_MONTH, sum(pl) AS 'PL',emp_id from tran_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' and emp_id='$empid' GROUP BY emp_id,MONTH(sal_month) order by emp_id,sal_month"; 
          $sql = "SELECT trd_id ,MONTHNAME(sal_month) AS SAL_MONTH1,sal_month, sum(pl) AS 'PL',emp_id FROM hist_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' and emp_id ='$empid' GROUP BY emp_id,sal_month union select trd_id,MONTHNAME(sal_month) AS SAL_MONTH,sal_month, sum(pl) AS 'PL',emp_id from tran_days where client_id ='$clintid' and sal_month between '$frdt' and '$todt' and emp_id ='$empid' GROUP BY emp_id,sal_month order by emp_id,sal_month"; 
     
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
	}
 //created on 08-04-2024
 function getClientChild($client_id){
      $sql="select group_concat(mast_client_id separator ',') as client_id from mast_client where parentId='$client_id'";
       $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetch();
        return $row['client_id'];
 }
    //created on 25-06-2024 
     function checkPasscodeMobInEmp($passcode,$mobile_no)
    { 
	    $sql = "select * from employee where passcode ='$passcode' and mobile_no='$mobile_no' and (job_status!='L'  and  job_status!='T' )"; 
	    $stmt = $this->connection->prepare($sql);
	    $stmt->execute();
	    //$counts = $stmt->rowCount();
	        $row =$stmt->fetch();
	    return $row;

	}
     function checkEmpIdValid($emp_id){
        $sql_get = "SELECT * from login_master WHERE emp_id='$emp_id'";
        $stmt = $this->connection->prepare($sql_get);
        $stmt->execute();
        $count=$stmt->rowCount();
        return $count;
    }
   function checkEmpIdValidDetail($emp_id){
        $sql_get = "SELECT * from login_master WHERE emp_id='$emp_id'";
        $stmt = $this->connection->prepare($sql_get);
        $stmt->execute();
        $count=$stmt->fetch();
        return $count;
    }
    
    function createEmpLoginbyID($emp_id,$username,$password){
        $empdetails=$this->showEployeedetails($emp_id);
        $login_type=6;
        $msg="";
        if($empdetails['emp_id'] && $emp_id && ($empdetails['emp_id']==$emp_id)){
            $fname=$empdetails['first_name'];
            $mname=$empdetails['middle_name'];
            $lname=$empdetails['last_name'];
            $comp_id=$empdetails['comp_id'];
            $sql = "INSERT INTO `login_master`(fname,mname,lname,username,userpass,login_type,comp_id,emp_id,db_adddate,db_update)VALUES('".$fname."','".$mname."','".$lname."','".$username."','".$password."','".$login_type."','".$comp_id."','".$emp_id."',NOW(),NOW())";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount()){
            $msg='<br><div class="success_class">Successfully created user...</div>';
            } else{
             $msg='<br><div class="success_class">Error while creating user...</div>';
            }
            return $msg;
        }else{
            $msg='<br><div class="success_class">Employee not found...</div>';
             return $msg;
        }
        
    }
    
    function updateempPasswordbyId($emp_id,$password){
        $sql = "UPDATE login_master SET  `userpass`='".$password."',db_update=NOW() WHERE emp_id='".$emp_id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
           $msg='<br><div class="success_class">Successfully updated password...</div>';
        }else{
           $msg='<br><div class="error_class">Error while updating password...</div>';
        }
        return $msg;
    }
    
   function checkEmployeeusername($username){
        $sql_get = "SELECT * from login_master WHERE username='$username'";
        $stmt = $this->connection->prepare($sql_get);
        $stmt->execute();
        $msg='';
        if ($stmt->rowCount()){
           $msg='Username already exist.';
        }
        return $msg;
       
   }
   function checkempUnamepass($username,$password){
        $sql_get = "SELECT * from login_master WHERE username='$username' and userpass='$password'";
        $stmt = $this->connection->prepare($sql_get);
        $stmt->execute();
        $msg='';
        if ($stmt->rowCount()){
           $msg='success';
        }else{
           $msg='failure';
        }
        return $msg;
   }
   function updateempPwdbyunamepass($username,$userpass,$newuserpass){
         $sql = "UPDATE login_master SET  `userpass`='".$newuserpass."',db_update=NOW() WHERE username='$username' and userpass='$userpass'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
           $msg='success';
        }else{
           $msg='failure';
        }
        return $msg;
   }
   //Added on 28 Aug 2024 by Asharani
     function insertEmployeeNew($fname,$mname,$lname,$uname,$password,$add1,$client,$pin_code,$comp_id,$user_id,$role){
         $passcode=substr(number_format(time() * rand(),0,'',''),0,6); 
         $sql = "INSERT INTO `employee`(`first_name`, `middle_name`, `last_name`, `user_name` ,`password`, `client_id`,`emp_add1`,`pin_code`,`comp_id`,`user_id`,`passcode`,`db_adddate`, `db_update`,`role`) VALUES ('".$fname."','".$mname."','".$lname."','".$uname."','".$password."','".$client."','".$add1."','".$pin_code."','".$comp_id."','".$user_id."','".$passcode."',NOW(),NOW(),5)"; 
         $stmt = $this->connection->prepare($sql);
         $stmt->execute();
         return $inserted = $this->connection->lastInsertId();
    }
    
    
    //Added on 28 Aug 2024 by Sakshi
    
    function insertClientGroup($group_name, $esicode, $pfcode, $created_by) {
    

   $sql = "INSERT INTO `client_group` 
            (`group_name`, `pfcode`, `esicode`, `created_by`, `created_on`, `updated_by`, `updated_on`, `db_date`, `db_update`) 
            VALUES ('".$group_name."', '".$pfcode."', '".$esicode."', '".$created_by."', NOW(), 0, '0000-00-00 00:00:00', NOW(), NOW())";
    
    $stmt = $this->connection->prepare($sql);
     $stmt->execute();
     return $inserted = $this->connection->lastInsertId();
}


function displayClientGroup($id = null)
{
    $sql = "SELECT * FROM client_group";
    if ($id) {
        $sql .= " WHERE id = :id";
    }
    
    $stmt = $this->connection->prepare($sql);
    
    if ($id) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function updateClientGroup($id, $group_name, $esicode, $pfcode, $created_by) {
    
    try {
       $sql = "UPDATE `client_group` SET `group_name` = :group_name, `esicode` = :esicode, `pfcode` = :pfcode, `created_by` = :created_by, `db_update` = NOW() WHERE `id` = :id";
       
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':group_name', $group_name, PDO::PARAM_STR);
        $stmt->bindParam(':esicode', $esicode, PDO::PARAM_STR);
        $stmt->bindParam(':pfcode', $pfcode, PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Success: At least 1 row was affected.'];
        } else {
            return ['success' => false, 'message' => 'Failure: 0 rows were affected.'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}



 function showGroupClient1($id){
       $sql = "select * from client_group where id='".$id."'";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
   	}
function deleteGroupClient($id) {
    $sql = "DELETE FROM `client_group` WHERE id = ?";
    $stmt = $this->connection->prepare($sql);

    try {
        if ($stmt->execute([$id])) {
            $rowsdata = $stmt->rowCount();
            return $rowsdata; 
        } else {
            
            return "Error executing query";
        }
    } catch (PDOException $e) {
       
        return "Error: " . $e->getMessage();
    }
}


  /* added on 29-08-2024 Datewise details -use for display client as client Id  Starts  */
    function displayemployeeClientbyID($cid){
      $sql = "select * from employee WHERE client_id='".$cid."' AND job_status!='L' order by emp_id, first_name,middle_name,last_name";
    // $res = $this->connection->query($sql);
     //return $res;
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    
    function checkIfUserExistbySalmonthEmpid($emp_id,$sal_month){ 
	    $sql = "select emp_id from tran_days_details where emp_id ='".$emp_id."' AND sal_month='".$sal_month."' "; 
	
	   $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
     
	}
   function exportTDDEmpData($emp_id,$sal_month){
	
	  $sql = "select * from tran_days_details where emp_id ='".$emp_id."' AND sal_month='".$sal_month."' "; 
	   // $setRec1 = $this->connection->query($sql);
       // return $setRec1;
         $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
	}
	 function insertUpdateNewEmpTranDaysDetails($sql){ 
	   // $res = $this->connection->query($sql);
       //  return $res;
         $stmt = $this->connection->prepare($sql);
         $stmt->execute();
         return $inserted = $this->connection->lastInsertId();
     
	}
	  function displayClientEmployeebyID($cid){
      $sql = "select emp_id from employee WHERE client_id='".$cid."' AND job_status!='L' order by emp_id";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
     // $res = $this->connection->query($sql);
     // return $res;
    }
    
    
    function getBonusType(){
		$sql = "SELECT * FROM caltype_bonus";
       $stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$row =$stmt->fetch();
	}
	
	
 function getExgratiaAmount($client, $startyear, $endyear) {
    try {
        // Define the SQL query with placeholders
        $sql = "select sum(te.apr_exgratia_amt+te.may_exgratia_amt+te.jun_exgratia_amt+te.jul_exgratia_amt+te.aug_exgratia_amt+te.sep_exgratia_amt+te.oct_exgratia_amt+te.nov_exgratia_amt+te.dec_exgratia_amt+te.jan_exgratia_amt+te.feb_exgratia_amt+te.mar_exgratia_amt) as exgratia from employee emp inner join bonus te on te.emp_id = emp.emp_Id inner join mast_bank bk on bk.mast_bank_id = emp.bank_id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=0 and emp.prnsrno !='Y'"; 
        
        // Prepare and execute the query
        $stmt = $this->connection->prepare($sql);
       
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        
        return $result;
        
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}




function exportEmpData($client, $startyear, $endyear,$exgratia) {
    try {
        
        if ($exgratia > 0)

{

  $setSql ="select emp.emp_id,emp.first_name,emp.middle_name,emp.last_name,emp.joindate,emp.leftdate,te.client_id,round(te.apr_wages,2) as apr_wages,te.apr_bonus_wages,te.apr_payable_days,te.apr_bonus_amt,te.apr_exgratia_amt,round(te.may_wages,2) as may_wages,te.may_bonus_wages,te.may_payable_days,te.may_bonus_amt,te.may_exgratia_amt,round(te.jun_wages,2)  as jun_wages, te.jun_bonus_wages, te.jun_payable_days, te.jun_bonus_amt, te.jun_exgratia_amt,round( te.jul_wages,2) as jul_wages, te.jul_bonus_wages, te.jul_payable_days, te.jul_bonus_amt, te.jul_exgratia_amt, round(te.aug_wages,2) as aug_wages, te.aug_bonus_wages, te.aug_payable_days, te.aug_bonus_amt, te.aug_exgratia_amt, round(te.sep_wages,2) as sep_wages, te.sep_bonus_wages, te.sep_payable_days, te.sep_bonus_amt, te.sep_exgratia_amt, round(te.oct_wages,2) as oct_wages, te.oct_bonus_wages, te.oct_payable_days, te.oct_bonus_amt, te.oct_exgratia_amt, round(te.nov_wages) as nov_wages, te.nov_bonus_wages, te.nov_payable_days, te.nov_bonus_amt, te.nov_exgratia_amt, round(te.dec_wages,2) as dec_wages, te.dec_bonus_wages, te.dec_payable_days, te.dec_bonus_amt, te.dec_exgratia_amt, round(te.jan_wages,2) as jan_wages, te.jan_bonus_wages, te.jan_payable_days, te.jan_bonus_amt, te.jan_exgratia_amt,round( te.feb_wages,2) as feb_wages, te.feb_bonus_wages, te.feb_payable_days, te.feb_bonus_amt, te.feb_exgratia_amt, round(te.mar_wages,2) as mar_wages, te.mar_bonus_wages, te.mar_payable_days,  te.mar_bonus_amt, te.mar_exgratia_amt,round(te.apr_bonus_wages+te.may_bonus_wages+te.jun_bonus_wages+te.jul_bonus_wages+te.aug_bonus_wages+te.sep_bonus_wages+te.oct_bonus_wages+te.nov_bonus_wages+te.dec_bonus_wages+te.jan_bonus_wages+te.feb_bonus_wages+te.mar_bonus_wages,2) as tot_bonus_wages,te.tot_payable_days,te.tot_bonus_amt,te.tot_exgratia_amt, (te.tot_bonus_amt+te.tot_exgratia_amt) as total_bonus,te.bonus_rate, te.exgratia_rate, te.bankacno,bk.ifsc_code,emp.pay_mode 
		from employee emp inner join bonus te on te.emp_id = emp.emp_Id inner join mast_bank bk on bk.mast_bank_id = emp.bank_id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=0 and emp.prnsrno !='Y'"; 

}

else
{
  $setSql ="select emp.emp_id,emp.first_name,emp.middle_name,emp.last_name,emp.joindate,emp.leftdate,te.client_id,round(te.apr_wages,2) as apr_wages,te.apr_bonus_wages,te.apr_payable_days,te.apr_bonus_amt,round(te.may_wages,2) as may_wages,te.may_bonus_wages,te.may_payable_days,te.may_bonus_amt,round(te.jun_wages,2)  as jun_wages, te.jun_bonus_wages, te.jun_payable_days, te.jun_bonus_amt, round( te.jul_wages,2) as jul_wages, te.jul_bonus_wages, te.jul_payable_days, te.jul_bonus_amt, round(te.aug_wages,2) as aug_wages, te.aug_bonus_wages, te.aug_payable_days, te.aug_bonus_amt, round(te.sep_wages,2) as sep_wages, te.sep_bonus_wages, te.sep_payable_days, te.sep_bonus_amt, round(te.oct_wages,2) as oct_wages, te.oct_bonus_wages, te.oct_payable_days, te.oct_bonus_amt, round(te.nov_wages) as nov_wages, te.nov_bonus_wages, te.nov_payable_days, te.nov_bonus_amt, round(te.dec_wages,2) as dec_wages, te.dec_bonus_wages, te.dec_payable_days, te.dec_bonus_amt, round(te.jan_wages,2) as jan_wages, te.jan_bonus_wages, te.jan_payable_days, te.jan_bonus_amt,round( te.feb_wages,2) as feb_wages, te.feb_bonus_wages, te.feb_payable_days, te.feb_bonus_amt, round(te.mar_wages,2) as mar_wages, te.mar_bonus_wages, te.mar_payable_days,  te.mar_bonus_amt,round(te.apr_bonus_wages+te.may_bonus_wages+te.jun_bonus_wages+te.jul_bonus_wages+te.aug_bonus_wages+te.sep_bonus_wages+te.oct_bonus_wages+te.nov_bonus_wages+te.dec_bonus_wages+te.jan_bonus_wages+te.feb_bonus_wages+te.mar_bonus_wages,2) as tot_bonus_wages,te.tot_payable_days,te.tot_bonus_amt, (te.tot_bonus_amt) as total_bonus,te.bonus_rate, te.bankacno,bk.ifsc_code,emp.pay_mode 
		from employee emp inner join bonus te on te.emp_id = emp.emp_Id inner join mast_bank bk on bk.mast_bank_id = emp.bank_id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=0 and emp.prnsrno !='Y'"; 
    
}
        // Define the SQL query with placeholders
                // Prepare and execute the query
        $stmt = $this->connection->prepare($setSql);
       
        $stmt->execute();
        $columnCount = $stmt->columnCount();

       
        return $columnCount;
        
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}




function exportEmployeeData($client, $startyear, $endyear) {
    try {
        // Define the SQL query with positional placeholders
      $sql = "SELECT concat(e.first_name,' ',e.middle_name,' ' ,e.last_name)as name,b.* from bonus b inner join employee e  on e.emp_id= b.emp_id where from_date >= '".$startyear."' and todate <='".$endyear."' and b.emp_id in(select emp_id from employee where client_id ='".$client."')";

        // Prepare the SQL statement
        $stmt = $this->connection->prepare($sql);
        // Execute the statement
        $stmt->execute();
        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;

    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

function exportEmployeeDataColumn($client, $startyear, $endyear) {
    try {
        // Define the SQL query with positional placeholders
      $sql = "SELECT concat(e.first_name,' ',e.middle_name,' ' ,e.last_name)as name,b.* from bonus b inner join employee e  on e.emp_id= b.emp_id where from_date >= '".$startyear."' and todate <='".$endyear."' and b.emp_id in(select emp_id from employee where client_id ='".$client."')";

        // Prepare the SQL statement
        $stmt = $this->connection->prepare($sql);

    

        // Execute the statement
        $stmt->execute();

        // Fetch all results
       
         $results2 = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $results2;

    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}





public function getEmployeeBonusByClientHoldEmpId($client, $startyear, $endyear, $days, $emp_id) {
    try {
        // Assuming you have a PDO instance stored in $this->db
        $query = "SELECT emp.first_name, emp.middle_name, emp.last_name, emp.emp_id, emp.joindate, emp.leftdate
                  FROM employee emp
                  INNER JOIN bonus te ON te.emp_id = emp.emp_Id
                  WHERE te.client_id = :client 
                  AND te.from_date = :startyear 
                  AND te.todate = :endyear 
                  AND emp.prnsrno = 'Y' 
                  AND emp.emp_Id = :emp_id";
        
        $stmt = $this->connection->prepare($query);
        
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array

    } catch (PDOException $e) {
        // Handle error, maybe log it and return false or an empty array
        error_log("Database query error: " . $e->getMessage());
        return false;
    }
}




public function getEmployeeBonusByClient($client, $startyear, $endyear, $days) {
    try {
       
        $sql = "
            SELECT emp.first_name, emp.middle_name, emp.last_name, emp.emp_id, emp.joindate, emp.leftdate
            FROM employee emp
            INNER JOIN bonus te ON te.emp_id = emp.emp_id
            WHERE te.client_id = :client
            AND te.from_date = :startyear
            AND te.todate = :endyear
            AND (
                te.apr_payable_days + te.may_payable_days + te.jun_payable_days + te.jul_payable_days +
                te.aug_payable_days + te.sep_payable_days + te.oct_payable_days + te.nov_payable_days +
                te.dec_payable_days + te.jan_payable_days + te.feb_payable_days + te.mar_payable_days
            ) >= :days
            AND emp.prnsrno != 'Y'
        ";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);


        // Execute the statement
        $stmt->execute();

        // Fetch results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } catch (PDOException $e) {
        // Handle any errors
        echo 'Database error: ' . $e->getMessage();
        return false;
    }
}

public function getEmployeeBonusByClientHold($client, $startyear, $endyear) {
    try {
        
        $sql = "
            SELECT emp.first_name, emp.middle_name, emp.last_name, emp.emp_id, emp.joindate, emp.leftdate
            FROM employee emp
            INNER JOIN bonus te ON te.emp_id = emp.emp_id
            WHERE te.client_id = :client
            AND te.from_date = :startyear
            AND te.todate = :endyear
            AND emp.prnsrno = 'Y'
        ";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);


        // Execute the statement
        $stmt->execute();

        // Fetch results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } catch (PDOException $e) {
        // Handle any errors
        echo 'Database error: ' . $e->getMessage();
        return false;
    }
}

public function isUsernameExists($uname) {
    try {
       // error_reporting(E_ALL);
        // Prepare the SQL query with a placeholder
       $query = "SELECT * FROM employee WHERE user_name = '$uname'";
        
        // Prepare the statement
        $stmt = $this->connection->prepare($query);
      
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the count from the result
        $count = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return true if count > 0, otherwise false
        return sizeof($count);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


// 2-9-24 (sakshi)
function showCategory($comp_id){
      $sql = "select * from mast_category where comp_id ='".$comp_id."' ORDER BY `mast_category_id` DESC";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }
   function insertCategory($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_category`(mast_category_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg='1';
        } else{
        $msg= '2';
        }
        return $msg;
    }

 function updateCategory($id,$name,$comp_id,$user_id){
        $sql = "UPDATE mast_category SET  `comp_id`='".$comp_id."',`user_id`='".$user_id."',mast_category_name='".$name."' ,db_update=NOW() WHERE mast_category_id='".$id."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()){
        $msg= 'Success: At least 1 row was affected.';
        } else{
        $msg= 'Failure: 0 rows were affected.';
        }
        return $msg;
    }
    
    
function displayCategory($did){
        $sql = "SELECT * FROM mast_category  WHERE mast_category_id='".$did."' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    function getCategorytId($mast_category_name,$comp_id){
       $sql = "select mast_category_id from mast_category WHERE mast_category_name Like '%".$mast_category_name."%' and comp_id = '".$comp_id."'  ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row['mast_category_id'];
        
    }
    
    
    
    // unique username password function
    public function generateUsername($first_Name) {
        $first_Name = trim($first_Name);
        $numbers = '0123456789';

        // Generate 4 random numbers
        $randomNumbers = '';
        for ($i = 0; $i < 4; $i++) {
            $randomNumbers .= $numbers[rand(0, strlen($numbers) - 1)];
        }

        // Create the username
        $username = $first_Name . $randomNumbers;

        return $username;
    }

    // Function to generate a password
    // public function generatePassword($last_Name) {
    //     $last_Name = trim($last_Name);
    //     $numbers = '0123456789';
    //     $specialChars = '!@#$%^&*()_+[]{}|;:,.<>?';

    //     // Generate 2 random numbers
    //     $randomNumbers = '';
    //     for ($i = 0; $i < 2; $i++) {
    //         $randomNumbers .= $numbers[rand(0, strlen($numbers) - 1)];
    //     }

    //     // Generate 2 random special characters
    //     $randomSpecialChars = '';
    //     for ($i = 0; $i < 2; $i++) {
    //         $randomSpecialChars .= $specialChars[rand(0, strlen($specialChars) - 1)];
    //     }

    //     // Create the password
    //     $password = $last_Name . $randomNumbers . $randomSpecialChars;

    //     return $password;
    // }
public function generatePassword($last_Name) {
    $last_Name = trim($last_Name);
    $numbers = '0123456789';

    // Generate 4 random numbers (you can adjust the number as needed)
    $randomNumbers = '';
    for ($i = 0; $i < 4; $i++) {
        $randomNumbers .= $numbers[rand(0, strlen($numbers) - 1)];
    }

    // Create the password
    $password = $last_Name . $randomNumbers;

    return $password;
}

//Added by Aparna on 10/09/2024
  function lastDate($cmonth){
        $sql = "SELECT LAST_DAY('".$cmonth."') AS last_day";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $endmth = $row['last_day'];
     
        return $endmth;
    }
    
 public function getAttendanceReport($comp_id, $emp_id, $from_date, $to_date) {
    // Prepare SQL query using placeholders
  $sql = "SELECT present, weeklyoff, absent, pl, cl, sl, paidholiday, additional, othours, nightshifts,sal_month
            FROM tran_days
            WHERE emp_id = '$emp_id' AND comp_id='$comp_id' 
              AND tran_days.sal_month BETWEEN '$from_date' AND '$to_date'";
    
    // Execute query
    $stmt = $this->connection->prepare($sql);
 
    $stmt->execute();
    
    // Return results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getAttendanceReportAllEmployees($comp_id, $from_date, $to_date) {
    // SQL query to get attendance and employee details using a JOIN
    $sql = "SELECT e.emp_id, e.first_name, e.last_name, t.present, t.weeklyoff, t.absent, 
                        t.pl, t.cl, t.sl, t.paidholiday, t.additional, t.othours, t.nightshifts, t.sal_month
                 FROM tran_days t
                 JOIN employee e ON t.emp_id = e.emp_id
                 WHERE t.comp_id = '$comp_id'
                   AND t.sal_month BETWEEN '$from_date' AND '$to_date'";

    // Prepare the statement
    $stmt = $this->connection->prepare($sql);


    // Execute the query
    $stmt->execute();

    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//Added on 16-09-2024
 function showClientGroup(){
       $sql = "SELECT * FROM `client_group`";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
   	}

	public function exportAllEmployee($comp_id,$cal){
        $setSql = "select e.*,mb.ifsc_code,mb.branch from employee  e  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  where e.comp_id = '".$comp_id."'";
        
        if($cal!='all' && $cal!='0'){
        $setSql .= " AND e.client_id='".$cal."'";
        }
        $setSql .= " order by e.client_id,e.emp_id,e.client_id,e.first_name,e.middle_name,e.last_name ";
       
          $stmt = $this->connection->prepare($setSql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	
		public function getExportIncome($comp_id,$user_id,$client,$left){
        $setSql1= "SELECT mast_income_heads_id,income_heads_name FROM `mast_income_heads` WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' AND mast_income_heads_id in (select DISTINCT head_id from emp_income ei inner JOIN employee e on e.emp_id=ei.emp_id";
        
        if($client!='all' && $client!='0'){
            $setSql1 .= " where e.client_id='".$client."'";
        }
        
        if($left=='no'){
            $setSql1 .= " AND e.job_status!='L'";
        }
           $setSql1 .= ")";
           //echo $setSql1;
       $stmt = $this->connection->prepare($setSql1);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
		public function getExportIncome1($comp_id,$user_id,$client,$left){
        $setSql= "SELECT emp_id, concat(first_name,' ',middle_name,' ',last_name) as name,joindate FROM employee WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' ";
        if($client!='all' && $client!='0'){
        $setSql .= " AND client_id='".$client."'";
        }
        if($left=='no'){
        $setSql .= " AND job_status!='L'";
        }
        
        $setSql .= " order by emp_id,client_id,first_name,middle_name,last_name ";
         $stmt = $this->connection->prepare($setSql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
		public function getExportIncome2($temp,$emp_id,$comp_id,$user_id){
	    $setSql22 = "SELECT std_amt FROM emp_income WHERE `head_id`= '" . $temp . "'  AND emp_id='" . $emp_id . "'  AND `comp_id`='" . $comp_id . "' AND `user_id`='" . $user_id . "' ";
	      $stmt = $this->connection->prepare($setSql22);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	
	public function exportEmpDeduct($comp_id,$user_id,$clint_id){
	    $setSql= " SELECT distinct emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";
	    $res1 = $this->connection->query($setSql);
        return $res1;
	}
	public function exportEmpDeduct1($comp_id,$user_id,$client,$left){
	     $setSql1= "SELECT mast_deduct_heads_id,deduct_heads_name FROM `mast_deduct_heads` WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."'AND mast_deduct_heads_id in (select DISTINCT head_id from emp_deduct ed inner JOIN employee e on e.emp_id=ed.emp_id";

            if($client!='all' && $client!='0'){
                $setSql1 .= " where e.client_id='".$client."'";
            }
            
            if($left=='no'){
                $setSql1 .= " AND e.job_status!='L'";
            }
            
            $setSql1 .= ")";
       $stmt = $this->connection->prepare($setSql1);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	public function exportEmpDeduct2($comp_id,$user_id,$client){
	    $setSql= "SELECT emp_id, concat(first_name,' ',middle_name,' ',last_name) as name FROM employee WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' ";
        if($client!='all' && $client!='0'){
            $setSql .= " AND client_id='".$client."'";
        }
        $setSql .= " order by client_id,first_name,middle_name,last_name ";
       $stmt = $this->connection->prepare($setSql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	public function exportEmpDeduct3($head_id,$emp_id,$comp_id,$user_id){
	   $setSql22 = "SELECT std_amt FROM emp_deduct WHERE `head_id`= '" . $head_id . "'  AND emp_id='" . $emp_id . "'  AND `comp_id`='" . $comp_id . "' AND `user_id`='" . $user_id . "' ";
       $stmt = $this->connection->prepare($setSql22);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	  public function exportLeave($comp_id,$user_id){
         $setSql= "SELECT emp.`first_name` as 'First Name', emp.`middle_name` as 'Middle Name', emp.`last_name`  as 'Last Name', emp.`gender` as Gender ,emp.`email` as Email,el.ob as OB FROM `employee` emp ,emp_leave el WHERE emp.emp_id=el.emp_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'";
        
          $stmt = $this->connection->prepare($setSql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    


   public function isUsernameExistsForOtherUser($user_name, $user_id) {
    try {
        error_reporting(E_ALL);

        // Prepare the SQL query with placeholders
        $query = "SELECT COUNT(*) as cnt FROM employee WHERE user_name = :user_name AND emp_id != :user_id";
        
        // Prepare the statement
        $stmt = $this->connection->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return true if count > 0 (username exists for another user), otherwise false
        return $count['cnt'] > 0;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

//added on 19-09-2024 -Asharani
    public function exportAdvance($comp_id,$user_id){
	     $setSql= "SELECT emp.`first_name` as 'First Name', emp.`middle_name` as 'Middle Name', emp.`last_name`  as 'Last Name', emp.`gender` as Gender ,emp.`email` as Email, ea.`date` as 'Date', ea.`adv_amount` as 'Advance Amount', ea.`adv_installment` as Installment FROM `employee` emp ,emp_advnacen ea WHERE emp.emp_id=ea.emp_id  AND ea.`comp_id`='".$comp_id."' AND ea.`user_id`='".$user_id."'";
        
       $stmt = $this->connection->prepare($setSql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	
   public function exportActiveEmployee($clientid,$comp_id,$user_id,$emp){
	    if ($emp > 0 ){
          $setSql= "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.desg_id,mdsg.mast_desg_name,e.dept_id,mdpt.mast_dept_name,mcl.client_name as 'Client',e.client_id,e.gender,e.bdate,e.joindate,e.due_date,e.bankacno,mb.bank_name,mb.ifsc_code,mb.branch ,e.middlename_relation,e.esino,e.pfno,e.esistatus,e.adharno,e.panno,e.driving_lic_no,e.uan,e.job_status,e.email,e.emp_add1,e.pin_code,e.mobile_no,e.ticket_no,e.married_status,e.totgrsal,e.qualif from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  inner join mast_dept mdpt on e.dept_id = mdpt.mast_dept_id inner join mast_desg mdsg on e.desg_id =mdsg.mast_desg_id  WHERE e.client_id= $clientid AND e.comp_id=$comp_id AND e.user_id=$user_id and job_status !='L'";
        }
        else{
          $setSql= "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.desg_id,e.dept_id,mcl.client_name as 'Client',e.client_id,e.gender,e.bdate,e.joindate,e.due_date,e.bankacno,mb.bank_name,mb.ifsc_code,mb.branch ,e.middlename_relation,e.esino,e.pfno,e.esistatus,e.adharno,e.panno,e.driving_lic_no,e.uan,e.job_status,e.email,e.emp_add1,e.pin_code,e.mobile_no,e.ticket_no,e.married_status,e.totgrsal,e.qualif from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  WHERE e.comp_id=$comp_id AND e.user_id=$user_id and job_status !='L'";
        }	 
    //echo $setSql;
       $stmt = $this->connection->prepare($setSql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	//end 19-09-2024
	//added on 20-09-2024 -Asharani
		public function getmastcomptdstring(){
	      $sql ="select td_string from mast_company where comp_id = '".$_SESSION['comp_id']."'";
	   $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row['td_string'];
	}
	
		
	function exportTrandayTransaction($client_id,$exhd,$j,$comp_id,$user_id){
	    
	 $setSql = "SELECT mc.mast_client_id as 'client_id',mc.client_name 'client_name',date_format(mc.current_month,'%Y-%c-%d') as 'Sal_month',emp.`emp_id` as 'Emp ID',concat(emp.first_name,' ',emp.last_name) AS 'Employee_Name'";
       for($i=0; $i<$j; $i++ ){
	       $setSql .=", $exhd[$i] as ".$exhd[$i];
       }             
	   $setSql .= ",emp.ticket_no,md.mast_dept_name as 'CC_Code' FROM `tran_days` td inner join mast_client mc  on td.client_id = mc.mast_client_id  inner join employee emp on emp.emp_id = td.emp_id  inner join mast_dept md on emp.dept_id= md.mast_Dept_id where emp.client_id = '".$client_id."' and emp.job_status != 'L' and emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'  order by emp.emp_id";
//	echo "*********<br>".$setSql;
       $stmt = $this->connection->prepare($setSql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
	}
	//end 20-09-2024
    
}





?>