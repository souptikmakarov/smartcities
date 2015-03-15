<!DOCTYPE html>
<?php 
	$source=$destination=$totfare="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$hash=$_POST['hash'];
		$connection=mysql_connect("localhost","root","")
				or die("Error");

		$db=mysql_select_db("test",$connection);
		$ticketid=substr($hash,32);
		$hashcode=substr($hash,0,32);

		$idget="select id from hashtable where hashvalue='".$hashcode."';";
		$idrun=mysql_query($idget)
			or die(mysql_error());
		$resid=mysql_fetch_array($idrun);
		$id=$resid['id'];
		
		$fareget="select fare from fare where uniqueid=".$id.";";
		$farerun=mysql_query($fareget)
			or die(mysql_error());
		$resfare=mysql_fetch_array($farerun);
		$fare=$resfare['fare'];

		$detailget="select source,destination,no_ticket from ticket where ticketid=".$ticketid.";";
		$detailrun=mysql_query($detailget)
			or die(mysql_error());
		$resdet=mysql_fetch_array($detailrun);
		$source=$resdet['source'];
		$destination=$resdet['destination'];
		$noofticket=$resdet['no_ticket'];
		$totfare=$fare*$noofticket;
	}
 ?>
<html>
	<head>
		<title>QR Code scanner</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="scanner">
		</div>
		<div id="errorsndata">
			<h2>Read Data</h2>
			<span id="read"></span>
			<h2>Read Error</h2>
			<span id="read_error"></span>
			<h2>Video Error</h2>
			<span id="vid_error"></span>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<input type="text" id="hash" name="hash">
				<input type="submit" value="Submit">
			</form>
			<span><?php echo "Source:".$source ?></span><br>
			<span><?php echo "Destination:".$destination ?></span><br>
			<span><?php echo "Total Fare:".$totfare ?></span><br>
		</div>
		<script type="text/javascript" src="http://localhost/hackathon/lib/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="http://localhost/hackathon/lib/html5-qrcode.min.js"></script>
		<script type="text/javascript" src="http://localhost/hackathon/java.js"></script>
	</body>
</html>