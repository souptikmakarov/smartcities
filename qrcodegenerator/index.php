<!DOCTYPE html>
<?php
	$sourceErr = $destinationErr = $valueErr = $ticketErr = $final = $hash = "";
	$check1 = $check2 = $check3 = false;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($_POST["source"] == "Select Your Source")
			$sourceErr = "Please Select Another Option";
		else {
			$source = test_input($_POST["source"]);
			if ($_POST["source"] == $_POST["destination"])
				$valueErr = "Please Select Different Options";
			else
				$check1=true;
		}
		if ($_POST["destination"] == "Select Your Destination")
			$destinationErr = "Please Select Another Option";
		else {
			$destination = test_input($_POST["destination"]);
			if ($_POST["source"] == $_POST["destination"])
				$valueErr = "Please Select Different Options";
			else
				$check2=true;
		}
		if (empty($_POST["ticket"]) || $_POST["ticket"] == 0)
			$ticketErr = "Select at least One Ticket";			
		else{
			$ticket = test_input($_POST["ticket"]);
			$check3=true;
		}
	}
	function test_input($data) {
    	$data = trim($data);
	 	$data = stripslashes($data);
	 	$data = htmlspecialchars($data);
		return $data;
	}
	if($check1==true && $check2==true && $check3==true ){
		$final="All values stored";
		$connection=mysql_connect("localhost","root","")
			or die("Error");

		$db=mysql_select_db("test",$connection);
		$query="insert into ticket values(null,'".$source."','".$destination."',".$ticket.");";
		$result=mysql_query($query)
			or die(mysql_error());
		$getkey="select ticketid from ticket order by ticketid desc;";
		$getkeyresult=mysql_query($getkey)
			or die(mysql_error());
		$keyrow=mysql_fetch_array($getkeyresult);
		$key=$keyrow['ticketid'];

		$sourceid="select id from placeid where place='".$source."';";
		$destinationid="select id from placeid where place='".$destination."';";
		$resultsource=mysql_query($sourceid)
			or die(mysql_error());
		$resultdestination=mysql_query($destinationid)
			or die(mysql_error());

		$ressrc=mysql_fetch_array($resultsource);
		$resdest=mysql_fetch_array($resultdestination);
		$src=$ressrc['id'];
		$dest=$resdest['id'];

		$concat=$src.$dest;
		$md5get="select hashvalue from hashtable where id=".$concat.";";
		$md5=mysql_query($md5get)
			or die(mysql_error());
		$resmd5=mysql_fetch_array($md5);
		$hash=$resmd5['hashvalue'].$key;
	}
	
?>
<html>
	<head>
		<title>QR Code Generator</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<img class="bus" src="bus2.jpg">
		<div class="content">
			<h1>Generate your ticket here</h1>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<table>
					<tr>
						<td>
							<select name="source">
								<option>Select Your Source</option>
								<option id="one">Patia Chowk</option>
								<option id="two">Damana Chowk</option>
								<option id="three">Pal Heights</option>
								<option id="four">Jaidev Vihar Chowk</option>
								<option id="five">Master Canteen Chowk</option>
							</select>
							<span class="error">&nbsp; <?php echo $sourceErr;?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<select name="destination">
								<option>Select Your Destination</option>
								<option id="one">Patia Chowk</option>
								<option id="two">Damana Chowk</option>
								<option id="three">Pal Heights</option>
								<option id="four">Jaidev Vihar Chowk</option>
								<option id="five">Master Canteen Chowk</option>
							</select>
							<span class="error">&nbsp; <?php echo $destinationErr;?></span>
							<p><span class="error">&nbsp; <?php echo $valueErr;?></span></p>
						</td>
					</tr>
					<tr>
						<td>Enter the no of tickets</td>
					</tr>
					<tr>
						<td><input type="number" min="0" name="ticket"></td>
						<td><span class="error">&nbsp; <?php echo $ticketErr;?></span></td>
					</tr>
				</table>
				<br>
				<div class="submitbutton" id="submitbutton">Generate ticket</div>
				<span class="final"><?php echo $final;?></span>
			</form>
			<input id="text" type="hidden" value="<?php if(isset($hash)){echo $hash;} ?>"><br>
			<div><?php echo $hash ?></div>
			<div id="qrcode" style="width:100px; height:100px; margin-top:15px;"></div>
		</div>
		<div class="footer">Site designed by Souptik Banerjee, Puranjan Banerjee, Arnab Debnath</div>
		<script type="text/javascript" src="http://localhost/hackathon/qrcodegenerator/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="http://localhost/hackathon/qrcodegenerator/qrcode.js"></script>
		<script type="text/javascript" src="http://localhost/hackathon/qrcodegenerator/java.js"></script>
	</body>
</html>