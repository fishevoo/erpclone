<?php
session_start();

// Database connection configuration
$serverName = "192.124.1.4,1433"; // Server dan port digabung
$connectionInfo = array(
    "Database" => "dbLANTest",
    "UID" => "sa",
    "PWD" => "Mains3rv3r",
    "CharacterSet" => "UTF-8"
);

// Establish connection
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

//==============================================
// eng_pr_mtl_list.php
// Copyright (c) 2016 MIS Karunia Berca Indonesia
//==============================================
if(empty($_SESSION['sMISAppuid'])){
	header("Location: xlogout.php");
}

	include_once("syst/xproc.php");
	include_once("syst/xparam.php");
	include_once("syst/xfunct.php");
	
	$IDMenu 	= "{4A0168BE-744A-4ABB-9420-B862D61B4FAD}";
	include_once("syst/xotor.php");

/*
	$p0 = $_GET['p0'];
	$p1 = $_GET['p1'];
	$p2 = $_GET['p2'];
	$p3 = $_GET['p3'];
				$cSQLStr 	= "spSysDataMTLPR '','','','','','','','','',''
									,'','','','','','','','','',''
									,'".$DepartmentID."','','','','','','','',''
									,'','','','','','','','','',''
									,'AKTIF','".$_SESSION['sMISAppuid']."'
									,'LIST','".$p1."','".TglddmmyyyytoMySql($p2)."'
									,'".TglddmmyyyytoMySql($p3)."','',''";
exit($cSQLStr);
*/

	function getRowsFromDB($p0,$p1,$p2,$p3,$p4){
		global $conn; // Add connection reference
		
		$par	= "";
		
		$cSQLStr 	= "spSysDataGeneral ''
							,'AKTIF','".$_SESSION['sMISAppuid']."'
							,'FIND APPROVAL PR LEVEL'
							,'{21D31F56-5E5F-4A50-8FF3-49ED4B1386EA}'
							,'{0C970FC3-AE31-4590-8F6D-AC223589FB9D}'
							,'{A9181B9F-C5EC-4EFD-9BA0-27DA7B21DB6B}'
							,'{67A7CA7E-48A7-4B56-8C75-A63D2CF54A30}',''";
							
		$qrApproval = sqlsrv_query($conn, $cSQLStr);
		if($qrApproval === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		
		if($rsApproval = sqlsrv_fetch_array($qrApproval, SQLSRV_FETCH_ASSOC)){
			$bApproval0 = trim($rsApproval['APPROVAL0']);
			$bApproval1 = trim($rsApproval['APPROVAL1']);
			$bApproval2 = trim($rsApproval['APPROVAL2']);
			$bApproval3 = trim($rsApproval['APPROVAL3']);
		}

		switch($p0){ 
			default:
				$DepartmentID = "{D323E69F-95EC-4657-B8CE-1E5E825CC938}";

				$cSQLStr 	= "spSysDataMTLPR '','','','','','','','','',''
									,'','','','','','','','','',''
									,'".$DepartmentID."','','','','','','','',''
									,'','','','','','','','','',''
									,'AKTIF','".$_SESSION['sMISAppuid']."'
									,'LIST','".$p1."','".TglddmmyyyytoMySql($p2)."'
									,'".TglddmmyyyytoMySql($p3)."','',''";
			break;
		}
			
		$qrData = sqlsrv_query($conn, $cSQLStr);
		if($qrData === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		
		if($qrData){
			$iIdx = 0;
			while($rs = sqlsrv_fetch_array($qrData, SQLSRV_FETCH_ASSOC)){
				$iIdx++;
				
				$CSTATUS='CREATED';	
				if(trim($rs['APPROVED3ID'])!=""){
					$CSTATUS='APPROVAL 4';	
				}
				elseif(trim($rs['APPROVED2ID'])!=""){
					$CSTATUS='APPROVAL 3';	
				}
				elseif(trim($rs['APPROVED1ID'])!=""){
					$CSTATUS='APPROVAL 2';	
				}
				elseif(trim($rs['APPROVEDID'])!=""){
					$CSTATUS='APPROVAL 1';	
				}
				
				$cStyle = "style='font-weight: bold;'";
				if($CSTATUS=="CREATED"&&$bApproval0!=''){
					$cStyle = "style='font-weight: bold; color: #0a9100;'";
				}
				elseif($CSTATUS=="APPROVAL 1"&&$bApproval1!=''){
					$cStyle = "style='font-weight: bold; color: #0a9100;'";
				}
				elseif($CSTATUS=="APPROVAL 2"&&$bApproval2!=''){
					$cStyle = "style='font-weight: bold; color: #0a9100;'";
				}
				elseif($CSTATUS=="APPROVAL 3"&&$bApproval3!=''){
					$cStyle = "style='font-weight: bold; color: #0a9100;'";
				}
				elseif($CSTATUS=="APPROVAL 4"){
					$cStyle = "";
				}
				
//				$cStyle = " style='padding-bottom: 1px; padding-top: 1px;' ";
				$cToolTip = "";
				if($rs['APPROVESTATUS']==1){
					$cStyle = " style='padding-bottom: 1px; padding-top: 1px; font-weight: bold;' ";
					$cToolTip = " title='Pergantian Item Sudah Disetujui'";
				}
				elseif($rs['APPROVESTATUS']==2){
					$cStyle = " style='padding-bottom: 1px; padding-top: 1px; color: #f44141; font-weight: bold;' ";
					$cToolTip = " title='Pergantian Item Tidak Disetujui'";
				}
				elseif($rs['APPROVESTATUS']==3){
					$cStyle = " style='padding-bottom: 1px; padding-top: 1px; color: #FF9900; font-weight: bold;' ";
					$cToolTip = " title='Pergantian Item Membutuhkan Persetujuan'";
				}

				//create xml tag for grid row
				print("<row id='".$rs['CID']."' ".$cStyle." ".$cToolTip.">");
					print("<cell ".$cToolTip."><![CDATA[".$iIdx."]]></cell>");
					print("<cell ".$cToolTip."><![CDATA[".$rs['PRNO']."]]></cell>");
					print("<cell ".$cToolTip."><![CDATA[".$rs['JO']."]]></cell>");
					print("<cell ".$cToolTip."><![CDATA[".$rs['TANGGAL']."]]></cell>");
					print("<cell ".$cToolTip."><![CDATA[".$rs['PROJECTTITLE']."]]></cell>");
					print("<cell ".$cToolTip."><![CDATA[".$CSTATUS."]]></cell>");
					print("<cell ".$cToolTip."><![CDATA[".$rs['PRTYPE']."]]></cell>");
					//close xml tag for the row
				print("</row>");
			}

		}else{
			echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
		}
	}
//XML HEADER
//include XML Header (as response will be in xml format)
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}
echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"); 
?>
<!-- start grid xml -->
<rows>
<?php
	//print tree XML
	getRowsFromDB($_GET['p0'],$_GET['p1'],$_GET['p2'],$_GET['p3'],$_GET['p4']);
	//Close db connection
//	mysql_close($link);
?>
<!-- close grid xml -->
</rows>

<?php
// Close connection at the end of the file
sqlsrv_close($conn);
?>
