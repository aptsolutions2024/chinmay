<?php
session_start();
error_reporting(0);
$comp_id=$_SESSION['comp_id'];

$clientid=$_REQUEST['cid'];
include("../lib/connection/db-config.php");
include("../lib/class/common.php");
$common=new common();
include("../lib/class/user-class.php");
$userObj=new user();

//$alldesign = $common->showDesignationBycompanyId($comp_id);
$alldesign =  $userObj->showDesignation($comp_id);

if(isset($_REQUEST['id']) && $_REQUEST['id'] !=""){
	$id = $_REQUEST['id'];
}
else
{$id ="";}

?>
<select name="design" id="design" class="textclass">
<option value="">Please select Designation</option>
<?php while ($design = mysql_fetch_array($alldesign)){ ?> 
<option value="<?php echo $design['mast_desg_id']; ?>" <?php if($id !="" && $design['mast_desg_id']==$id){echo "selected";};?>><?php echo $design['mast_desg_name']; ?></option>
<?php }?>
</select>