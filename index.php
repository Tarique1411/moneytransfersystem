<?php
$servername='localhost';
$username='root';
$password='';
$dbname = "money_t";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(!$conn){
   die('Could not Connect My Sql:' .mysql_error());
}
?>
<?php
if(isset($_POST['sendotp']))
{	require('textlocal.class.php');
     require('credential.php');

                $textlocal = new Textlocal(false, false, API_KEY);

                // You can access MOBILE from credential.php
                // $numbers = array(MOBILE);
                // Access enter mobile number in input box
                $numbers = array($_POST['mobile']);

                $sender = 'TXTLCL';
                $otp = mt_rand(10000, 99999);
                $message = "Hello " . $_POST['username'] . " This is your OTP: " . $otp;

                try {
                    $result = $textlocal->sendSms($numbers, $message, $sender);
                    echo "OTP successfully send..";
                } catch (Exception $e) {
                    die('Error: ' . $e->getMessage());
                } 
	 $username = $_POST['username'];
	 $name = $_POST['name'];
	 $email = $_POST['email'];
	 $gender = $_POST['gender'];
	 $password = $_POST['password'];
	 $mobile = $_POST['mobile'];
	 $type = 'employee';
	 $sql = "INSERT INTO users (username,name,email,gender,password,mobile,type,otp)
	 VALUES ('$username','$name','$email','$gender','$password','$mobile','$type','$otp')";
	 if (mysqli_query($conn, $sql)) {
		echo "Please Check Your Phone !";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}
?>
<?php include 'config/Database.php' ?>
<?php
	if(isset($_GET["verifyotp"])){
		$db = new Database();
		$query = "SELECT * FROM users WHERE otp = '$_GET[otp]'";
		$result = $db->select($query);
		if($result){
			session_start();
			$rows = $result->fetch_assoc();
			$_SESSION['username'] = $rows['username'];
			$_SESSION['name'] = $rows['name'];
			$_SESSION['email'] = $rows['email'];
			$_SESSION['type'] = $rows['type'];
			$_SESSION['gender'] = $rows['gender'];
			$_SESSION['password'] = $rows['password'];
			$_SESSION['mobile'] = $rows['mobile'];
			
			header('Location: '.'dashboard.php');
		}

	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Your Website</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script type="text/javascript"></script>
</head>
<body id="login">
	<div class="login-container">
		<img src="css/img/login.png">
		<form action="index.php" method="POST">
			<div class="login-input">
				<input type="text" name="username" placeholder="Enter Username">
			</div>
			<div class="login-input">
				<input type="text" name="name" placeholder="Enter Name">
			</div>
			<div class="login-input">
				<input type="text" name="email" placeholder="Enter email">
			</div>
			<div class="login-input">
				<input type="radio" id="male" name="gender" value="male">
                  <label for="male">Male</label><br>
                   <input type="radio" id="female" name="gender" value="female">
					<label for="female">Female</label><br>
					<input type="radio" id="other" name="gender" value="other">
					<label for="other">Other</label>
			</div>
			<div class="login-input">
				<input type="text" name="password" placeholder="Enter Password">
			</div>
			<div class="login-input">
				<input type="text"  name="mobile" placeholder="Enter Mobile">
			</div>
			<input type="submit" name="sendotp" value="Send OTP" class="btn-login">
		</form>
		<form method="get" action="">
                <div class="col-sm-9 form-group">
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" maxlength="5" required="">
                </div>
                <div class="col-sm-9 form-group">
                    <button type="submit" name="verifyotp" class="btn-login">Verify</button>
                </div>
        </form>
	</div>
</body>
</html>