<?php 
		$PARID = $_GET['PARID'];
		include("DBConnect.php");
		header("Content-Type: image/jpeg");
		$dbhandle = new DBConnect();
		$arr = array(); 
		$dbhandle->connect();
		$dbhandle->select("select * from TBL_DOCUMENT A,TBL_PARTNER_DOCUMENT B where A.DOC_FUNCTION = 2 and A.DOC_ID = B.DOC_ID and 	B.PAR_ID =". $PARID ,$arr); //DOC_FUNCTION pr�ft ob es ein LOGO ist
		$dbhandle->close();
		echo $arr['DOC_CONTENT'][0];
		//echo $arr['DOC_THUMBNAIL'][0];
?>
