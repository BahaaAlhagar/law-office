@extends('layouts.master')
@section('title')
النسخ الاحتياطى
@endsection
@section('content')
<?php
##backup
#####################
//CONFIGURATIONS
#####################
// Define the name of the backup directory
define('BACKUP_DIR', storage_path('app/myBackups') ) ;// Define  Database Credentials
define('HOST', env('DB_HOST') ) ;
define('USER', env('DB_USERNAME') ) ;
define('PASSWORD', env('DB_PASSWORD') ) ;
define('DB_NAME', env('DB_DATABASE') ) ;
/*
Define the filename for the Archive
If you plan to upload the  file to Amazon's S3 service , use only lower-case letters .
Watever follows the "&" character should be kept as is , it designates a timestamp , which will be used by the script .
*/
$archiveName = 'mysqlbackup--' . date('d-m-Y') . '@'.date('h.i.s').'&'.microtime(true) . '.sql' ;
// Set execution time limit
if(function_exists('max_execution_time')) {
if( ini_get('max_execution_time') > 0 )  set_time_limit(0) ;
}

//END  OF  CONFIGURATIONS

/*
Create backupDir (if it's not yet created ) , with proper permissions .
Create a ".htaccess" file to restrict web-access
*/
if (!file_exists(BACKUP_DIR)) mkdir(BACKUP_DIR , 0700) ;
if (!is_writable(BACKUP_DIR)) chmod(BACKUP_DIR , 0700) ;
// Create an ".htaccess" file , it will restrict direct access to the backup-directory .
$content = 'deny from all' ;
$file = new SplFileObject(BACKUP_DIR . '/.htaccess', "w") ;
$written = $file->fwrite($content) ;
// Verify that ".htaccess" is written , if not , die the script
if($written <13) die("Could not create a \".htaccess\" file , Backup task canceled")  ;
// Check timestamp of the latest Archive . If older than 24Hour , Create a new Archive
$lastArchive = getNameOfLastArchieve(BACKUP_DIR)  ;
$timestampOfLatestArchive =  substr(ltrim((stristr($lastArchive , '&')) , '&') , 0 , -8)  ;
if (allowCreateNewArchive($timestampOfLatestArchive)) {
// Create a new Archive
createNewArchive($archiveName) ;
} else {
	$endresult = "<h2 style='text-align: center; color: blue;'> لم يمر على النسخ الاخير اكثر من 22 ساعه.</h2>";
echo $endresult;
}

###########################
// DEFINING  THE FOUR  FUNCTIONS
// 1) createNewArchive : Creates an archive of a Mysql database
// 2) getFileSizeUnit  : gets an integer value and returns a proper Unit (Bytes , KB , MB)
// 3) getNameOfLastArchieve : Scans the "BackupDir" and returns the name of last created Archive
// 4) allowCreateNewArchive : Compares two timestamps (Yesterday , lastArchive) . Returns "TRUE" , If the latest Archive is onlder than 24Hours .
###########################
// Function createNewArchive
function createNewArchive($archiveName){
$mysqli = new mysqli(HOST , USER , PASSWORD , DB_NAME) ;
if (mysqli_connect_errno())
{
printf("Connect failed: %s", mysqli_connect_error());
exit();
}
// Introduction information

$return = "--\n";
$return .= "-- A Mysql Backup System \n";
$return .= "--\n";
$return .= '-- Export created: ' . date("Y/m/d") . ' on ' . date("h:i") . "\n\n\n";
$return .= "--\n";
$return .= "-- Database : " . DB_NAME . "\n";
$return .= "--\n";
$return .= "-- --------------------------------------------------\n";
$return .= "-- ---------------------------------------------------\n";
$return .= 'SET AUTOCOMMIT = 0 ;' ."\n" ;
$return .= 'SET FOREIGN_KEY_CHECKS=0 ;' ."\n" ;
$tables = array() ;
// Exploring what tables this database has
$result = $mysqli->query('SHOW TABLES' ) ;
// Cycle through "$result" and put content into an array
while ($row = $result->fetch_row())
{
$tables[] = $row[0] ;
}
// Cycle through each  table
foreach($tables as $table)
{
// Get content of each table
$mysqli->query("SET character_set_results = 'utf8'");
$result = $mysqli->query('SELECT * FROM '. $table) ;
// Get number of fields (columns) of each table
$num_fields = $mysqli->field_count  ;
// Add table information
$return .= "--\n" ;
$return .= '-- Tabel structure for table `' . $table . '`' . "\n" ;
$return .= "--\n" ;
$return.= 'DROP TABLE  IF EXISTS `'.$table.'`;' . "\n" ;
// Get the table-shema
$shema = $mysqli->query('SHOW CREATE TABLE '.$table) ;
// Extract table shema
$tableshema = $shema->fetch_row() ;
// Append table-shema into code
$return.= $tableshema[1].";" . "\n\n" ;
// Cycle through each table-row
while($rowdata = $result->fetch_row())
{
// Prepare code that will insert data into table
$return .= 'INSERT INTO `'.$table .'`  VALUES ( '  ;
// Extract data of each row
for($i=0; $i<$num_fields; $i++)
{
$return .= '"'.$rowdata[$i] . "\"," ;
}
// Let's remove the last comma
$return = substr("$return", 0, -1) ;
$return .= ");" ."\n" ;
}
$return .= "\n\n" ;
}
// Close the connection
$mysqli->close() ;
$return .= 'SET FOREIGN_KEY_CHECKS = 1 ; '  . "\n" ;
$return .= 'COMMIT ; '  . "\n" ;
$return .= 'SET AUTOCOMMIT = 1 ; ' . "\n"  ;
//$file = file_put_contents($archiveName , $return) ;
$zip = new ZipArchive() ;
$resOpen = $zip->open(BACKUP_DIR . '/' .$archiveName.".zip" , ZIPARCHIVE::CREATE) ;
if( $resOpen ){
$zip->addFromString( $archiveName , "$return" ) ;
}
$zip->close() ;
$fileSize = getFileSizeUnit(filesize(BACKUP_DIR . "/". $archiveName . '.zip')) ;
$message = <<<msg
<div class=\'heading alert alert-success\'>
<h2 style='text-align:center; color:green;'>تم انشاء نسخة احتياطية من قاعدة البيانات.</h2><br>
</div>
msg;
echo $message ;
} // End of function creatNewArchive

// Function to append proper Unit after a file-size .
function getFileSizeUnit($file_size){
switch (true) {
case ($file_size/1024 < 1) :
return intval($file_size ) ." Bytes" ;
break;
case ($file_size/1024 >= 1 && $file_size/(1024*1024) < 1)  :
return round(($file_size/1024) , 2) ." KB" ;
break;
default:
return round($file_size/(1024*1024) , 2) ." MB" ;
}
} // End of Function getFileSizeUnit

// Funciton getNameOfLastArchieve
function getNameOfLastArchieve($backupDir) {
$allArchieves = array()  ;
$iterator = new DirectoryIterator($backupDir) ;
foreach ($iterator as $fileInfo) {
if (!$fileInfo->isDir() && $fileInfo->getExtension() === 'zip') {
$allArchieves[] = $fileInfo->getFilename() ;

}
}
return  end($allArchieves) ;
} // End of Function getNameOfLastArchieve

// Function allowCreateNewArchive
function allowCreateNewArchive($timestampOfLatestArchive , $timestamp = 22) {
$yesterday =  time() - $timestamp*3600 ;
return ($yesterday >= $timestampOfLatestArchive) ? true : false ;
} // End of Function allowCreateNewArchive
?>

@endsection