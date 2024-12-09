<?php
class Admin {
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

//added by shraddha on 01-10-2024
function getBankDetailsByIfsc($ifsc_no){
        $sql = "select mast_bank_id from mast_bank WHERE ifsc_code='".$ifsc_no."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         return $row['mast_bank_id'];
        
    }
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
  function insertCSVWiseEmployee(
    $comp_id, $user_id, $user_name, $password, 
    $first_name, $middle_name, $last_name, 
    $gender, $bdate, $joindate, $due_date, $leftdate, 
    $pfdate, $pfno, $esistatus, $esino,
    $dept_id, $category_id, $qualif_id, 
    $mobile_no, $pay_mode, $bank_id, $bankacno, 
    $comp_ticket_no, $panno, $adharno, $uan, 
    $married_status, $emp_add1, $desg_id, $clientid,$middlename_relation
) {
    // SQL query
   $sql = "INSERT INTO `employee` (
       `comp_id`, `user_id`, `user_name`, `password`, `first_name`, `middle_name`, `last_name`,
       `gender`, `bdate`, `joindate`, `due_date`, `leftdate`, `pfdate`, `pfno`, `esistatus`, `esino`,
       `dept_id`, `category_id`, `qualif_id`, `mobile_no`, `pay_mode`, `bank_id`, `bankacno`, `comp_ticket_no`, `panno`,
       `adharno`, `uan`, `married_status`, `emp_add1`, `desg_id`, `client_id`,`role`,`middlename_relation`
   ) VALUES (
       '$comp_id', '$user_id', '$user_name', '$password', '$first_name', '$middle_name', '$last_name',
       '$gender', '$bdate', '$joindate', '$due_date', '$leftdate', '$pfdate', '$pfno', '$esistatus', '$esino',
       '$dept_id', '$category_id', '$qualif_id', '$mobile_no', '$pay_mode', '$bank_id', '$bankacno', '$comp_ticket_no', '$panno',
       '$adharno', '$uan', '$married_status', '$emp_add1', '$desg_id', '$clientid','5','$middlename_relation'
   )";

    // Debugging: Print the SQL query to ensure it's correctly formatted
   // echo $sql . "<br>";

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

  function showClient1($comp_id,$user_id){
       $sql = "select * from mast_client where comp_id ='".$comp_id."'  ORDER BY `mast_client_id` DESC";
       $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
   	}
   	//added by Shraddha on 03-10-2024
   	function insertEmployeeIncome($comp_id,$user_id,$emp_id,$head_id,$calc_type,$std_amt,$remark){
   	     // SQL query
   	    if($std_amt!=0 && $std_amt!=NULL){
            $sql = "INSERT INTO `emp_income` (
               `comp_id`, `user_id`, `emp_id`, `head_id`, `calc_type`, `std_amt`, `remark`) VALUES (
               '$comp_id', '$user_id', '$emp_id', '$head_id', '$calc_type', '$std_amt', '$remark')";
            // Assuming $this->connection is a valid PDO connection
            try {
                $stmt = $this->connection->prepare($sql);
                $stmt->execute();
                return $this->connection->lastInsertId();
            } catch (PDOException $e) {
                // Error handling
               // echo "Error: " . $e->getMessage() . "<br>";
              // echo "0";
                return false;
            }
   	    }
    }
    //added by shraddha on 03-10-2024
    function getEmpId($firstName,$middleName,$lastName,$clientId){
        //error_reporting(E_ALL);
        $sql = "select emp_id from employee WHERE client_id='".$clientId."' and first_name='".$firstName."'";
        if($middleName!=''){
            $sql .= " and middle_name='".$middleName."'";
        }
        if($lastName!=''){
            $sql .= " and last_name ='".$lastName."'";
        }
        //echo $sql.'<br>';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['emp_id'];
    }
    //added by Shraddha on 03-10-2024
    function getCatIdFromName($catName){
       $sql = "select mast_category_id  from mast_category WHERE mast_category_name='".$catName."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['mast_category_id'];
    }
    //added by shraddha on 03-10-2024
    function getHeadIdFromName($type,$tableName,$columnName,$tableType){
        $sql = "select ".$columnName." from ".$tableName; 
        if($tableType=='I'){
            $sql .= " WHERE short_name='".$type."'";
        }else{
            $sql .= " WHERE mast_deduct_heads_id='".$type."'";
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($tableType=="I"){
            return $row['mast_income_heads_id'];
        }else{
            return $row['mast_deduct_heads_id'];
        }
    }
    function insertEmployeeDeduct($comp_id,$user_id,$emp_id,$head_id,$calc_type,$std_amt,$remark){
   	     // SQL query
        $sql = "INSERT INTO `emp_deduct` (
           `comp_id`, `user_id`, `emp_id`, `head_id`, `calc_type`, `std_amt`, `remark`) VALUES (
           '$comp_id', '$user_id', '$emp_id', '$head_id', '$calc_type', '$std_amt', '$remark')";
        // Assuming $this->connection is a valid PDO connection
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            // Error handling
           // echo "Error: " . $e->getMessage() . "<br>";
          // echo "0";
            return false;
        }
    }
    function updateCategoryInEmp($cat_id,$emp_id){
        $sql = "update employee set category_id='".$cat_id."' where emp_id ='".$emp_id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
    //added by Shraddha on 05-10-2024
    function showCompany(){
        $sql = "select * from mast_company ORDER BY `comp_id` ASC";
        $stmt = $this->connection->prepare($sql);
       $stmt->execute();
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $row;
    }
    //added by Shraddha on 08-10-2024
    function getLoginDetails($log_id){
        $sql = "select * from login_master WHERE log_id='".$log_id."'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
}





?>