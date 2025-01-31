<?php
session_start();
//==============================================
// eng_pr_mtl.php
// Copyright (c) 2014 Web4UKM
//==============================================
if(empty($_SESSION['sMISAppuid'])){
	header("Location: xlogout.php");
}

	include_once("syst/xproc.php");
	include_once("syst/xparam.php");
	include_once("syst/xfunct.php");

	$MainPage 	= "Input Data";
	$SubMenu 	= "ENGINEERING";
	$SubPage 	= "Raw Material PR";
	$TitlePage 	= "Daftar Raw Material PR";
	
	$DepartmentID = "{D323E69F-95EC-4657-B8CE-1E5E825CC938}";

	$IDMenu 	= "{4A0168BE-744A-4ABB-9420-B862D61B4FAD}";
	include_once("syst/xotor.php");

	$Tanggal1	= "01/".$cBln."/".$cThn;
	$Tanggal2	= fMaxHariBulan($cBln,$cThn)."/".$cBln."/".$cThn;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $TitlePage." - ".$pSKAppNamaAplikasi;?></title>
<?php 
	include_once('incl/meta.php');
?>
<script  src="codebase/baru/dhtmlxcommon.js"></script>
<script  src="codebase/baru/dhtmlxgrid.js"></script>        
<script  src="codebase/baru/dhtmlxgridcell.js"></script>    
<script>
	var myCalendar;
	function doOnLoad() {
		myCalendar1 = new dhtmlXCalendarObject({input: "Tanggal1", button: "Tanggal1Icon"});
		myCalendar2 = new dhtmlXCalendarObject({input: "Tanggal2", button: "Tanggal2Icon"});
		
		myCalendar1.attachEvent("onClick", function(){
			fCari(frmData);
		});

		myCalendar2.attachEvent("onClick", function(){
			fCari(frmData);
		});

	}
</script>
</head>
<body> 
<div class="header">
<?php 
	include_once('incl/logo.php');
	include_once('incl/menu.php');
?>
</div>
<div class="content" style="min-height: 435px;">
    <h4><a id="LinkAtas"></a><?php echo $TitlePage;?></h4>
    <div class="line"></div>
    <form name="frmData" method="post">
    <input type="hidden" name="hdFrom" value="" />
    <input type="hidden" name="CID" value="" />
    <input type="hidden" name="PersonalID" value="" />
    <input type="hidden" name="TitlePage" value="<?php echo $TitlePage;?>" />
  <div class="GridSplit" style="float: left;">
        <div id="toolbar2">
        	<div style="float: left; padding-top: 1px; font-size:12px; font-weight: bold;">No. PR : <input name="Cari" type="text" class="form" id="Cari" value="" size="25" style="margin-bottom: 5px;" onkeyup="fCari(frmData)" />
Periode : <input type="text" id="Tanggal1" name="Tanggal1" class="form" style="width: 80px; text-align: center;" value="<?php echo $Tanggal1;?>" readonly="readonly" /> <img id="Tanggal1Icon" src="images/calendar.gif" border="0" height="25" width="25" align="absbottom" style="margin-bottom: 4px;" /> s/d <input type="text" id="Tanggal2" name="Tanggal2" class="form" style="width: 80px; text-align: center;" value="<?php echo $Tanggal2;?>" readonly="readonly" /> <img id="Tanggal2Icon" src="images/calendar.gif" border="0" height="25" width="25" align="absbottom" style="margin-bottom: 4px;" /> 
            </div>
        <a class="toolbar" href="#" style="padding: 3px 5px 2px 5px;" onclick="fRefresh(frmData)"><img src="images/reload_f2.png" width="18" height="18" border="0" align="left" id="Refresh" title="Refresh" style="margin-right: 5px" />Refresh</a>
