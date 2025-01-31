<?php
session_start();
//==============================================
// eng_data_jo_list.php
// Copyright (c) 2016 MIS Karunia Berca Indonesia
//==============================================
if(empty($_SESSION['sMISAppuid'])){
	header("Location: xlogout.php");
}

	include_once("syst/xproc.php");
	include_once("syst/xparam.php");
	include_once("syst/xfunct.php");
	
//	$IDMenu 	= "{43EA2211-0C46-4D81-923D-359D983C9A5A}";
//	include_once("syst/xotor.php");

/*
$p0 = $_GET['p0'];
$p1 = $_GET['p1'];
$p2 = $_GET['p2'];
$p3 = $_GET['p3'];
$p4 = $_GET['p4'];
$p5 = $_GET['p5'];

		$cSQLStr 	= "spSysDataMTLRAIR '','','','','','','','','',''
							,'','','','','','','','','','','','','','','','','','','',''
							,'','','','','',''
							,'AKTIF','".$_SESSION['sMISAppuid']."'
							,'LIST','".$p2."','".$p3."'
							,'".TglddmmyyyytoMySql($p4)."','".TglddmmyyyytoMySql($p5)."',''";
echo $cSQLStr;
exit();
*/

	function getRowsFromDB($p0,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9){
		$par	= "";
		
		$cSQLStr 	= "spSysDataENGJO '','','','','','','','','','','','',''
							,'AKTIF','".$_SESSION['sMISAppuid']."'
							,'LIST','".$p1."','".$p2."','','',''";
		
		//echo($cSQLStr);
		//exit;
			
		$qrData=mssql_query($cSQLStr);  
		if($qrData){
			$iIdx = 0;
			while($rs=mssql_fetch_array($qrData)){
				$iIdx++;
				//create xml tag for grid row
				print("<row id='".$rs['CID']."'>");
					print("<cell><![CDATA[".$iIdx."]]></cell>");
					print("<cell><![CDATA[".$rs['JO']."]]></cell>");
					print("<cell><![CDATA[".$rs['PROCKODE']."]]></cell>");
					print("<cell><![CDATA[".$rs['Client']."]]></cell>");
					print("<cell><![CDATA[".$rs['ENGPENAME']."]]></cell>");
					print("<cell><![CDATA[".$rs['ENGPEEMAIL']."]]></cell>");
					print("<cell><![CDATA[".$rs['CSTATUS']."]]></cell>");
					//close xml tag for the row
				print("</row>");
			}
			if($iIdx==0){
				print("<row id='Kosong' style='font-weight:bold;color:red'>");
					print("<cell><![CDATA[]]></cell>");
					print("<cell><![CDATA[]]></cell>");
					print("<cell><![CDATA[]]></cell>");
					print("<cell><![CDATA[DATA TIDAK DITEMUKAN]]></cell>");
					print("<cell><![CDATA[]]></cell>");
					print("<cell><![CDATA[]]></cell>");
					print("<cell><![CDATA[]]></cell>");
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
	getRowsFromDB($_GET['p0'],$_GET['p1'],$_GET['p2'],$_GET['p3'],$_GET['p4'],$_GET['p5'],$_GET['p6'],$_GET['p7'],$_GET['p8'],$_GET['p9']);
	//Close db connection
//	mysql_close($link);
?>
<!-- close grid xml -->
</rows>
