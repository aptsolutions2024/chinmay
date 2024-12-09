<?php
class common{
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


// get setting for site
	public function displayemployeeithinrange($cid,$from_date,$to_date,$emp,$empid){ 
		$sql = "select distinct hd.emp_id,e.first_name,e.middle_name,e.last_name,e.joindate,e.leftdate from hist_days hd inner join employee e on hd.emp_id = e.emp_id WHERE hd.client_id=:cid AND hd.sal_month>= :frmdt and hd.sal_month <= :tdt";
		if($emp!="all"){
			$sql .= " and e.emp_id =:empid";
		}	
		
        $stmt = $this->connection->prepare($sql);
		if($emp!="all"){
			$stmt->execute(array('cid' => $cid,'frmdt' => $from_date,'tdt' => $to_date,'empid' => $empid));
		}else{
			 $stmt->execute(array('cid' => $cid,'frmdt' => $from_date,'tdt' => $to_date));
		}
       
		//$row = $stmt->fetchAll();

		return $stmt;
    }

	
	public function displayemployeeClient($cid){
        $sql = "select * from employee WHERE client_id=:cid AND job_status in ($_SESSION[active_emp])";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('cid' => $cid));
		return $stmt;
    }
	
	/// for emaerion bill
	public function clientDept($id){
		$sql = "select distinct(dept_id) from tran_employee WHERE client_id in($id) order by dept_id asc";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
		return $stmt;
	}
	public function clientDesign($id){
		 $sql = "select distinct desg_id from tran_employee WHERE client_id in($id) order by desg_id asc";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
		return $stmt;
	}
	public function getDeptDetail($deptid){
		$sql = "select * from mast_dept WHERE mast_dept_id=:dept";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('dept'=>$deptid));
		$row = $stmt->fetch();
		return $row;
	}
	public function getEmployeeIncome($deptid,$type,$compid){
		//echo $deptid."-".$type."-".$compid;
		
		 $sql = "select ei.std_amt as amt from emp_income ei inner join mast_income_heads mih on ei.head_id=mih.mast_income_heads_id
		where mih.comp_id=:comid and mih.income_heads_name=:type and emp_id in (select emp_id from tran_employee where desg_id=:dept) order by ei.head_id desc limit 1";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('dept'=>$deptid,'type'=>$type,'comid'=>$compid));
		$row = $stmt->fetch();
		return $row['amt'];
	}
	public function clientDesigationEmployeeById($id,$clid){
		//echo $id;
		 $sql = "select no_of_employee as cnt from client_employee where design_id=:desgid and client_id in($clid) limit 1";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('desgid'=>$id));
		$row = $stmt->fetch();
		return $row['cnt'];
	}
	public function getDesgById($id){
		$sql = "select mast_desg_name from mast_desg where mast_desg_id=:desg";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('desg'=>$id));
		$row = $stmt->fetch();
		return $row['mast_desg_name'];
	}
	
	public function showDesignationBycompanyId($clientid){		
		 $sql = "select distinct(md.mast_desg_id),md.mast_desg_name from employee e inner join mast_desg md on e.desg_id=md.mast_desg_id where e.comp_id =:cid";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('cid'=>$clientid));
		return $stmt;
	}
	
	public function insertClientEmployee($client,$design,$noofemployee){		
		 $sql = "insert into client_employee(design_id,client_id,no_of_employee,db_adddate) values(:design,:cid,:noemp,now())";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('cid'=>$client,'design'=>$design,'noemp'=>$noofemployee));
		return $stmt;
	}
	public function getClientEmployeeById($id){		
		 $sql = "select * from client_employee where id=:id";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('id'=>$id));
		$row = $stmt->fetch();
		return $row;
	}
	public function updateClientEmployee($client,$design,$noofemployee,$id){		
		 $sql = "update client_employee set design_id=:design,client_id=:cid,no_of_employee=:noemp where id=:id";
		 $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('cid'=>$client,'design'=>$design,'noemp'=>$noofemployee,'id'=>$id));
		return $stmt;
	}
	public function deleteClientEmployee($id){		
		 $sql = "delete from client_employee where id=:id";
		 $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('id'=>$id));
		return $stmt;
	}
	public function otHours($desgid,$id){
		$sql = "select sum(othours) as othour,sal_month from tran_days where emp_id in(select emp_id from employee where desg_id=:desgid and client_id in($id)) group by sal_month";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('desgid'=>$desgid));
		$row = $stmt->fetch();
		return $row;
	}
	public function payableDays($desgid,$id){
		$sql = "select sum(payabledays) as payabledays from tran_employee where emp_id in(select emp_id from employee where desg_id=:desgid and client_id in($id))";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('desgid'=>$desgid));
		$row = $stmt->fetch();
		return $row['payabledays'];
	}
	/*  use for show all Emerson clients as comp and user wise Starts  */
    function showEmersionClient($comp_id,$user_id){
       $sql = "select * from mast_client where client_name like 'EMERSON%' AND user_id=:userid  ORDER BY `mast_client_id` DESC";
	   $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('userid'=>$user_id));		
		return $stmt;
	}
	
	function showLeaveEmployee($frdt,$todt,$clintid,$leave_type,$emp,$empid,$lmt){
     $sqlli = "select distinct he.emp_id,e.dept_id,e.desg_id,e.first_name,e.middle_name,e.last_name,e.leftdate from hist_employee he inner join employee e on e.emp_id = he.emp_id  where he.client_id=$clintid and he.sal_month>= '$frdt' and he.sal_month <= '$todt'  union  select distinct he.emp_id,e.dept_id,e.desg_id,e.first_name,e.middle_name,e.last_name,e.leftdate from tran_employee he inner join employee e on e.emp_id = he.emp_id  where he.client_id=$clintid and he.sal_month>= '$frdt' and he.sal_month <= '$todt' limit $lmt";
		
		/*
		if($emp =="random"){
		$sqlli .= " and emp_id =:empid";
		}
		$sqlli .= "  order by emp_id";*/
		$stmt = $this->connection->prepare($sqlli);
		$stmt->execute();
		$row = $stmt->fetchAll();
		return $row;
		
	}
	
	function showleaveEmployeecount($frdt,$todt,$clintid,$leave_type,$emp,$empid,$lmt){
		$sqlli = "select distinct he.emp_id,e.first_name,e.middle_name,e.last_name,e.leftdate from hist_employee he inner join employee e on e.emp_id = he.emp_id  where he.client_id=$clintid and he.sal_month>= '$frdt' and he.sal_month <= '$todt'  union  select distinct he.emp_id,e.first_name,e.middle_name,e.last_name,e.leftdate from tran_employee he inner join employee e on e.emp_id = he.emp_id  where he.client_id=$clintid and he.sal_month>= '$frdt' and he.sal_month <= '$todt' limit $lmt";
		
	$stmt = $this->connection->prepare($sqlli);
		$stmt->execute();
		$row = $stmt->rowCount();
		return $row;
		
	}
	
	
	
    /*  use for show all clients as comp and user wise end  */
	function showEmployeeWithClients($frdt,$clintid,$leave_type,$emp,$empid){
		//echo $frdt = date('Y-m-d', strtotime($frdt));
		
		$sql = "select from_date from emp_leave where to_date = :frdt and client_id = :client and leave_type = :type"; 
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('frdt'=>$frdt,'client'=>$clintid,'type'=>$leave_type));
		$res = $stmt->fetch();
		$fromdate = $res['from_date'];
		if($fromdate==""){
			$fromdate = date('Y-m-d');
		} 

		$sqlli = "select * from employee where client_id=:client and ( leftdate > :frdt or leftdate = '0000-00-00' ) order by emp_id";
		if($emp =="random"){
		$sqlli .= " and emp_id =:empid";
		}
		$stmt1 = $this->connection->prepare($sqlli);
		$stmt1->bindParam(':frdt', $fromdate);
		$stmt1->bindParam(':client', $clintid);
		if($emp =="random"){
			$stmt1->bindParam(':empid', $empid);
		}
		$stmt1->execute();
		return $stmt1;
	}
	/// get all income calculation type
	function incomeCalculationType(){		
 		$sql = "select * from caltype_income"; 
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll();
		return $row;
	}
	/// get all deduct calculation type
	function deductCalculationType(){		
		$sql = "select * from caltype_deduct"; 
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll();
		return $row;
	}
	function getIncomeByEmployeeId($empid,$m,$y){		
		$sql = "select *,mih.income_heads_name,ci.name from hist_income hi inner join mast_income_heads mih 
		on hi.head_id=mih.mast_income_heads_id inner join caltype_income ci
		on ci.id=hi.calc_type
		where emp_id=:emp and year(sal_month)='$y' and month(sal_month)='$m' order by income_heads_name asc";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$empid));
		$row = $stmt->fetchAll();
		return $row;
	}
	function insertArrears($empid,$dt,$frdt,$todt,$grnttotval,$bankid,$bankacno,$paymode){
		$sql = "insert into arrears(emp_id,date,from_date,to_date,amount,bank_id,bankacno,pay_mode,db_adddate) values(:emp,:dt,:frdt,:todate,:amt,:bankid,:bankacno,:paymode,now())"; 
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$empid,'dt'=>$dt,'frdt'=>$frdt,'todate'=>$todt,'amt'=>$grnttotval,'bankid'=>$bankid,'bankacno'=>$bankacno,'paymode'=>$paymode));
		$lastID = $this->connection->lastInsertId();
	return $lastID;
	}
	function insertArrears2($resid,$orgincomhead,$orgcaltype,$caltype,$orgstdname,$stdamount,$orgamont,$amount,$difference,$monthname){ $monthname=$monthname;
		/// new_amount == difference
		 $sql = "insert into arrears2 (arr1_id,head_id,org_calc_type,new_calc_type,org_std_amount,new_std_amt,org_amount,amount,new_amt,sal_month) values(:arr1_id,:head_id,:org_calc_type,:new_calc_type,:org_std_amount,:new_std_amt,:org_amount,:amount,:difference,:salmon)";		  
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('arr1_id'=>$resid,'head_id'=>$orgincomhead,'org_calc_type'=>$orgcaltype,'new_calc_type'=>$caltype,'org_std_amount'=>$orgstdname,'new_std_amt'=>$stdamount,'org_amount'=>$orgamont,'amount'=>$amount,'difference'=>$difference,'salmon'=>$monthname));		
	}
	function getBankDetails($empid,$clientid){
		$sql = "select * from employee where emp_id=:empid ";//and client_id=:clientid
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('empid'=>$empid));//,'clientid'=>$clientid
		return $row = $stmt->fetch();
	}
	function getBankDetailsByName($bank1,$bank2){
		$sql = "select * from mast_bank where bank_name like concat('%', :bank1, '%') or bank_name like concat('%', :bank2, '%')";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('bank1'=>$bank1,'bank2'=>$bank2));
		return $row = $stmt->fetchAll();
	}
	//function getdept
	public function clientDeptDetails($id){
		$sql = "select distinct dept_id,mast_dept_name from employee e inner join mast_dept md on e.desg_id=md.mast_dept_id where client_id=:id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('id'=>$id));
		return $stmt;
	}
	public function getDeptDetailsByClientId($id,$orderby){
		$sql = "select distinct dept_id,mast_dept_name from employee e inner join mast_dept md on e.dept_id=md.mast_dept_id where client_id=:id ".$orderby;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('id'=>$id));
		return $stmt;
	}
	public function getWorkingManByDept($dept,$client){
		$sql = "select count(*) as num from employee where dept_id=:deptid and client_id=:client";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('deptid'=>$dept,'client'=>$client));
		$row =$stmt->fetch();
		return $row['num'];
	}
	public function otHoursByDept($deptid,$id){
		$sql = "select sum(othours) as othour from tran_days where emp_id in(select emp_id from employee where dept_id=:deptid and client_id in($id)) group by sal_month";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('deptid'=>$deptid));
		$row = $stmt->fetch();
		return $row['othour'];
	}
	public function getAllIncomeHeadBYClientId($client){
		$sql = "select distinct ei.head_id,mih.income_heads_name from emp_income ei inner join mast_income_heads mih on mih.mast_income_heads_id =ei.head_id where emp_id in(select emp_id from employee where client_id in(:client))";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('client'=>$client));
		$row = $stmt->fetchAll();
		return $row;
	}
	public function getOtIncome($deptid,$client,$headname,$comp_id){
		$sql = "select amount as amount from tran_income where emp_id in(select emp_id from employee where client_id=:client and dept_id=:deptid) and head_id =(select mast_income_heads_id from mast_income_heads where income_heads_name like :head  and comp_id=:comp) limit 1";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('deptid'=>$deptid,'client'=>$client,'head'=>$headname,'comp'=>$comp_id));
		$row = $stmt->fetch();
		return $row['amount'];
	}
	public function getEmployeeIncomeByTypeId($deptid,$type,$compid){
		//echo $deptid."-".$type."-".$compid;
		
		 $sql = "select ei.std_amt as amt from emp_income ei inner join mast_income_heads mih on ei.head_id=mih.mast_income_heads_id
		where mih.comp_id=:comid and mih.mast_income_heads_id=:type and emp_id in (select emp_id from tran_employee where desg_id=:dept) order by ei.head_id desc limit 1";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('dept'=>$deptid,'type'=>$type,'comid'=>$compid));
		$row = $stmt->fetch();
		return $row['amt'];
	}
	public function getIncomeHeadNameById($headid){		
        $sql = "select lower(income_heads_name) as income_heads_name from mast_income_heads WHERE mast_income_heads_id=:headid";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('headid' => $headid));
		$row = $stmt->fetch();
		return $row['income_heads_name'];
   
	}
	public function getdaysdetails($clientid,$empid,$frdt,$todt){
		//echo $sql1 = "select * from hist_days WHERE emp_id=$empid and client_id=$clientid and month(sal_month)=month($date) and year(sal_month) =year($date)";
		
		$sql = "select sal_month,present,absent,pl,sl,cl from hist_days WHERE emp_id=:empid and client_id=:client and sal_month between :frd and :tod";
        $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('client' => $clientid,'empid' => $empid,'frd' => $frdt,'tod' => $todt));
		
		return $stmt;
	}
	public function getAllEmployeeForESI($compid,$mon,$frdt,$todt){ echo $compid."=".$mon."=".$frdt."=".$todt;
	
		
		$sql = "SELECT te.client_id,d.client_name,sum(t.amount) as amount,sum(te.gross_salary) as gross_salary ,sum(t.employer_contri_1) as employer,count(t.emp_id) as cnt  FROM tran_deduct t  inner join tran_employee te on te.emp_id = t.emp_id  and t.sal_month = te.sal_month inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id inner join mast_client d on te.client_id = d.mast_client_id WHERE md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =:cid";
		if($mon =="current"){
		$sql .=" and t.sal_month =:frmdt";
		}else{
			$sql .=" and t.sal_month between :frmdt and :todt";
		}
		 $sql .=" group by te.client_id";
		
		
		 $stmt = $this->connection->prepare($sql);
		 $stmt->bindParam(':frmdt', $frdt);
		 if($mon !='current'){
		 $stmt->bindParam(':todt', $todt);
		 }
		 $stmt->bindParam(':cid', $compid);
		//$row = $stmt->fetchAll();
		//print_r($row);
		return $stmt ;
	}
}
?>