<?php
	$bHakProcessPRGabungan = false;
	$cFungsiProcess = "";
	$cFungsiDoSelectedProcess = "";
	if($vHakMenu['858ABDD6-2003-4E47-B966-D076652565F4']){
		$bHakProcessPRGabungan = true;
?>
        <a id="btnProcess" class="toolbar" href="#" style="padding: 3px 5px 2px 5px; display: none;" onclick="fProcess(frmData)"><img src="images/exec.png" width="18" height="18" border="0" align="left" id="Process" title="Process PR" style="margin-right: 5px" />Process</a>
<?php
		$cFungsiProcess = "
		function fProcess(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan ditunda.');
				return;
			}
			else {
				if(confirm('Yakin akan menunda data?')){ 
					F.hdFrom.value = 'PROCESS';
					F.action = 'eng_pr_mtl_x_proses.php';
					F.submit();
				}
			}
		}
		";
		$cFungsiDoSelectedProcess = "
			if(mygrid.cells(rowId,5).getValue()=='PENDING'){
				document.getElementById('btnProcess').style.display = 'block'; 
			}
			else {
				document.getElementById('btnProcess').style.display = 'none'; 
			}
		";
	}

	$bHakOpenPRGabungan = false;
	$cFungsiOpen = "";
	$cFungsiDoSelectedOpen = "";
	if($vHakMenu['FCBF868F-2F88-48D8-81E9-8D2170758F5D']){
		$bHakOpenPRGabungan = true;
?>
        <a id="btnOpen" class="toolbar" href="#" style="padding: 3px 5px 2px 5px; display: none;" onclick="fOpen(frmData)"><img src="images/Open.png" width="18" height="18" border="0" align="left" id="Open" title="Open PR" style="margin-right: 5px" />Open</a>
<?php
		$cFungsiOpen = "
		function fOpen(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan ditunda.');
				return;
			}
			else {
				if(confirm('Yakin akan menunda data?')){ 
					F.hdFrom.value = 'OPEN';
					F.action = 'eng_pr_mtl_x_proses.php';
					F.submit();
				}
			}
		}
		";
		$cFungsiDoSelectedOpen = "
			if(mygrid.cells(rowId,5).getValue()=='CLOSED'){
				document.getElementById('btnOpen').style.display = 'block'; 
			}
			else {
				document.getElementById('btnOpen').style.display = 'none'; 
			}
		";
	}

	$bHakPendingPRGabungan = false;
	$cFungsiPending = "";
	$cFungsiDoSelectedPending = "";
	if($vHakMenu['A70F665E-2DFC-45FA-BF33-C30473A7D18A']){
		$bHakPendingPRGabungan = true;
?>
        <a id="btnPending" class="toolbar" href="#" style="padding: 3px 5px 2px 5px; display: none;" onclick="fPending(frmData)"><img src="images/pendding.png" width="18" height="18" border="0" align="left" id="Pending" title="Pending PR" style="margin-right: 5px" />Pending</a>
<?php
		$cFungsiPending = "
		function fPending(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan ditunda.');
				return;
			}
			else {
				if(confirm('Yakin akan menunda data?')){ 
					F.hdFrom.value = 'PENDING';
					F.action = 'eng_pr_mtl_x_proses.php';
					F.submit();
				}
			}
		}
		";
		$cFungsiDoSelectedPending = "
			if(mygrid.cells(rowId,5).getValue()=='APPROVED'){
				document.getElementById('btnPending').style.display = 'block'; 
			}
			else {
				document.getElementById('btnPending').style.display = 'none'; 
			}
		";
	}

	$bHakCancelPRGabungan = false;
	$cFungsiCancel = "";
	$cFungsiDoSelectedCancel = "";
	if($vHakMenu['5F49C36C-7FBE-4F71-AEBC-DFEE2B1EE13D']){
		$bHakCancelPRGabungan = true;
?>
        <a id="btnCancel" class="toolbar" href="#" style="padding: 3px 5px 2px 5px; display: none;" onclick="fCancel(frmData)"><img src="images/accept_not_icon_32.png" width="18" height="18" border="0" align="left" id="Cancel" title="Cancel PR" style="margin-right: 5px" />Cancel</a>
<?php
		$cFungsiCancel = "
		function fCancel(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan ditutup.');
				return;
			}
			else {
				if(confirm('Yakin akan menutup data?')){ 
					F.hdFrom.value = 'CANCEL';
					F.action = 'eng_pr_mtl_x_proses.php';
					F.submit();
				}
			}
		}
		";
		$cFungsiDoSelectedCancel = "
			if(mygrid.cells(rowId,5).getValue()=='APPROVED'){
				document.getElementById('btnCancel').style.display = 'block'; 
			}
			else {
				document.getElementById('btnCancel').style.display = 'none'; 
			}
		";
	}

	$bHakClosePRGabungan = false;
	$cFungsiClose = "";
	$cFungsiDoSelectedClose = "";
	if($vHakMenu['5BA586A5-5AF0-42FF-9DDA-2F003EB2DC21']){
		$bHakClosePRGabungan = true;
?>
        <a id="btnClose" class="toolbar" href="#" style="padding: 3px 5px 2px 5px; display: none;" onclick="fClose(frmData)"><img src="images/agt_action_fail.png" width="18" height="18" border="0" align="left" id="Close" title="Close PR" style="margin-right: 5px" />Close</a>
<?php
		$cFungsiClose = "
		function fClose(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan ditutup.');
				return;
			}
			else {
				if(confirm('Yakin akan menutup data?')){ 
					F.hdFrom.value = 'CLOSE';
					F.action = 'eng_pr_mtl_x_proses.php';
					F.submit();
				}
			}
		}
		";
		$cFungsiDoSelectedClose = "
			if(mygrid.cells(rowId,5).getValue()=='APPROVED'){
				document.getElementById('btnClose').style.display = 'block'; 
			}
			else {
				document.getElementById('btnClose').style.display = 'none'; 
			}
		";
	}

	$bHakHapusPRGabungan = false;
	$cFungsiHapus = "";
	$cFungsiDoSelected = "";
	if($vHakMenu['1B6212FA-1633-49D0-852A-B5FE3664AADB']){
		$bHakHapusPRGabungan = true;
?>
        <a id="btnHapus" class="toolbar" href="#" style="padding: 3px 5px 2px 5px; display: none;" onclick="fHapus(frmData)"><img src="images/db_remove.png" width="18" height="18" border="0" align="left" id="Delete" title="Delete PR Gabungan" style="margin-right: 5px" />Delete</a>
<?php
		$cFungsiHapus = "
		function fHapus(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan dihapus.');
				return;
			}
			else {
				if(confirm('Yakin akan menghapus data?')){ 
					mygrid.deleteSelectedItem();
					fRefresh(F);
				}
			}
		}
		";
		$cFungsiDoSelected = "
			if(mygrid.cells(rowId,5).getValue()=='CREATED'){
				document.getElementById('btnHapus').style.display = 'block'; 
			}
			else {
				document.getElementById('btnHapus').style.display = 'none'; 
			}
		";
	}

	$cFungsiTambah = "";
	if($vHakMenu['0D716CB2-B3FB-469B-83FE-799519A8F850']){
?>
        <a class="toolbar" href="#" style="padding: 3px 5px 2px 5px;" onclick="fTambah(frmData);"><img src="images/db_add.png" width="18" height="18" border="0" align="left" id="AddNew" title="Add New PR Gabungan" style="margin-right: 5px;" />Add New</a>
<?php
		$cFungsiTambah = "
        function fTambah(F) {
			F.action = 'eng_pr_mtl_add.php';
			F.submit();
        }
		";
	}

	$cFungsiView = "";
	if($vHakMenu['A26CFD46-259B-4C1C-BDFA-9C159A82D8C7']){
		$cFungsiView = "
		function fView(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan ditampilkan.');
				return;
			}
			fWPilih('WViewPRGabungan','eng_pr_mtl_wv.php?p0=VIEW PRGabungan ".$TitlePage."&p1='+F.CID.value,'Cetak PRGabungan',40,20,0,0);
		}
		";
