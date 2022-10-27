<?php
include '../config/db_connect.php';
include '../config/function.php';

$email=isset($_GET['txtemail']) ? $_GET['txtemail'] : '';

if($_GET[act]=='sub' && !empty($email))
{
	$qry = "SELECT u_email1 FROM tbl_user WHERE u_email1 =  '$email' ";
	$res=mysqli_query($conni,$qry) or die (mysqli_error());
	//$row=mysqli_fetch_array($res);
	$count=mysqli_num_rows($res);
	if($count<>0) 
	{			
		require("../PHPMailer/PHPMailerAutoload.php");
		require("PHPMailerConfig.php");
	
		//$footer="<p>&nbsp;</p>";
		//$footer="<p></p>";
		$footer.="<p>Thank you.<br>Please do not reply to this email as it was automatically generated.</p>";
		
		$qry1 = "SELECT * FROM tbl_user WHERE u_email1 =  '$email' ";
		$res1=mysqli_query($conni,$qry1) or die (mysqli_error());
		//$row1=mysqli_fetch_array($res1);
		while($row1=mysqli_fetch_array($res1)) 
		{
			if($row1[u_status]==19) $sts='Active'; else $sts='In-Active';		
			$subject="Forgot password";
			$message="Dear $row1[u_fname], <br><br>";
			$message.="You're receiving this email because you requested a forgot password. Below are username and password for you access the system.<br><br>";
			$message.="Username : $row1[u_username]<br>";
			$message.="Password : $row1[u_password]<br>";
			$message.="Status 	: $sts";
			$message.="<p>You can sign in the HRMHS by using this link, ".$_SERVER['HTTP_HOST']."</p>";
			
			$message.=$footer;
			$mail->Subject = $subject;
			$mail->Body    = $message;
			$mail->addAddress($row1[u_email1],'');
			$mail->Send();
		  $mail->ClearAddresses();
		}		
		auditlog('Forgot password','Request password for email address '.$email);
		$success=1;
	}else{
		$success=2;
	}
}

?>

<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="robots" content="noindex,nofollow">
<title>HRMHS - Forgot Password</title>

<script>
	
function sub()
{	
	var e = document.frm.txtemail.value;
	//alert(e);
	//var conf = confirm ("Do you wish to proceed?")
	//if (conf)
	//{
		document.getElementById("progress").style.visibility = "visible";
		document.frm.action="index.php?act=sub&txtemail="+e;
		document.frm.method="post";
		document.frm.submit();
	//}else{
		//document.getElementById('btnsubmit1').disabled = false; }
}
</script>

<style type="text/css">

