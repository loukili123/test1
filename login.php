<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>Connexion</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
require('db.php');
session_start();
if (isset($_POST['username'])){
	$username = stripslashes($_REQUEST['username']);
	$username = mysqli_real_escape_string($con,$username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($con,$password);
        $query = "SELECT * FROM `users` WHERE username='$username'
and password='".md5($password)."'";
	$result = mysqli_query($con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
        if($rows==1){
	    $_SESSION['username'] = $username;
	    header("Location: chat.php");
         }else{
	echo "<div class='form'>
<h3>nom d'utilisateur ou mot de passe incorrect</h3>
<br/>Cliquez ici pour <a href='login.php'>se connecter</a></div>";
	}
    }else{
?>
<div class="form">
<h1>Connexion</h1>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Nom d'utilisateur" required />
<input type="password" name="password" placeholder="Mot de passe" required />
<br>
<input name="submit" type="submit" value="Se connecter" />
</form>
<p>vouc n'etes pas encore inscris ? <a href='registration.php'>s'inscrire</a></p>
</div>
<?php } ?>
</body>
</html>