?>
        <a class="toolbar" href="#" style="padding: 3px 5px 2px 5px;" onclick="fView(frmData);"><img src="images/acroread.png" width="18" height="18" border="0" align="left" id="ViewPRGabungan" title="View PR Gabungan" style="margin-right: 5px;" />View PR</a>
<?php
	}

	$cFungsiDOEdit = "";
	$cFungsiEdit = "";
	if($vHakMenu['AA5759FE-FC87-46DE-9689-B220C3C48A6C']){
		$cFungsiDOEdit = "
			if(mygrid.cells(rowId,6).getValue()=='MTL'){
				document.frmData.action = 'eng_pr_mtl_edit.php';
				document.frmData.submit();
			}
			else {
				document.frmData.action = 'eng_gnrl_pr_edit.php';
				document.frmData.submit();
			}
		";
		$cFungsiEdit = "
		function fEdit(F){
			if(F.CID.value==''){
				alert('Pilih data yang akan di edit.');
				return;
			}
			document.frmData.action = 'eng_pr_mtl_edit.php';
			document.frmData.submit();
		}
		";
?>
        <a class="toolbar" href="#" style="padding: 3px 5px 2px 5px;" onclick="fEdit(frmData);"><img src="images/edit.png" width="18" height="18" border="0" align="left" id="ViewPRGabungan" title="View PR Gabungan" style="margin-right: 5px;" />Edit PR</a>
<?php
	}
?>
         </div>
	<div id="divTemp" style="height:1px; width: 1px; float:left;background-color:white; display: none;"></div>
    <div id="gridbox" style="width: 100%; height:325px; color: #666666;"></div>
    <script>
