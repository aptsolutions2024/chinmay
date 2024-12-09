<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$id=$_REQUEST['id'];
$_SESSION['empid'] = $id;
$rowsemp=$payrollAdmin->showEployeedetails($id);
$rowsincome=$payrollAdmin->showEployeeincome($id);
$rowsdeduct=$payrollAdmin->showEployeededuct($id);
$rowsleave=$payrollAdmin->showEployeeleave($id);
$rowsadnavcen=$payrollAdmin->showEployeeadnavcen($id);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
$result2 = $payrollAdmin->showDesignation($comp_id);
$result10 = $payrollAdmin->showCategory($comp_id);

$result3 = $payrollAdmin->showDepartment($comp_id);
$result4 = $payrollAdmin->showQualification($comp_id);
$result5 = $payrollAdmin->showBank($comp_id);
$result51 = $payrollAdmin->showBank($comp_id);
$result6 = $payrollAdmin->showLocation($comp_id);
                                
//$result7= $payrollAdmin->showPayscalecode($comp_id);
$resultIncome = $payrollAdmin->showIncomehead($comp_id);
$resultdest = $payrollAdmin->showDeductionhead($comp_id);
//$reslt = $payrollAdmin->showLeavetype($comp_id);
$resadv = $payrollAdmin->showAdvancetype($comp_id);

//echo "<pre>";print_r($rowsemp);
?>

  <link rel="stylesheet" href="Payroll/css/style.css">
    <script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
<link rel="stylesheet" href="Payroll/css/jquery-ui.css">
<script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>


