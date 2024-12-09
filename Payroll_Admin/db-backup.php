<?php
session_start();
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
//include("../lib/connection/db-config.php");
$doc_path=$_SERVER["DOCUMENT_ROOT"];
$dbpath=$doc_path."/lib/connection/payroll_conn.php";
include($dbpath);

    date_default_timezone_set('Asia/Kolkata');
    
	    // Database configuration
        $host = $config['DBHOST'];
        $username = $config['DBUSER'];
        $password = $config['DBPASS'];
        $database_name = $config['DBNAME'];
        $dir = $doc_path."/Payroll_Admin/backup/".date("d-m-Y");
        $zipcreated = $doc_path."/Payroll_Admin/backup/".$database_name.date("d-m-Y").".zip";
    
        // Get connection object and set the charset
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $conn->set_charset("utf8");
        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_row($result)) {
            if(substr($row[0], 0, 3) != 'tab'){
            $tables[] = $row[0];
            }
        }
        
        $sizeoftable=sizeof($tables);
        $count=$sizeoftable/10;
        $numberoftables=array();
        $blank=0;
        for($i=1;$i<=$count;$i++){
              $blank=$i*10;; 
           array_push($numberoftables,$i*10);
        }
        if($blank!=$sizeoftable){
                array_push($numberoftables,$sizeoftable); 
        }
         //echo "<br>Table Count:".sizeof($tables);
        // print_r($numberoftables);
         //echo "</pre>";print_r($tables); 
        
        $sqlScript = "";
        $tblecnt=1;
   if(!mkdir($dir, 0755, true) && file_exists($dir)) {
      echo "Failed to create folder...";die;
   } else{	
     // echo "IN Else<br>";
  
     foreach ($tables as $table) {
          //echo $table."<br>";
            // Prepare SQLscript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            
            $sqlScript .= "\n\n" . $row[1] . ";\n\n";
            
            
            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);
            
            $columnCount = mysqli_num_fields($result);
            
            // Prepare SQLscript for dumping data for each table
            for ($i = 0; $i < $columnCount; $i ++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j ++) {
                        $row[$j] = $row[$j];
                        
                        if (isset($row[$j])) {
                            $sqlScript .= '"' . $row[$j] . '"';
                        } else {
                            $sqlScript .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }
              $sqlScript .= "\n"; 
              
            if(in_array($tblecnt,$numberoftables)){
           // if($tblecnt==10){
               if(!empty($sqlScript))
                    {
                        // Save the SQL script to a backup file
                        $backup_file_name = $dir.'/'.$database_name . '_backup_'.date("d-m-Y").'_'.$tblecnt.'_'. '.sql';
                        $fileHandler = fopen($backup_file_name, 'w+');
                        $number_of_lines = fwrite($fileHandler, $sqlScript);
                        fclose($fileHandler);
                    } 
                    $sqlScript="";
         
            } //table count 
            $tblecnt++;
          
       }    //foreach end
       
        downloadDBBackup($database_name,$dir,$zipcreated);
       delete_directory($dir); 
            
   }   //mkdir() directory else 
       
     
   
  
  function downloadDBBackup($database_name,$dir,$zipcreated){
     if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";    }
    else{
        $protocol = 'http';
    }
    $global_base_url= $protocol . "://" . $_SERVER['HTTP_HOST'];
        // Enter the name of directory 
        $pathdir  = $dir."/"; 
       $url = $global_base_url."/Payroll_Admin/backup/".$database_name.date("d-m-Y").".zip"; 
        // Enter the name to creating zipped directory 
        // Create new zip class 
        $zip = new ZipArchive; 
   
        if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) { 
          
            // Store the path into the variable 
            $dir = opendir($pathdir); 
               
            while($file = readdir($dir)) { 
                if(is_file($pathdir.$file)) { 
                    $zip -> addFile($pathdir.$file, $file); 
                } 
            } 
         
                 if ($zip->close() === false) {
                   exit("Error creating ZIP file");
                };
              
                if (file_exists($zipcreated)) {
                        echo '<a href="'.$url.'" download="'.basename($url).'" style="font-size: 30px;overflow: hidden;outline: none;">Download Zip</a>';
                } else {
                    exit("Could not find Zip file to download");
                }
                
        }else{ 
            "Failed to create zip file...";die;
        } 
 }
   function delete_directory($dirname) 
            {
               
                if (is_dir($dirname))
                $dir_handle = opendir($dirname); 
                if (!$dir_handle)
                return false;
                    while($file = readdir($dir_handle))
                    {
                         
                        if ($file != "." && $file != "..") 
                        {
                             
                            if (!is_dir($dirname."/".$file)) {
                             
                            unlink($dirname."/".$file);  
                            }
                            else {   
                             
                            delete_directory($dirname.'/'.$file);  
                            }
                        }    
                    }
                closedir($dir_handle);    
                rmdir($dirname); 
                return true; 
            }
?>