.tbl
{ 
	border-radius: 20px 20px 20px 20px;
	-moz-border-radius: 20px 20px 20px20px;
	-webkit-border-radius: 20px 20px 20px20px;	
	border-collapse:collapse;
	box-shadow:0 1px 25px rgba(0,0,0,0.5);

}
.headr
{
	border-collapse:collapse;
	/*background-color: #4d4dff;*/
	background: #012060;
	background: linear-gradient(to bottom, #012060 0%, #D1D1D1 100%);
	border-radius: 20px 20px 0px 0px;
	color: #FFF; /*#E51B23;*/
	padding:5px;
}
.ftr
{
	border-collapse:collapse;
	background-color: #E51B23;
	border-radius: 0px 0px 20px 20px;
	font-family:Calibri;
	font-size:13px;
	color:#FFF;
	font-weight:400;
}


body{background:#F0F0F0 url("images/body_background.jpg") repeat; text-shadow: 0px 1px 1px #FFF;font: 70%/1.6em Verdana;}


.headg {
	font-family:Verdana, Geneva, Tahoma, sans-serif;
	font-size:22px;
	color: #FFF; 
	padding:5px;
}

.modtit {
	font-family:Tahoma;
	color:#CD5C5C; 
	font-size:26px;
	font-weight:600;	
	text-align:center;
}

body, html {
	background:#FFFFFF;
	/*height: 99%;*/
	font-family:"Segoe UI", Tahoma, Geneva, Verdana;
}

.txt {
	font:normal 14px Calibri;
	color:#4682B4;
	font-weight: 500;
}
.hdr {
	color:#3366CC;
	font-weight:600;
	padding: 5px;
}

* {
  box-sizing: border-box;
}

.center {
  margin: auto;
  margin-top: 30px;
  max-width: 600px;
  border-radius: 5px;
  padding: 10px;
  border: 1px solid #ccc;
  background-color: #FFFAFA; 
  box-shadow:0 1px 25px rgba(0,0,0,0.5);
}

input[type=text] {  
  width: 80%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  color:#006699;
  font-weight:500;
  font-size:14px;

}
.btn {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  border: none;
  cursor: pointer;
  width: 130px;
  opacity: 0.9;
  border-radius: 5px;
}

.btn:hover {
  opacity: 1;
}

.msgtext {
	font-size: 16px;
	color:#003399;
	font-weight:500;
	/*text-shadow: 0 -1px rgba(0, 0, 0, 0.4); 4682B4*/
	
}
#progress{
	font-family:Calibri;
	font-size:18px;
	color:#FF3300;
	font-weight:500;
    background-color:transparent;
    border: none;
}
.blink_text {

    animation:1s blinker linear infinite;
    -webkit-animation:1s blinker linear infinite;
    -moz-animation:1s blinker linear infinite;

     color: red;
    }

    @-moz-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @-webkit-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
}
</style>
</head>

<body>
<div style="margin-top:80; width:100%;">
	<table align="center" width="1000px" height="550px" class="tbl">
		<tr>
			<td>
				<table width="100%" border="0" height="100%" style="border-collapse:collapse">
					<tr>
						<td class="headr" height="100px">
							<table width="100%" border="0" style="border-collapse:collapse">
								<tr>
									<td width="70%" align="left" class="headg"><strong>HUMAN RESOURCES MANAGEMENT HELPDESK SYSTEM</strong></td>
									<td align="right"><img src="../images/kpjlogo.png"></td>
								</tr>
							</table>
						</td>		
					</tr>
					<tr>
						<td valign="top">
							<div class="center" >						
								<table width="100%">
									<tr>
										<td class="hdr" valign="bottom">Forgot Password</td>
										<td align="right"><a href="#" onclick="javascript:window.close();">Close</a></td>
									</tr>
								</table>
								<?php if($success==1) { ?>
									<div align="center">
										<p class="msgtext">Thank you.</p>
										<p class="msgtext">An email has been sent to the address you provided.</p>
										<p>&nbsp;</p>	
									</div>
								<?php }elseif($success==2){ ?>
									<div align="center">
										<p class="msgtext">Sorry, the email you entered does not exist.</p>
										<p class="msgtext">Click <a href="#" onclick=window.location.href='index.php'>here</a> to try again</p>
										<p>&nbsp;</p>
									</div>
								<?php }else{ ?>
									<div>	
										<form name=frm>
											<p align="center"><input type="text" name="txtemail" placeholder="Please enter your email here..." onchange="isValidEmail(this.value)" required autocomplete="off" value="<?php echo $email ?>"></p>
											<p align="center"><button type="submit" id="btnsubmit1" onclick="this.disabled=true;sub()" class="btn" >Submit</button></p>
										</form>		
										
										<p align="center" class="txt">
											Enter the email address you used when creating the account and click Submit. A message will be sent to that address containing your password.
										</p>
										<p align="center"><input name="progress" id="progress" class="blink_text" value='Please wait, while email are sending to you...' style='width:100%;visibility :hidden;text-align:center'></p>
									</div>
								<?php } ?>
								
								
							</div>
						</td>
					</tr>
					<tr><td height="50" class="ftr" align="center" >			 
					    Copyright &copy; 2015. KPJ Healthcare Berhad. All Rights Reserved.<br/>Designed &amp; Developed by eqlazbiz				
					</td></tr>
				</table>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