<script>
    $( document ).ready(function() {
//        $('.bankon').hide();
        refreshIncome('<?php echo $id; ?>');
        refreshDeduct('<?php echo $id; ?>');
        refreshLeave('<?php echo $id; ?>');
        refreshAdvances('<?php echo $id; ?>');
        
        $("#bdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#joindate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#lodate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#incdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $( "#perdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#pfdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#duedate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
          $("#ltdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#lfdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#advdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });


    $('#tab1').show();
    });
/*function openbank(id){
    if(id==16){
        $('.bankon').show();
    }
        else{
        $('.bankon').hide();
    }

}*/
/*    function selbank(val){
        $('$selbank').val(val);
    }*/
    function deleteeirow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.get('/delete-emp-income-process', {
                'id': id
            },function(data){
                refreshIncome('<?php echo $id; ?>');
                $("#success2").html("Recourd Delete Successfully!");
              //  alert('Recourd Delete Successfully');
                $('#editIncome').hide();
                $("#insertIncome").show();
            });
        }
    }
    function editeirow(id) {
           $.get('/edit-emp-income',{
            'id':id
        },function(data){
            //alert(data);
            $('#editIncome').show();
            $('#editIncome').html(data);
            
            $("#insertIncome").hide();
        });
    }

    function editderow(id) {
   
        $.get('/edit-emp-deduct',{
            'id':id
        },function(data){
            $('#editDeduct').html(data);
            $('#editDeduct').show();
            $("#insertDeduct").hide();
        });
    }
    function deletederow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.get('/delete-emp-deduct-process', {
                'id': id
            },function(data){
                refreshDeduct('<?php echo $id; ?>');
                $("#success3").html("Recourd Delete Successfully!");
              //  alert('Recourd Delete Successfully');
                $('#editDeduct').hide();
                $("#insertDeduct").show();
            });
        }
    }
    function clearemp() {
        $('#fnerror').html("");
        $('#mnerror').html("");
        $('#lnerror').html("");
        $('#emailerror').html("");
        $('#bderror').html("");
        $('#jderror').html("");
        $('#adhaarerror').html("");
        $('#phoneerror').html("");
		$('#clientrror').html("");
		$('#qualifierror').html("");
		$('#categoryerror').html("");
		$('#departerror').html("");
		$('#designerror').html("");
		$('#locationerror').html("");
    }

    function updateemp() {
      clearemp();

        var gentype='';
        if (document.getElementById('gentypem').checked) {
            gentype = document.getElementById('gentypem').value;
        }
        else{
            gentype= document.getElementById('gentypef').value;
        }

        var id=document.getElementById("empid").value;
        var fname=document.getElementById("fname").value;
        var mname=document.getElementById("mname").value;
        var uname=document.getElementById("uname").value;
        var password=document.getElementById("password").value;
        var lname=document.getElementById("lname").value;
        var bdate=document.getElementById("bdate").value;
        var joindate=document.getElementById("joindate").value;
        var lodate=document.getElementById("lodate").value;
        var incdate=document.getElementById("incdate").value;
        var perdate=document.getElementById("perdate").value;
        var pfdate=document.getElementById("pfdate").value;
        var client=document.getElementById("client").value;
        var design=document.getElementById("design").value;
        var depart=document.getElementById("depart").value;
        var category=document.getElementById("category").value;

        var qualifi=document.getElementById("qualifi").value;
        var bank=document.getElementById("bank").value;
        var location=document.getElementById("location").value;
        var bankacno=document.getElementById("bankacno").value;
        var paycid=document.getElementById("paycid").value;
        var esistatus=document.getElementById("esistatus").value;
        var namerel=document.getElementById("namerel").value;
        var prnsrno=document.getElementById("prnsrno").value;
        var esicode=document.getElementById("esicode").value;
        var pfcode=document.getElementById("pfcode").value;
        var adhaar=document.getElementById("adhaar").value;
        var drilno=document.getElementById("drilno").value;
        var uan=document.getElementById("uan").value;
        var votid=document.getElementById("votid").value;
        var jobstatus=document.getElementById("jobstatus").value;
        var add1=document.getElementById("add1").value;
        var panno1=document.getElementById("panno").value;
        var emailtext=document.getElementById("emailtext").value;
        var phone=document.getElementById("phone").value;

        var duedate=document.getElementById("duedate").value;
        var ticket_no=document.getElementById("ticket_no").value;
        var comp_ticket_no=document.getElementById("comp_ticket_no").value;
        var married_status=document.getElementById("married_status").value;
        var pay_mode=document.getElementById("pay_mode").value;
        var pin_code=document.getElementById("pin_code").value;
        var handicap=document.getElementById("handicap").value;
        var nation=document.getElementById("nation").value;
var lwf_no=document.getElementById("lwf_no").value;
        var dateTime1 = new Date(bdate).getTime();
        var dateTime2 = new Date(joindate).getTime();

        var diff = dateTime1 - dateTime2;
        if(fname=='') {
            $('#fnerror').html("Please Enter the First Name");
            $('#fnerror').show();
            document.getElementById("fname").focus();
            $("#success").hide();
        }
        else if(uname==''){
            $('#unerror').html("Plese Enter Your User Name");
            $('#unerror').show();
            document.getElementById("uname").focus();
            $("#success").hide();
            
            
        }
        else if(password==''){
            $('#pswerror').html("Plese Enter Your User Name");
            $('#pswerror').show();
            document.getElementById("password").focus();
            $("#success").hide();
            
            
        }
        else if(lname=='') {
            $('#lnerror').html("Please Enter the Last Name");
            $('#lnerror').show();
            document.getElementById("lname").focus();
            $("#success").hide();
        }else if(mname=='') {
            $('#mnerror').html("Please Enter the Middle Name");

            $('#mnerror').show();
            document.getElementById("mname").focus();
            $("#success").hide();
        }
       /* else if(emailtext=='') {
            $('#emailerror').html("Please Enter the Email Id");
            $('#emailerror').show();
            document.getElementById("emailname").focus();
            $("#success").hide();
        }*/
        else if(client=='') {

            $('#clientrror').html("Please select client");
            $('#clientrror').show();

            document.getElementById("client").focus();
            $("#success").hide();

        }else if(joindate=='') {

            $('#jderror').html("Please Enter the Join Date");
            $('#jderror').show();

            document.getElementById("joindate").focus();
            $("#success").hide();

        }else if(bdate=='') {
            $('#bderror').html("Please Enter the Birth Date");
            $('#bderror').show();
            document.getElementById("bdate").focus();
            $("#success").hide();
        }
        else if(joindate=='') {
            $('#jderror').html("Please Enter the Join Date");
            $('#jderror').show();
            document.getElementById("joindate").focus();
            $("#success").hide();
        }
        else if (diff >= 0) {
            $('#jderror').html("Please Enter the Birth Date < Join Date");
            $('#jderror').show();

            document.getElementById("joindate").focus();
            $("#success").hide();
        }else if(qualifi=='') {
            $('#qualifierror').html("Please Enter the Qualification ");
            $('#qualifierror').show();
            document.getElementById("qualifi").focus();
            $("#success").hide();
        }else if(depart=='') {
            $('#departerror').html("Please Enter the Department ");
            $('#departerror').show();
            document.getElementById("depart").focus();
            $("#success").hide();
        }else if(category=='') {
            $('#categoryerror').html("Please Enter the category ");
            $('#categoryerror').show();
            document.getElementById("category").focus();
            $("#success").hide();
        }
        
        else if(design=='') {
            $('#designerror').html("Please Enter the Designation ");
            $('#designerror').show();
            document.getElementById("design").focus();
            $("#success").hide();
        }else if(phone.length!=10) {
            $('#phoneerror').html("Please Enter the 10 digit in Mobile No");
            $('#phoneerror').show();
            document.getElementById("phone").focus();
            $("#success").hide();
        }else if(bank=='') {
            $('#bankerror').html("Please Enter the bank ");
            $('#bankerror').show();
            document.getElementById("bank").focus();
            $("#success").hide();
        }
        else if(panno=='') {
            $('#panerror').html("Please Enter the Pan Number");
            $('#panerror').show();
            document.getElementById("panno").focus();
            $("#success").hide();
        }else if(bankacno=='') {
            $('#bankacnerror').html("Please Enter the Bank Account Number");
            $('#bankacnerror').show();
            document.getElementById("bankacno").focus();
            $("#success").hide();
        }
        else if(adhaar=='') {
            $('#adhaarerror').html("Please Enter the Adhaar No");
            $('#adhaarerror').show();
            document.getElementById("adhaar").focus();
            $("#success").hide();
        }
        else if(adhaar.length!=14) {
            $('#adhaarerror').html("Please Enter the 12 digit in Adhaar No");
            $('#adhaarerror').show();
            document.getElementById("adhaar").focus();
            $("#success").hide();
        }
        /*else if(location=='') {
            $('#locationerror').html("Please Enter the Location ");
            $('#locationerror').show();
            document.getElementById("location").focus();
            $("#success").hide();
        }
        else if(phone=='') {
            $('#phoneerror').html("Please Enter the Mobile No");
            $('#phoneerror').show();
            document.getElementById("phone").focus();
            $("#success").hide();
        }*/
        
        else {

            $.get('/update-employee-process',{
                'fname':fname,
                'mname':mname,
                'lname':lname,
                'uname':uname,
                'password':password,
                'lodate':lodate,
                'incdate':incdate,
                'perdate':perdate,
                'pfdate':pfdate,
                'client':client,
                'design':design,
                'depart':depart,
                'category':category,
                'qualifi':qualifi,
                'bank':bank,
                'location':location,
                'bankacno':bankacno,
                'paycid':paycid,
                'esistatus':esistatus,
                'namerel':namerel,
                'prnsrno':prnsrno,
                'esicode':esicode,
                'pfcode':pfcode,
                'adhaar':adhaar,
                'drilno':drilno,
                'uan':uan,
                'votid':votid,
                'jobstatus':jobstatus,
                'gentype':gentype,
                'bdate':bdate,
                'joindate':joindate,
                'add1':add1,
                'panno':panno1,
                'emailtext':emailtext,
                'id':id,
                'phone':phone,
                'duedate':duedate,
                'ticket_no':ticket_no,
                'comp_ticket_no':comp_ticket_no,
                'married_status':married_status,
                'pay_mode':pay_mode,
                'pin_code':pin_code,
                'nation':nation,
                'handicap':handicap,
                'lwf_no':lwf_no,
				
            },function(data){ 
			    $("#success1").html(data);
                // $("#success1").html("Record updated Successfully!");
                 $("#success1").show();
            })

        }


    }
    function clearincome() {
        $('#calterror').html("");
        $('#stderror').html("");
        $('#incoerror').html("");
        $('#inrerror').html("");
    }
    function clearincome1() {
        $('#calterror1').html("");
        $('#stderror1').html("");
        $('#incoerror1').html("");
        $('#inrerror1').html("");
    }
 function refreshconutIncome(id){

        $.post('/display-emp-income-totalcont',{
            'id':id
        },function(data){

            $("#insaltotal").html(data);
            $("#insaltotal").show();
        });
    }
   function insertIncome(){
       clearincome();
       var empid=document.getElementById("empid").value;
       var caltype=document.getElementById("caltype").value;
       var stdamt=document.getElementById("stdamt").value;
       var incomeid=document.getElementById("incomeid").value;
       var inremark=document.getElementById("inremark").value;
       var letters = /^[A-Za-z]+$/;
       var amt=stdamt.match(letters);

       if(incomeid=='0') {
           $('#incoerror').html("Please Select the Income");
           $('#incoerror').show();
           document.getElementById("caltype").focus();
           $("#success").hide();
       }
       else if(caltype=='0') {
           $('#calterror').html("Please Select the Calculation Type");
           $('#calterror').show();
           document.getElementById("caltype").focus();
           $("#success").hide();
       }
       else if(stdamt=='') {
           $('#stderror').html("Please Enter the STD Amount");
           $('#stderror').show();
           document.getElementById("stdamt").focus();
           $("#success").hide();

       }
       else if(amt!=null)
       {
           $('#stderror').html("Please Enter the valid characters STD Amount ");
           $('#stderror').show();
           document.getElementById("stdamt").focus();
           $("#success").hide();
       }
       else {
           $.post('/employee-income-process',{
               'empid':empid,
               'caltype':caltype,
               'incomeid':incomeid,
               'inremark':inremark,
               'stdamt':stdamt
           },function(data){
			   refreshconutIncome(empid);
               $('#form2').trigger('reset');
               $("#success2").html("Record Insert Successfully!");
               $("#success2").show();
               refreshIncome('<?php echo $id; ?>');
           })
       }
   }
    function refreshIncome(id){
        refreshconutIncome(id);
        var view=2;
        
        $.post('/display-emp-income-details',{
        'id':id,
        'view':view
        },function(data){
            //alert(data);
            $("#detailsempIncome").html(data);
            $("#detailsempIncome").show();
        });
       
   }
    function updateIncome(){
        clearincome1();
        var empid=document.getElementById("empid").value;
        var caltype=document.getElementById("caltype1").value;
        var id=document.getElementById("emp_income_id1").value;
        var stdamt=document.getElementById("stdamt1").value;
        var incomeid=document.getElementById("incomeid1").value;
        var inremark=document.getElementById("inremark1").value;
        var letters = /^[A-Za-z]+$/;
        var amt=stdamt.match(letters);
        if(incomeid=='0') {
            $('#incoerror1').html("Please Select the Income");
            $('#incoerror1').show();
            document.getElementById("caltype1").focus();
            $("#success").hide();
        }
        else if(caltype=='0') {
            $('#calterror1').html("Please Select the Calculation Type");
            $('#calterror1').show();
            document.getElementById("caltype1").focus();
            $("#success").hide();
        }
        else if(stdamt=='') {
            $('#stderror1').html("Please Enter the Std Amt");
            $('#stderror1').show();
            document.getElementById("stdamt1").focus();
            $("#success").hide();

        }
        else if(amt!=null)
        {
            $('#stderror1').html("Please Enter the valid characters STD Amount ");
            $('#stderror1').show();
            document.getElementById("stdamt1").focus();
            $("#success").hide();

        }
        else {
            $.post('/update-income-process',{
                'id':id,
                'empid':empid,
                'caltype':caltype,
                 'incomeid':incomeid,
                'inremark':inremark,
                'stdamt':stdamt
            },function(data){
	             refreshconutIncome(empid);
                $("#success21").html(data);
                $("#success21").show();
                refreshIncome('<?php echo $id; ?>');

                $("#editIncome").hide();
                $("#insertIncome").show();

            });
        }

    }

    function cleardeduct() {
        $('#destiderror').html("");
        $('#dectyerror').html("");
        $('#destderror').html("");
        $('#destdrrerror').html("");
    }

    function insertDeduct(){
        cleardeduct();
        var empid=document.getElementById("empid").value;
        var decaltype=document.getElementById("decaltype").value;
        var destdamt=document.getElementById("destdamt").value;
        var destid=document.getElementById("destid").value;
        var destdremark=document.getElementById("destdremark").value;
        var selbank=document.getElementById("mybank").value;
        var letters = /^[A-Za-z]+$/;
        var amt= destdamt.match(letters);
        if(destid=='0') {
            $('#destiderror').html("Please Enter Select Deduction");
            $('#destiderror').show();
            document.getElementById("destid").focus();
            $("#success").hide();
        }
        else if(decaltype=='0') {
            $('#dectyerror').html("Please Enter the Calculation Type");
            $('#dectyerror').show();
            document.getElementById("decaltype").focus();
            $("#success").hide();
        }
        else if(destdamt=='') {
            $('#destderror').html("Please Enter the STD Amt");
            $('#destderror').show();
            document.getElementById("destdamt").focus();
            $("#success").hide();
        }
        else if(amt!=null)
        {
            $('#destderror').html("Please Enter the valid characters STD Amount ");
            $('#destderror').show();
            document.getElementById("destdamt").focus();
            $("#success").hide();

        }
        else {
            $.get('/employee-deduct-process',{
                'empid':empid,
                'selbank':selbank,
                'decaltype':decaltype,
                'destdremark':destdremark,
                'destid':destid,
                'destdamt':destdamt
            },function(data){
				//alert(data);$("#test").text(data);
                $("#success3").html("Record Inserted Successfully!");
                $("#success3").show();
                refreshDeduct('<?php echo $id; ?>');

            })
        }

    }

    function refreshDeduct(id){
        var view=2;
        $.get('/display-emp-deduct-details',{
            'id':id,
            'view':view
        },function(data){
            $("#detailsempDeduct").html(data);
            $("#detailsempDeduct").show();

        })
    }
    function cleardeduct1() {
        $('#destiderror1').html("");
        $('#dectyerror1').html("");
        $('#destderror1').html("");
        $('#destdrrerror1').html("");
    }

    function updateDeduct(){
	    cleardeduct1();
        var empid=document.getElementById("empid").value;
        var id=document.getElementById("emp_deduct_id1").value;
        var decaltype=document.getElementById("decaltype1").value;
        var destdamt=document.getElementById("destdamt1").value;
        var destid=document.getElementById("destid1").value;
        var destdremark=document.getElementById("destdremark1").value;
        var selbank=document.getElementById("mybank1").value;
		
	    var letters = /^[A-Za-z]+$/;
        var amt= destdamt.match(letters);
        if(destid=='0') {
            $('#destiderror').html("Please Enter Select Deduction");
            $('#destiderror').show();
            document.getElementById("destid").focus();
            $("#success").hide();
        }
        else if(decaltype=='0') {
            $('#dectyerror').html("Please Enter the Calculation Type");
            $('#dectyerror').show();
            document.getElementById("decaltype").focus();
            $("#success").hide();
        }
        else if(destdamt=='') {
            $('#destderror').html("Please Enter the STD Amt");
            $('#destderror').show();
            document.getElementById("destdamt").focus();
            $("#success").hide();

        }
        else if(amt!=null)
        {
            $('#destderror').html("Please Enter the valid characters STD Amount ");
            $('#destderror').show();
            document.getElementById("destdamt").focus();
            $("#success").hide();

        }
        else {
            $.get('/update-deduct-process',{
                'id':id,
                'empid':empid,
                'selbank':selbank,
                'decaltype':decaltype,
                'destdremark':destdremark,
                'destid':destid,
                'destdamt':destdamt
            },function(data){
				//alert();
                $("#success31").html("Record updated Successfully!");
                $("#success31").show();
                refreshDeduct('<?php echo $id; ?>');
                refreshLeave('<?php echo $id; ?>');

                $("#editDeduct").hide();
                $("#insertDeduct").show();
				document.getElementById("mybank1").value = 0;
				document.getElementById("mybank").value = 0;
            });
        }

    }

    function refreshLeave(id){
        var view=2;
        $.get('/display-emp-leave-details',{
            'id':id,
            'view':view
        },function(data){
            $("#detailsempLeave").html(data);
            $("#detailsempLeave").show();

        })
    }

    function deletelerow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.get('/delete-emp-leave-process', {
                'id': id
            },function(data){
                refreshLeave('<?php echo $id; ?>');
                $("#success4").html("Recourd Delete Successfully!");
                $('#editLeave').hide();
                $("#insertLeave").show();
            });
        }
    }
    function clearleave() {

        $('#oberror').html("");
    }
    function clearleave1() {

        $('#oberror1').html("");
    }
    function updateLeave(){
        clearleave1();
		var empid=document.getElementById("empid").value;
        var ob=document.getElementById("ob1").value;
        var id=document.getElementById("emp_leave_id1").value;
        var lfdate=document.getElementById("lfdate1").value;
        var ltdate=document.getElementById("ltdate1").value;
        var lt=document.getElementById("lt1").value;

		if(ob=='') {
            $('#oberror1').html("Please Enter the OB");
            $('#oberror1').show();
            document.getElementById("ob1").focus();
            $("#success4").hide();
        }
        else{
            $.get('/update-leave-process',{
                 'ob':ob,
                'empid':empid,
                'id':id,
                'lfdate':lfdate,
                'lt':lt,
                'ltdate':ltdate
            },function(data){
                $("#success4").html("Record updated Successfully!");
                $("#success4").show();
                refreshLeave('<?php echo $id; ?>');
                refreshAdvances('<?php echo $id; ?>');
                $('#editLeave').hide();
                $("#insertLeave").show();
            })
        }

    }
    function insertLeave(){
        clearleave();
       var empid=document.getElementById("empid").value;
        var ob=document.getElementById("ob").value;
        var lt=document.getElementById("lt").value;
        var lfdate=document.getElementById("lfdate").value;
        var ltdate=document.getElementById("ltdate").value;


       if(ob=='') {
            $('#oberror').html("Please Enter the OB");
            $('#oberror').show();
            document.getElementById("ob").focus();
            $("#success4").hide();
        }
         else{
            $.get('/employee-leave-process',{
                'ob':ob,
                'lfdate':lfdate,
                'lt':lt,
                'empid':empid,
                'ltdate':ltdate
            },function(data){
                $("#success4").html("Record Insert Successfully!");
                $("#success4").show();
                refreshLeave('<?php echo $id; ?>');
                refreshAdvances('<?php echo $id; ?>');
                $('#form4').trigger('reset');
            });
        }

    }
    function clearadnavcen() {
        $('#advamterror').html("");
        $('#advinserror').html("");
        $('#advtypeerror').html("");
        $('#advdateerror').html("");
    }
    function clearadnavcen1() {
        $('#advamterror1').html("");
        $('#advinserror1').html("");
        $('#advtypeerror1').html("");
        $('#advdateerror1').html("");
    }
    function refreshAdvances(id){
        var view=2;
        $.get('/display-emp-advances-details',{
                'id':id,
                'view':view
            },function(data){
            $("#detailsempAdvances").html(data);
            $("#detailsempAdvances").show();

        })
    }
    function deleteadrow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.get('/delete-emp-advances-process', {
                'id': id
            },function(data){
                refreshAdvances('<?php echo $id; ?>');
                 $("#success5").html("Recourd Delete Successfully!");
                 $('#editLeave').hide();
                $("#insertLeave").show();
            });
        }
    }
    function updateAdnavcen() {
        clearadnavcen1();
        var empid = document.getElementById("empid").value;
        var advamt = document.getElementById("advamt1").value;
        var id = document.getElementById("emp_adnavcen_id1").value;
        var advins = document.getElementById("advins1").value;
        var advtype=document.getElementById("advtype1").value;
        var advdate=document.getElementById("advdate1").value;
        if(advtype=='') {
            $('#advtypeerror1').html("Please Enter the Advance Type");
            $('#advtypeerror1').show();
            document.getElementById("advtype1").focus();
            $("#success5").hide();
        }
        else if(advdate=='') {
            $('#advdateerror1').html("Please Enter the Advance Date");
            $('#advdateerror1').show();
            document.getElementById("advdate1").focus();
            $("#success5").hide();
        }
        else if (advamt == '') {
            $('#advamterror1').html("Please Enter the Advance Amount");
            $('#advamterror1').show();
            document.getElementById("advamt1").focus();
            $("#success5").hide();
        }
        else if (advins == '') {
            $('#advinserror1').html("Please Enter the Advance Installment");
            $('#advinserror1').show();
            document.getElementById("advins1").focus();
            $("#success5").hide();
        }
        else {
            $.get('/update-advances-process', {
                'advamt': advamt,
                'empid': empid,
                'id': id,
                'advdate':advdate,
                'advtype':advtype,
                'advins': advins
            }, function (data) {
                $("#success5").html("Record updated Successfully!");
                $("#success5").show();
                refreshAdvances('<?php echo $id; ?>');
                $('#editAdvances').hide();
                $("#insertAdvances").show();

            });
        }
    }

   function insertAdnavcen(){
    clearadnavcen();
    var empid = document.getElementById("empid").value;
    var advamt = document.getElementById("advamt").value;
    var advins = document.getElementById("advins").value;
    var advtype = document.getElementById("advtype").value;
    var advdate = document.getElementById("advdate").value;

    if(advtype == '') {
        $('#advtypeerror').html("Please Enter the Advance Type");
        $('#advtypeerror').show();
        document.getElementById("advtype").focus();
        $("#success5").hide();
    }
    else if(advdate == '') {
        $('#advdateerror').html("Please Enter the Advance Date");
        $('#advdateerror').show();
        document.getElementById("advdate").focus();
        $("#success5").hide();
    }
    else if(advamt == '') {
        $('#advamterror').html("Please Enter the Advance Amount");
        $('#advamterror').show();
        document.getElementById("advamt").focus();
        $("#success5").hide();
    }
    else if(advins == '') {
        $('#advinserror').html("Please Enter the Advance Installment");
        $('#advinserror').show();
        document.getElementById("advins").focus();
        $("#success5").hide();
    }
    else if(parseFloat(advins) >= parseFloat(advamt)) {
        $('#advinserror').html("Advance Installment must be less than Advance Amount");
        $('#advinserror').show();
        document.getElementById("advins").focus();
        $("#success5").hide();
    }
    else {
        $.get('/employee-advances-process',{
            'advamt': advamt,
            'empid': empid,
            'advdate': advdate,
            'advtype': advtype,
            'advins': advins
        },function(data){
            $("#success5").html("Record Insert Successfully!");
            $("#success5").show();
            refreshAdvances('<?php echo $id; ?>');
            $('#form5').trigger('reset');
        });
    }
}

    function editlerow(id) {
        $.get('/edit-emp-leave',{
            'id':id
        },function(data){
            $('#editLeave').html(data);
            $('#editLeave').show();
            $("#insertLeave").hide();

        });
    }
    function editadrow(id) {
        $.get('/edit-emp-advances',{
            'id':id
        },function(data){
            $('#editAdvances').html(data);
            $('#editAdvances').show();
            $("#insertAdvances").hide();
        })
    }
    //added by shraddha on 15-11-2024
    function copyToNewEmployee(){
    	var empid=$("#empid").val();
        if (empid=='')
           {alert("Please Select Employee.");}
        else{
         $.post('/copytonew-employee', {
              'editempid': empid
          }, function (data) {
    		  alert(data);
          });
        }  
    }
    //added by shraddha on 15-11-2024
    function readURL(input) {
        	var empid=$("#empid").val();
        if (input.files && input.files[0]) {
            var fd = new FormData();
            fd.append('file',input.files[0]);
            fd.append('empid',empid);
               $.ajax({
                    url:'/emp_profile_upload',
                    type:'post',
                    data:fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success:function(response){
                        $('#profile_photo').val('');
                         if(response.status == 1){
                             if(response.ext=='pdf'){
                                  $('#img_preview').hide();
                                   $('#pdf_img_preview').show();
                                   $('#pdf_img_preview').attr('src', response.path);
                             }else{
                                  $('#pdf_img_preview').hide();
                                 $('#img_preview').show();
                                 $('#img_preview').attr('src', response.path);
                             }
                              $('#delete_profile').show()
                              $("#uploaded_photo").val(response.db_path);
                         }else{
                            $('#img_preview').hide();
                             $('#pdF_img_preview').hide();
                             $('#delete_profile').hide()  
                         }
                         alert(response.message)
                    }
               });
          }else{
               alert("Please select a file.");
               $('#img_preview').hide();
               $('#pdf_img_preview').hide();
               $('#delete_profile').hide()
          }
     }

    $("#profile_photo").change(function(){
        readURL(this);
    });
    function deleteProfile(){
        var empid=$("#empid").val();
        var uploaded_photo=$("#uploaded_photo").val();
         $.post('/delete-profile-photo', {
              'editempid': empid,
              'uploaded_photo':uploaded_photo
          }, function (data) {
    		    if(data==1){
    		        $('#delete_profile').hide();
    		        $('#img_preview').hide();
    		         $('#pdf_img_preview').hide();
    		        $("#uploaded_photo").val('');
    		        alert('Profile photo deleted successfully....');
    		    }else{
    		        $('#img_preview').show();
    		        $("#uploaded_photo").val(uploaded_photo);
    		        $('#delete_profile').show()
    		    }
          });
    }

    </script>