<?php
	echo $cFungsiTambah;
	echo $cFungsiView;
	echo $cFungsiSertifikat;
	echo $cFungsiPending;
	echo $cFungsiClose;
	echo $cFungsiCancel;
	echo $cFungsiOpen;
	echo $cFungsiProcess;
	echo $cFungsiEdit;
?>
	
        function fCari(F) {
			mygrid.clearAll(); 
    	    mygrid.loadXML("eng_pr_mtl_list.php?p0=<?php echo $TitlePage;?>&p1="+F.Cari.value+"&p2="+F.Tanggal1.value+"&p3="+F.Tanggal2.value);
        }

<?php
	echo $cFungsiHapus;
?>
		function fRefresh(F){
            F.CID.value	= "";
            F.PersonalID.value	= "";
			F.Cari.value = "";
			F.Tanggal1.value = "<?php echo $Tanggal1;?>";
			F.Tanggal2.value = "<?php echo $Tanggal2;?>";
			mygrid.clearAll(); 
    	    mygrid.loadXML("eng_pr_mtl_list.php?p0=<?php echo $TitlePage;?>&p2=<?php echo $Tanggal1;?>&p3=<?php echo $Tanggal2;?>");
		}

        function doOnRowDblClicked(rowId) {
            document.frmData.CID.value	= rowId;
<?php
	echo $cFungsiDOEdit;
?>			
        }
    	
		function doOnRowSelected(rowId){
            document.frmData.CID.value	= rowId;
<?php
	echo $cFungsiDoSelected;
	echo $cFSertifikatDoSelected;
	echo $cFungsiDoSelectedClose;
	echo $cFungsiDoSelectedCancel;
	echo $cFungsiDoSelectedPending;
	echo $cFungsiDoSelectedOpen;
	echo $cFungsiDoSelectedProcess;
?>
		}
    
        mygrid = new dhtmlXGridObject('gridbox');
        mygrid.setImagePath("codebase/imgs/");
        mygrid.setHeader("<center><b>NO.</b></center>,<center><b>NOMOR</b></center>,<center><b>JO</b></center>,<center><b>TANGGAL</b></center>,<center><b>PROJECT</b></center>,<center><b>STATUS</b></center>,PRTYPE");
        mygrid.setInitWidths("50,150,100,100,*,100,0");
        mygrid.setColAlign("center,center,center,center,left,center,center");
        mygrid.setColTypes("ro,ro,ro,ro,ro,ro,ro");
        mygrid.setColSorting("int,str,str,str,str,str,str");
        mygrid.setSkin("modern");
		mygrid.enableMultiselect(true);
        mygrid.attachEvent("onRowDblClicked", doOnRowDblClicked);
		mygrid.attachEvent("onRowSelect",doOnRowSelected);
        mygrid.setSkin("modern");
        mygrid.init();
        mygrid.loadXML("eng_pr_mtl_list.php?p0=<?php echo $TitlePage;?>&p2=<?php echo $Tanggal1;?>&p3=<?php echo $Tanggal2;?>");
		
		myDataProcessor = new dataProcessor("eng_pr_mtl_x_proses.php"); 	//lock feed url
		myDataProcessor.init(mygrid); 									//link dataprocessor to the grid
		
		myDataProcessor.attachEvent("onFullSync",function(){
			mygrid.clearAll(); 
			mygrid.loadXML("eng_pr_mtl_list.php?p0=<?php echo $TitlePage;?>");
			return true; 
		})	
	</script>
    </div>
	</form>
</div>
<?php 
	include_once('incl/footer.php');
?>
</div>
<script type="text/javascript">
	lebar = screen.width-20;
	tinggi = screen.height-250;
	wlebar = lebar-100;
	wtinggi = tinggi-200;
	var dhxWins = new dhtmlXWindows();

	dhxWins.enableAutoViewport(true);		
	dhxWins.setViewport(0, 0, lebar, tinggi);
	dhxWins.setImagePath("codebase/imgs/");
	dhxWins.setSkin("clear_silver");

	function fWPilih(Nama, URL, cTitle, iAtas, iKiri, iPanjang, iTinggi){
		if(iPanjang==0){
			iPanjang=screen.width-100;
		};
		if(iTinggi==0){
			iTinggi=screen.height-200;
		};
		
		var w1 = dhxWins.createWindow(Nama, iAtas, iKiri, iPanjang, iTinggi);
		w1.setText(cTitle);
		w1.keepInViewport(true); 
		w1.attachURL(URL);
	}

	doOnLoad();
</script>	
</body>
</html>