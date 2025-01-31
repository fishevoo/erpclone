<?php
session_start();
//==============================================
// eng_ot_list.php
// Copyright (c) 2016 MIS Karunia Berca Indonesia
//==============================================
if(empty($_SESSION['sMISAppuid'])){
	header("Location: xlogout.php");
}

	include_once("syst/xproc.php");
	include_once("syst/xparam.php");
	include_once("syst/xfunct.php");
	
	$DepartmentID 	= "D323E69F-95EC-4657-B8CE-1E5E825CC938";
	$IDMenu 		= "CD08257F-F8B4-4F21-9E81-5B9D8A3D62DB";
	include_once("syst/xotor.php");

	function getRowsFromDB($p0,$p1,$p2,$p3,$p4){
		$par	= "";
		$p2		= str_replace("'","''",$p2);
		
		$cSQLStr 	= "spSysDataHRDStaffOT '','','','','','','','','','','','',''
						,'AKTIF','".$_SESSION['sMISAppuid']."'
						,'LIST','".TglddmmyyyytoMySql($p1)."','".TglddmmyyyytoMySql($p2)."'
						,'".$p3."','',''";
//exit($cSQLStr);

		$qrData=mssql_query($cSQLStr);  	
		if($qrData){
			$iIdx = 0;
			while($rs=mssql_fetch_array($qrData)){
				$iIdx++;
				
				$cSStatus = "";
				if($rs['SSTATUS']!='APPROVED'){
					$cSStatus = "style='font-weight: bold;'";
				}
				
				if($CID!=$rs['CID']){
					$CID=$rs['CID'];
					$Tanggal = $rs['TANGGAL'];
					$Department = $rs['DEPARTMENT'];
					$Location = $rs['LOCATION'];
					$SSTATUS = $rs['SSTATUS'];
					$ApprovedByDate = $rs['APPROVEDBYDATE'];
				}
				else{
					$Tanggal = '';
					$Department = '';
					$Location = '';
					$SSTATUS = '';
					$ApprovedByDate = '';	
				}
				
				//create xml tag for grid row
				print("<row ".$cSStatus." id='".$rs['CID'].":".$rs['TANGGALOT']."'>");
					print("<cell><![CDATA[".$iIdx."]]></cell>");
					print("<cell><![CDATA[".$Tanggal."]]></cell>");
					print("<cell><![CDATA[".$Department."]]></cell>");
					print("<cell><![CDATA[".$Location."]]></cell>");
					print("<cell><![CDATA[".$SSTATUS."]]></cell>");
					print("<cell><![CDATA[".$ApprovedByDate."]]></cell>");
					print("<cell><![CDATA[".$rs['TANGGALOT']."]]></cell>");
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