<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">



        <div class="twelve" id="margin1">
            <div class="tab">
                <button id="t1" class="tablinks active" onclick="openTab(event, 'tab1')">Edit Employee</button>
                <button id="t2" class="tablinks" onclick="openTab(event, 'tab2')" >Employee Income</button>
                <button id="t3" class="tablinks" onclick="openTab(event, 'tab3')">Employee Deduct</button>
                <!--<button id="t4" class="tablinks" onclick="openTab(event, 'tab4')">Employee Leave</button>-->
                <button id="t5" class="tablinks" onclick="openTab(event, 'tab5')">Employee Advances</button>
            </div>

            <div id="tab1" class="tabcontent ">
                 <form id="form1">
                    <div class="two columns">
                        <h3>Edit Employee</h3>
                    </div>
                    <?php $display='';
                    $profile_photo ='#';
                    $img_display=$pdf_display ='';
                    if($rowsemp['photo_path']!=""){ 
                        $extension = end(explode(".", $rowsemp['photo_path']));
                        $profile_photo = $rowsemp['photo_path']; 
                        if($extension=='pdf'){
                            $img_display = "style='display:none'" ;
                            $pdf_display='';
                        }else{
                            $img_display = '';
                            $pdf_display = "style='display:none'" ;
                        }
                        
                    }else{ 
                        $display = "style='display:none'" ;
                    }?>
                    <div class="ten columns text-right" <?= $display; ?>>
                                <img id="img_preview" src="<?= $profile_photo; ?>" alt="Profile Photo" <?= $img_display; ?> width="80px;" height="80px" />
                            <embed id="pdf_img_preview" src="<?= $profile_photo; ?>" alt="PDF Profile Photo" <?= $pdf_display; ?> width="80px;" height="80px" />
                      
                            <a href="javascript:void(0)" id="delete_profile" name="delete_profile"  onclick="deleteProfile()"><img src="Payroll/images/delete-icon.png"></a>
                             <input type="hidden" id="uploaded_photo" name="uploaded_photo" value="<?= $profile_photo; ?>">
                      
                    </div>

                    <div class="twelve" id="margin1">
                        
                        <div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Employee Id :</span>
                        </div>
                        <div class="four  columns">
                           <?php echo $id;?>
                        </div>
						<div class="two columns" style="display:none">
                            <span class="labelclass">Ticket No :</span>
                        </div>
                        <div class="four  columns" style="display:none">
                            <input type="text" class="textclass" id="ticket_no" name="ticket_no"  placeholder="Ticket No" value="<?php echo $rowsemp['ticket_no'];?>">

                        </div>
                        <!-- Added by shraddha -->
                        <div class="two columns">
                            <span class="labelclass">Profile Photo : </span>
                        </div>
                        <div class="two  columns">
                            <input type="file" class="textclass" id="profile_photo" name="profile_photo">
                        </div>
                        
						 <div class="clearFix"></div>
                        <div class="two columns">
                            <span class="labelclass">First Name : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="fname" id="fname" placeholder="First Name" class="textclass" value="<?php echo $rowsemp['first_name'];?>" >
                            <span class="errorclass hidecontent" id="fnerror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">Middle Name : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="mname" id="mname" placeholder="Middle Name " class="textclass" value="<?php echo $rowsemp['middle_name'];?>" >
                            <span class="errorclass hidecontent" id="mnerror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Last Name : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="lname" id="lname" placeholder="Last Name" class="textclass"  value="<?php echo $rowsemp['last_name'];?>">
                            <span class="errorclass hidecontent" id="lnerror"></span>
                        </div>
                       
						<div class="two columns">
                            <span class="labelclass">Client : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">


                            <select id="client" name="client" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                foreach($result1 as $row1){
                                
                                   
                                    ?>

                                    <option value="<?php echo $row1['mast_client_id'];?>"  <?php if($rowsemp['client_id']==$row1['mast_client_id']){?> selected <?php } ?>><?php echo $row1['client_name'];?>- <?php echo date('F Y', strtotime($row1['current_month'])); ?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="clientrror"></span>

                        </div>
                        
                        
                        <!--user name password -->
                        <div class="clearFix"></div>
                        <div class="two columns">
                            <span class="labelclass">User Name : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="uname" id="uname" placeholder="User Name" class="textclass" value="<?php echo $rowsemp['user_name'];?>" >
                                        <!--<button type="button" class="buttonclass" onclick="generateUsername()" >Generate User Name</button>-->

                            <span class="errorclass hidecontent" id="unerror"></span>
                             <span class="hidecontent" id="successmsg"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">Password : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="password" id="password" placeholder="Password " class="textclass" value="<?php echo $rowsemp['password'];?>" >
                            <!--<button type="button" class="buttonclass" onclick="generatePassword()">Generate Password</button>-->
      
                            <span class="errorclass hidecontent" id="pswerror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Address :</span>
                        </div>
                        <div class="four  columns">
                            <textarea class="textclass" id="add1" name="add1"  placeholder="Address 1"><?php echo $rowsemp['emp_add1'];?></textarea>
                            <span class="errorclass hidecontent" id="ad1error"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">Pin Code :</span>
                        </div>
                        <div class="four  columns">

                            <input type="text"class="textclass" id="pin_code" name="pin_code"  placeholder="Pin Code" value="<?php echo $rowsemp['pin_code']; ?>">
                            <span class="errorclass hidecontent" id="pincerror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Job Status:</span>
                        </div>
                        <div class="four  columns">

                            <select name="jobstatus" id="jobstatus" class="textclass">
                                <option value="T" <?php if($rowsemp['job_status']=='T'){?> selected <?php } ?>>Trainee</option>
                                <option value="P" <?php if($rowsemp['job_status']=='P'){?> selected <?php } ?>>Probation</option>
                                <option value="C" <?php if($rowsemp['job_status']=='C'){?> selected <?php } ?>>Confirmed</option>
                                <option value="L" <?php if($rowsemp['job_status']=='L'){?> selected <?php } ?>>Left</option>
                            </select>

                        </div>
                         <div class="two columns">
                            <span class="labelclass">Joining Date : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="joindate" id="joindate" placeholder="Join Date" class="textclass"  value="<?php if($rowsemp['joindate']!="0000-00-00"){echo date("d-m-Y", strtotime($rowsemp['joindate']));}?>">
                            <span class="errorclass hidecontent" id="jderror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns" style="display:none">
                            <span class="labelclass">Last Day of Training :</span>
                        </div>
                        <div class="four  columns"style="display:none">
                            <input type="text" name="duedate" id="duedate" placeholder="Due Date" class="textclass" value="<?php if($rowsemp['due_date'] !="0000-00-00"){echo  date("d-m-Y", strtotime($rowsemp['due_date']));}?>">

                        </div>
						<div class="two columns">
                            <span class="labelclass">Increment Date :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="incdate" id="incdate" placeholder="Increment Date" class="textclass"  value="<?php if($rowsemp['incrementdate']!="0000-00-00"){echo date("d-m-Y", strtotime($rowsemp['incrementdate']));}?>">
                            <span class="errorclass hidecontent" id="jderror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Last Day of Service :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="lodate" id="lodate" placeholder="Last Day of Working" class="textclass"  value="<?php if($rowsemp['leftdate'] !="" && $rowsemp['leftdate'] !="0000-00-00" && $rowsemp['leftdate'] != null){echo date("d-m-Y", strtotime($rowsemp['leftdate']));}?>">
                            <span class="errorclass hidecontent" id="loerror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">Gender:</span>
                        </div>
                        <div class="four  columns">
                            <input type="radio" name="gentype" id="gentypem" value="M"  <?php if($rowsemp['gender']=='M'){?> checked <?php } ?> > Male
                            <input type="radio" name="gentype" id="gentypef" value="F" <?php if($rowsemp['gender']=='F'){?> checked <?php } ?> > Female
                        </div>
                        <div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Marital Status :</span>
                        </div>
                        <div class="four  columns">
                            <select  id="married_status" name="married_status" class="textclass">
                                <option>--select--</option>
                                <option value="M"  <?php if($rowsemp['married_status']=='M'){?> selected <?php } ?>>Married</option>
                                <option value="U" <?php if($rowsemp['married_status']=='U'){?> selected <?php } ?>>Unmarried</option>

                            </select>
                        </div>
						
                        <div class="two columns">
                            <span class="labelclass">Relation :</span>
                        </div>
                        <div class="four  columns">
						<select name="namerel" id="namerel" placeholder="Middle Name Relation" class="textclass" >
						
							<option value="Father" <?php if($rowsemp['middlename_relation']=="FATHER"){echo "selected";}?>>Father</option>
							<option value="Husband" <?php if($rowsemp['middlename_relation']=="HUSBAND"){echo "selected";}?>>Husband</option>
						</select>
                            <!--<input type="text" name="namerel" id="namerel" placeholder="Middle Name Relation" class="textclass"  value="<?php echo $rowsemp['middlename_relation'];?>">-->
                            <span class="errorclass hidecontent" id="namerelerror"></span>
                        </div>
						<div class="clearFix"></div>
                        <div class="two columns">
                            <span class="labelclass">Birth Date : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="bdate" id="bdate" placeholder="Birth Date" class="textclass"  value="<?php if($rowsemp['bdate']!="0000-00-00"){echo date("d-m-Y", strtotime($rowsemp['bdate']));}?>">
                            <span class="errorclass hidecontent" id="bderror"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">Qualification : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">

                            <select id="qualifi" name="qualifi" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                foreach($result4 as $row4){
                               
                                    ?>
                                    <option value="<?php echo $row4['mast_qualif_id'];?>"  <?php if($rowsemp['qualif_id']==$row4['mast_qualif_id']){?> selected <?php } ?>><?php echo $row4['mast_qualif_name'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="qualifierror"></span>

                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Department : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">

                            <select id="depart" name="depart" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                foreach($result3 as $row3){
                                
                                    ?>

                                    <option value="<?php echo $row3['mast_dept_id'];?>" <?php if($rowsemp['dept_id']==$row3['mast_dept_id']){?> selected <?php } ?>><?php echo $row3['mast_dept_name'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="departerror"></span>

                        </div>
						<div class="two columns">
                            <span class="labelclass">Designation : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">

                            <select id="design" name="design" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                foreach($result2 as $row2)
                                {
                                    ?>

                                    <option value="<?php echo $row2['mast_desg_id'];?>" <?php if($rowsemp['desg_id']==$row2['mast_desg_id']){?> selected <?php } ?>><?php echo $row2['mast_desg_name'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="designerror"></span>

                        </div>
                        
                        
                        	<div class="two columns">
                            <span class="labelclass">Category : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">

                            <select id="category" name="category" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                foreach($result10 as $row8)
                                {
                                    ?>

                                    <option value="<?php echo $row8['mast_category_id'];?>" <?php if($rowsemp['category_id']==$row8['mast_category_id']){?> selected <?php } ?>><?php echo $row8['mast_category_name'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="categoryerror"></span>

                        </div>
                        <!-- added by Shraddha on 28-10-2024 -->
                        <div class="two columns">
                            <span class="labelclass">LWF No:</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" class="textclass" id="lwf_no" name="lwf_no" placeholder="LWF No" value="<?php echo $rowsemp['lwf_no'];?>">
                           
                        </div>
                        
						<div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Mobile No : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" class="textclass" id="phone" name="phone" maxlength="10"  placeholder="Mobile No" value="<?php echo $rowsemp['mobile_no'];?>">
                            <span class="errorclass hidecontent" id="phoneerror"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">Bank : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">

                            <select id="bank" name="bank" class="textclass">
                                <option value="">--select--</option>
                                <?php
								   
                                foreach($result5 as $row5){
                                
                                    
									   ?>

                                    <option value="<?php echo $row5['mast_bank_id'];?>"  <?php if($rowsemp['bank_id']==$row5['mast_bank_id']){?> selected <?php } ?>><?php echo $row5['ifsc_code'].'-'.$row5['bank_name'].' - '.$row5['branch'];?></option>
									
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="bankeerror"></span>

                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Bank A/C No : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="bankacno" id="bankacno" placeholder="Bank Account No" class="textclass"  value="<?php echo $rowsemp['bankacno'];?>">
                            <span class="errorclass hidecontent" id="bankacnerror"></span>
                        </div>
						
						 <div class="two columns">
                            <span class="labelclass">Pay Mode :</span>
                        </div>
                        <div class="four  columns">
                            <select id="pay_mode" name="pay_mode" class="textclass">
                                <option>--select--</option>
                                <option value="T" <?php if($rowsemp['pay_mode']=='T'){?> selected <?php } ?>>Transfer</option>
                                <option value="C" <?php if($rowsemp['pay_mode']=='C'){?> selected <?php } ?>>Cheque</option>
                                <option value="N" <?php if($rowsemp['pay_mode']=='N'){?> selected <?php } ?>>NEFT</option>
                            </select>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Aadhar No : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four columns">
    <input type="text" name="adhaar" id="adhaar" placeholder="Adhaar No" class="textclass" 
           value="<?php echo $rowsemp['adharno'];?>" maxlength="14">
    <span class="errorclass hidecontent" id="adhaarerror"></span>
</div>
						<div class="two columns">
                            <span class="labelclass">PAN No : <span class="mandatory">*</span></span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="panno" id="panno" placeholder="PAN No" class="textclass"  value="<?php echo $rowsemp['panno'];?>">
                            <span class="errorclass hidecontent" id="panerror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">ESI status :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="esistatus" id="esistatus" placeholder="ESI status" class="textclass"  value="<?php echo $rowsemp['esistatus'];?>">
                            <span class="errorclass hidecontent" id="esiserror"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">ESI No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="esicode" id="esicode" placeholder="ESI No" class="textclass"  value="<?php echo $rowsemp['esino'];?>">
                            <span class="errorclass hidecontent" id="esierror"></span>
                        </div>
						<div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass"> PF No. :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="pfcode" id="pfcode" placeholder="PF No." class="textclass"  value="<?php echo $rowsemp['pfno'];?>">
                            <span class="errorclass hidecontent" id="pferror"></span>
                        </div>
						 <div class="two columns">
                            <span class="labelclass">UAN No.:</span>
                        </div>
						
                        <div class="four  columns">
                            <input type="text" name="uan" id="uan" placeholder="UAN" class="textclass"  value="<?php echo $rowsemp['uan'];?>">
                            <span class="errorclass hidecontent" id="uanerror"></span>
                        </div><div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Bonus Hold  (Y/N) :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="prnsrno" id="prnsrno" placeholder="(Y/N) ." class="textclass"  value="<?php echo $rowsemp['prnsrno'];?>">
                            <span class="errorclass hidecontent" id="prnerror"></span>
                        </div>
						
						 <div class="two columns">
                            <span class="labelclass">Votor ID :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="votid" id="votid" placeholder="Votor ID" class="textclass"  value="<?php echo $rowsemp['voter_id'];?>">
                            <span class="errorclass hidecontent" id="votiderror"></span>
                        </div>
						<div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Driving Lic No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="drilno" id="drilno" placeholder="Driving Lic No" class="textclass"  value="<?php echo $rowsemp['driving_lic_no'];?>">
                            <span class="errorclass hidecontent" id="drilnoerror"></span>
                        </div>
						
                        <div class="two columns">
                            <span class="labelclass">Email ID:</span>
                        </div>
                        <div class="four  columns">

                            <input type="email" name="emailtext" id="emailtext" placeholder="Email ID" class="textclass" value="<?php echo $rowsemp['email'];?>">
                            <span class="errorclass hidecontent" id="emailerror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass"> Handicap :</span>
                        </div>
                        <div class="four  columns">
                            <select id="handicap" name="handicap" class="textclass">

                                <option value="1" <?php if($rowsemp['handicap']=='1'){?> selected <?php } ?>>Not Applicable</option>
                                <option value="2" <?php if($rowsemp['handicap']=='2'){?> selected <?php } ?>>Locomotive</option>
                                <option value="3" <?php if($rowsemp['handicap']=='3'){?> selected <?php } ?>>Hearing</option>
                                <option value="4" <?php if($rowsemp['handicap']=='4'){?> selected <?php } ?>>Visual</option>
                            </select>
                        </div>
						
						
							<div class="two columns">
                            <span class="labelclass">Location :</span>
                        </div>
                        <div class="four  columns">

                            <select id="location" name="location" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                foreach($result6 as $row6) {
                                    ?>

                                    <option value="<?php echo $row6['mast_location_id'];?>" <?php if($rowsemp['loc_id']==$row6['mast_location_id']){?> selected <?php } ?>><?php echo $row6['mast_location_name'];?></option>
                                <?php }
                                ?>
                            </select>
							<span class="errorclass hidecontent" id="locationerror"></span>

                        </div>
						<div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Company No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" class="textclass" id="comp_ticket_no" name="comp_ticket_no"  placeholder="Company No" value="<?php echo $rowsemp['comp_ticket_no']; ?>">

                        </div>
						
						 <div class="two columns">
                            <span class="labelclass">Nationality :</span>
                        </div>
                        <div class="four  columns">

                            <input type="text" class="textclass" id="nation" name="nation"  placeholder="Nationality" value="<?php echo $rowsemp['nationality'];?>">
                            <span class="errorclass hidecontent" id="naterror"></span>
                        </div>
                        
<div class="clearFix"></div>
						
						 <div class="two columns" style="display:none">
                            <span class="labelclass">Employee Passcode :</span>
                        </div>
                        <div class="four  columns" style="display:none">
                           <span class="labelclass"><?php echo $rowsemp['passcode'];?></span>
                        </div>
                        
<div class="clearFix"></div>

                       
                        
                        <div class="two columns" style="display:none">
                            <span class="labelclass">Permanent Date :</span>
                        </div>
                        <div class="four  columns" style="display:none">
                            <input type="text" name="perdate" id="perdate" placeholder="Permanent Date" class="textclass"  value="<?php if($rowsemp['permanentdate'] !="0000-00-00"){ echo date("d-m-Y", strtotime($rowsemp['permanentdate']));}?>">
                            <span class="errorclass hidecontent" id="perdatederror"></span>
                        </div>

                        <div class="two columns" style="display:none">
                            <span class="labelclass">Pf Date :</span>
                        </div>
                        <div class="four  columns" style="display:none">
                            <input type="text" name="pfdate" id="pfdate" placeholder="Pf Date" class="textclass"  value="<?php if($rowsemp['pfdate'] !="0000-00-00"){echo date("d-m-Y", strtotime($rowsemp['pfdate']));}?>">
                            <span class="errorclass hidecontent" id="pfdateerror"></span>
                        </div>
                       
                        <div class="clearFix"></div>

                        <div class="two columns" style="display:none">
                            <span class="labelclass">Pay Code Id :</span>
                        </div>
                        <div class="four  columns" style="display:none">

                            <select name="paycid" id="paycid" class="textclass">
                                <option value="0">--select--</option>
                                <?php
                                foreach($result7 as $row7){
                                
                                    ?>

                                    <option value="<?php echo $row7['mast_paycode_id'];?>" <?php if($rowsemp['paycode_id']==$row7['mast_paycode_id']){?> selected <?php } ?>><?php echo $row7['mast_paycode_name'];?></option>
                                <?php }

                                ?>
                            </select>

                            <span class="errorclass hidecontent" id="payciderror"></span>
                        </div>
                        <div class="clearFix"></div>

                        <div class="eight padd0 columns">
                            &nbsp;&nbsp;
                        </div>
                        <div class="four columns text-right">
								<input type="button" class="btnclass" name="newEmp1" id="newEmp1" value="Add as new Employee"  onclick ="copyToNewEmployee();">
									&nbsp;&nbsp;&nbsp;
                            <input type="button" name="submit" id="submit1" value="Update" class="btnclass" onclick="updateemp();">
                        </div>
<div class="twelve padd0 columns successclass hidecontent" id="success1" style="margin-bottom: 15px;">


                        </div>
                        <div class="clearFix"></div>

                </form>
            </div>
        </div>

            <div id="tab2" class="tabcontent">
                <h3>TOTAL Income = <span  id="insaltotal"></span>          </h3>       <div id="insertIncome">
                <form id="form2">
                    

                    <div class="clearFix"></div>



                    <div class="two columns">
                        <span class="labelclass">Income : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                        <select id="incomeid" name="incomeid" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                           foreach($resultIncome as $rowin){
                            
                                ?>

                                <option value="<?php echo $rowin['mast_income_heads_id'];?>" ><?php echo $rowin['income_heads_name'];?></option>
                            <?php }

                            ?>
                        </select>
                        <span class="errorclass hidecontent" id="incoerror"></span>
                    </div>


                    <div class="two columns">
                        <span class="labelclass">Calculation Type : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
					       <?php
                        $rescalin=$payrollAdmin->showCalType('caltype_income');
                        ?>
                        <select  name="caltype" id="caltype" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            foreach($rescalin as $rowcalin){
                             $calculationType='2';
                            ?>
                            
                                <option <?php if($calculationType==$rowcalin['id']){ echo "selected";} ?> value="<?php echo $rowcalin['id']; ?>"><?php echo $rowcalin['name']; ?></option>

                            <?php } ?>

                        </select>
                       
                             <span class="errorclass hidecontent" id="calterror"></span>
                    </div>
                    <div class="clearFix"></div>
                    <div class="two columns">
                        <span class="labelclass"> STD Amount : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="stdamt" id="stdamt" placeholder="STD Amount" class="textclass" >
                        <span class="errorclass hidecontent" id="stderror"></span>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Remark :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="inremark" id="inremark" placeholder="Remark" class="textclass">
                        <span class="errorclass hidecontent" id="inrerror"></span>
                    </div>
                    <div class="clearFix"></div>




                    <div class="ten padd0 columns">
                        &nbsp;&nbsp;
                    </div>
                    <div class="two columns text-right">
                        <input type="button" name="submit" id="submit2" value="Save" class="btnclass" onclick="insertIncome();">
                   </div>
<div class="twelve padd0 columns successclass hidecontent" id="success2">


                    </div>
                    <div class="clearFix"></div>

                </form>

            </div>
        <div id="editIncome"> </div>
        <div id="detailsempIncome"> </div>

                <div id="c">

                </div>
                <br/>

            </div>

            <div id="tab3" class="tabcontent">
                <h3>Deduct</h3>

                <div id="insertDeduct">
                    <form id="form3">


                    <div class="clearFix"></div>

                    <div class="two columns">
                        <span class="labelclass">Deduction : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                        <select id="destid" name="destid" class="textclass" onchange="openbank(this.value)">
                            <option value="0">--select-</option>
                            <?php
                            foreach($resultdest as $rowde){
                            
                                ?>

                                <option value="<?php echo $rowde['mast_deduct_heads_id'];?>"><?php echo $rowde['deduct_heads_name'];?></option>
                            <?php }

                            ?>
                        </select>
                        <span class="errorclass hidecontent" id="destiderror"></span>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Calculation Type : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                       <?php
                        $rescalde=$payrollAdmin->showCalType('caltype_deduct');
                        ?>

                        <select name="decaltype" id="decaltype" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            foreach($rescalde as $rowcalde){
                            $calculationType2='7';
                            ?>
                            
                                <option <?php if($calculationType2==$rowcalde['id']){ echo "selected";} ?> value="<?php echo $rowcalde['id']; ?>"><?php echo $rowcalde['name']; ?></option>

                            <?php } ?>
                        </select>
                        <span class="errorclass hidecontent" id="dectyerror"></span>
                    </div>
                    <div class="clearFix"></div>

                    <div class="two columns">
                        <span class="labelclass"> STD Amt : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="destdamt" id="destdamt" placeholder="STD Amt" class="textclass">
                        <span class="errorclass hidecontent" id="destderror"></span>
                    </div>

                    <div class="two columns">
                        <span class="labelclass">Remark :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="destdremark" id="destdremark" placeholder="Remark" class="textclass" >
                        <span class="errorclass hidecontent" id="destdrrerror"></span>
                    </div>
                    <div class="clearFix"></div>
                            <div class="two columns" >
<!--                                <input type="hidden" name="selbank" id="selbank" value="0">-->
                                <div class="bankon">
                                <span class="labelclass"> Bank : <span class="mandatory">*</span></span>
                                    </div>
                            </div>
                            <div class="four  columns">
                                <div class="bankon">
                                    <select id="mybank" name="mybank" class="textclass"  >
                                        <option>--select--</option>
                                        <?php
                                        foreach($result51 as $row5){
                                       
                                            ?>
                                            <option value="<?php echo $row5['mast_bank_id'];?>" <?php if($row5['mast_bank_id']==$rowsdeduct['bank_id']){?> selected<?php }?>><?php echo $row5['bank_name'].' - '.$row5['branch'];?></option>

                                        <?php }

                                        ?>
                                    </select>

                                    </div>
                                </div>
                        <div class="four  columns">&nbsp;

                                </div>


                    <div class="two columns text-right">
                        <input type="button" name="submit" id="submit3" value="Save" class="btnclass" onclick="insertDeduct();">
                    </div>
                    <div class="twelve padd0 columns successclass hidecontent" id="success3">
                    </div>
                    <div class="clearFix"></div>

                </form>
                 </div>
                <div id="editDeduct">

                </div>
                <div id="detailsempDeduct">

                </div>

                <br/>

            </div>
            <div id="tab4" class="tabcontent">
                <h3>Leave</h3>
                <div id="insertLeave">
                <form id="form4">
                    

                    <div class="clearFix"></div>

                   <!-- <div class="two columns">
                        <span class="labelclass">Leave Type :</span>
                    </div>
                    <div class="four  columns">
                        <select id="lt" name="lt" class="textclass">
                                <option>--select---</option>
                                <?php 
                                foreach($reslt as $rowlt) { ?>
                                ?>
                                <option value="<?php echo $rowlt['mast_leave_type_id']; ?>"><?php echo $rowlt['leave_type_name']; ?></option>
                                 <?php } ?>
                           </select>
                    </div>-->

                    <div class="two columns">
                        <span class="labelclass">Opening Balance  : </span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="ob" id="ob" placeholder="Opening Balance" class="textclass" >
                        <span class="errorclass hidecontent" id="oberror"></span>
                    </div>
                    <div class="clearFix"></div>

					<div class="two columns">
                        <span class="labelclass">From Date :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="lfdate" id="lfdate" placeholder="From Date" class="textclass" >

                    </div>

                    <div class="two columns">
                        <span class="labelclass">To Date:</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="ltdate" id="ltdate" placeholder="To Date" class="textclass" >

                    </div>
                    <div class="clearFix"></div>




                    <div class="ten padd0 columns">
                        &nbsp;&nbsp;
                    </div>
                    <div class="two columns text-right">
                        <input type="button" name="submit" id="submit4" value="Save" class="btnclass" onclick="insertLeave();">
                    </div>
<div class="twelve padd0 columns successclass hidecontent" id="success4">


                    </div>
                    <div class="clearFix"></div>

                </form>
                </div>
                <div id="editLeave">

                </div>
                <div id="detailsempLeave">

                </div>
                <br/>

            </div>
            <div id="tab5" class="tabcontent">
                <h3>Advances</h3>
                <div id="insertAdvances">
                <form id="form5">
                    

                    <div class="clearFix"></div>
                    <div class="two columns">
                        <span class="labelclass">Advance Type : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                       <select name="advtype" id="advtype" class="textclass">
                            <option value="">--select---</option>
                            <?php
                            
                            foreach($resadv as $rowadv){?>
                           
                                <option value="<?php echo $rowadv['mast_advance_type_id']; ?>"><?php echo $rowadv['advance_type_name']; ?></option>
                            <?php } ?>
                       </select>
                        <span class="errorclass hidecontent" id="advtypeerror"></span>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Date : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="advdate" id="advdate" placeholder="Advance Date" class="textclass">
                        <span class="errorclass hidecontent" id="advdateerror"></span>
                    </div>
                    <div class="clearFix"></div>

                    <div class="two columns">
                        <span class="labelclass">Advance Amount : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="advamt" id="advamt" placeholder="Advance Amount" class="textclass">
                        <span class="errorclass hidecontent" id="advamterror"></span>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Advance Installment : <span class="mandatory">*</span></span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="advins" id="advins" placeholder="Advance Installment" class="textclass">
                        <span class="errorclass hidecontent" id="advinserror"></span>
                    </div>
                    <div class="clearFix"></div>

                   <div class="ten padd0 columns">
                        &nbsp;&nbsp;
                    </div>
                    <div class="two columns text-right">
                        <input type="button" name="submit" id="submit5" value="Save" class="btnclass" onclick="insertAdnavcen();">
                    </div>
<div class="twelve padd0 columns successclass hidecontent" id="success5">


                    </div>
                    <div class="clearFix"></div>

                </form>
            </div>
        <div id="editAdvances">

        </div>
                <div id="detailsempAdvances">

                </div>
                <br/>
            </div>


        </div>


    </div>
    <script>
         var typingTimer;
var doneTypingInterval = 1000; // Time (in ms) after which username is considered "complete"

// Function to check if the username is unique
function checkUsernameUnique() {
    var uname = $("#uname").val().trim();

    if (uname === '') {
        // If username is empty, show required message and hide success message
        $("#unerror").text("Username is required").show();
        $("#uname").addClass('bordererror');
        $("#successmsg").text("").hide(); // Hide success message
        return;
    }

    // Check if username is unique
    $.post('/check-username-unique', { 'uname': uname })
        .done(function (response) {
            //console.log(response);
            if (response.trim().startsWith('Username already exists')) {
                // Show error if username is taken
                $("#unerror").text("Username already exists. Please choose another.").show();
                $("#uname").addClass('bordererror');
                $("#successmsg").text("").hide(); // Hide success message
                
                // Clear the username field after a delay only if duplicate
                setTimeout(function() {
                  $("#uname").val('').focus(); // Clear input and focus on it
                }, doneTypingInterval);

            } else {
                // Username is unique
                
                $("#unerror").text("").hide(); // Clear error text
                $("#uname").removeClass('bordererror');
                $("#successmsg").text("Username is available.").css("color", "green").show(); // Show success message
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error checking username uniqueness:", textStatus, errorThrown);
            $("#unerror").text("An error occurred while checking the username.").show();
            $("#uname").addClass('bordererror');
            $("#successmsg").text("").hide(); // Hide success message
        });
}

// Event listener to detect when the user has finished typing
$(document).ready(function () {
    $("#uname").on("input", function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(checkUsernameUnique, doneTypingInterval);
    });

    $("#uname").on("keydown", function () {
        clearTimeout(typingTimer); // Clear the timer if the user is still typing
    });

    // Add input event listeners for other fields
    $("#fname, #mname, #lname, #client").on("input", function () {
        validateForm(); // Call this if you still want to validate the form's completeness
    });
});


    </script>
    <script>
  function generateUsername() {
    const firstName = document.getElementById('fname').value.trim(); // Get the first name value

    $.ajax({
        url: '/generate', // URL to PHP script
        type: 'POST',
        data: { action: 'generateUsername', fname: firstName }, // Data to send
        success: function(response) {
            document.getElementById('uname').value = response; // Set the generated username in the input field
        }
    });
}

function generatePassword() {
    const lastName = document.getElementById('lname').value.trim(); // Get the last name value
    const passwordField = document.getElementById('password').value.trim(); // Check if the user has entered a password manually

    if (passwordField === "") {  // Only generate if the field is empty
        $.ajax({
            url: '/generate', // URL to PHP script
            type: 'POST',
            data: { action: 'generatePassword', lname: lastName }, // Data to send
            success: function(response) {
                document.getElementById('password').value = response; // Set the generated password in the input field
            }
        });
    }
}

document.getElementById('adhaar').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\s/g, ''); // Remove all spaces
    let formattedValue = '';

    // Add a space after every 4 digits
    for (let i = 0; i < value.length; i += 4) {
        if (i > 0) {
            formattedValue += ' ';
        }
        formattedValue += value.substring(i, i + 4);
    }

    e.target.value = formattedValue.substring(0, 14); // Limit to 14 characters (12 digits + 2 spaces)
});


</script>

<br/>

<div class="clearFix"></div>


<!--Slider part ends here-->
