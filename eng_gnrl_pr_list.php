<?php
session_start();
//==============================================
// eng_gnrl_pr_list.php
// Copyright (c) 2016 MIS Karunia Berca Indonesia
//==============================================
if(empty($_SESSION['sMISAppuid'])){
	header("Location: xlogout.php");
}

	include_once("syst/xproc.php");
	include_once("syst/xparam.php");
	include_once("syst/xfunct.php");
	
	$IDMenu 	= "{5631F6B9-D58A-4EC3-AB15-B899CB74EA42}";
	include_once("syst/xotor.php");

/*
	$p0 = $_GET['p0'];
	$p1 = $_GET['p1'];
	$p2 = $_GET['p2'];
	$p3 = $_GET['p3'];
	$cSQLStr 	= "spSysDataGNRLPR '','','','','','','','','',''
						,'','','','','','','','','',''
						,'".$_SESSION['sMISAppDepartmentIID']."','','','','','','','',''
						,'','','','','','','','',''
						,'AKTIF','".$_SESSION['sMISAppuid']."'
						,'LIST','".$p1."','".TglddmmyyyytoMySql($p2)."'
						,'".TglddmmyyyytoMySql($p3)."','',''";
exit($cSQLStr);
*/

	function getRowsFromDB($p0,$p1,$p2,$p3,$p4){
		$par	= "";
		$DepartmentID = "{D323E69F-95EC-4657-B8CE-1E5E825CC938}";
		
		$cSQLStr 	= "spSysDataGeneral ''
							,'AKTIF','".$_SESSION['sMISAppuid']."'
							,'FIND APPROVAL PR LEVEL'
							,'{21D31F56-5E5F-4A50-8FF3-49ED4B1386EA}'
							,'{E4E6FCD1-FE31-449D-AC0F-3AA4F69E056F}'
							,'{AB6988C1-0899-4794-82C5-491F3E81C147}'
							,'{60AFF5F1-1E20-4C01-9017-1FF8AE782EC0}',''";
							
		$qrApproval=mssql_query($cSQLStr);  
		if($rsApproval=mssql_fetch_array($qrApproval)){
			$bApproval0 = trim($rsApproval['APPROVAL0']);
			$bApproval1 = trim($rsApproval['APPROVAL1']);
			$bApproval2 = trim($rsApproval['APPROVAL2']);
			$bApproval3 = trim($rsApproval['APPROVAL3']);
		}

		switch($p0){ 
			default:		
			$cSQLStr 	= "spSysDataGNRLPR '','','','','','','','','',''
									,'','','','','','','','','',''
									,'".$DepartmentID."','','','','','','','',''
									,'','','','','','','','',''
									,'AKTIF','".$_SESSION['sMISAppuid']."'
									,'LIST','".$p1."','".TglddmmyyyytoMySql($p2)."'
									,'".TglddmmyyyytoMySql($p3)."','',''";
			break;
		}
//echo $cSQLStr;
			
		$qrData=mssql_query($cSQLStr);  
		if($qrData){
			$iIdx = 0;
			while($rs=mssql_fetch_array($qrData)){
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
				
				//create xml tag for grid row
				print("<row id='".$rs['CID']."' ".$cStyle.">");
					print("<cell><![CDATA[".$iIdx."]]></cell>");
					print("<cell><![CDATA[".$rs['PRNO']."]]></cell>");
					print("<cell><![CDATA[".$rs['TANGGAL']."]]></cell>");
					print("<cell><![CDATA[".$rs['PROJECTTITLE']."]]></cell>");
					print("<cell><![CDATA[".$CSTATUS."]]></cell>");
					print("<cell><![CDATA[".$rs['PRTYPE']."]]></cell>");
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
