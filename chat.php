<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>Chat</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
require('db.php');
session_start();
if(!isset($_SESSION["username"])){
header("Location: login.php");
exit(); }

function afficherTouteLaTable($con){
										$allmessages=mysqli_query($con,"select * from messages order by num desc LIMIT 10;") or die(mysql_error());
										$rows = mysqli_num_rows($allmessages);
										        if($rows>0){
										echo "<br><table>
													<tr>
														<th scope='col'>Propriétaire</th>
														<th scope='col'>Message</th>
														<th scope='col'>Date</th>
													</tr>";
										
										while($row=mysqli_fetch_array($allmessages))
										{
											echo "
											<tr>
												<td>$row[1]</td>
												<td>$row[2]</td>
												<td>$row[3]</td>
											</tr>
											";
										}
													
										echo "
												</table>
										";
												}
									}
function suppVieuxMssgs($con){
	mysqli_query($con,"delete from messages where num not in (select num from (select * from messages order by num desc LIMIT 100) as T ) ") or die(mysql_error());
	}
	
										
										
																		

suppVieuxMssgs($con);

if (isset($_POST['pseudo']) && isset($_POST['mssg']) ){
	$pseudo=$_POST['pseudo'];
	$mssg= htmlentities($_POST['mssg']);
	$mssg = html_entity_decode(	$mssg);
	$date_heure = date("Y-m-d H:i:s");
	$query ="SELECT * FROM `messages` WHERE message='$mssg'";
	$result = mysqli_query($con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	
        if($rows==0){
        $query = "INSERT into `messages` (pseudo, message, date_heure)
			VALUES ('$pseudo','$mssg', '$date_heure')";
		mysqli_query($con, $query);
         }else{
			 echo '<center><h2>Ce message existe déjà !!</h2>';
		 }
}


if (isset($_POST['dex'])){
session_start();
if(session_destroy())
{
header("Location: login.php");
}
}
?>
<div class="form">
<h1>Mini chat</h1>
<form action="" method="post" name="chat">
<input type="text" name="pseudo" placeholder="pseudo" required />
<input type="text" name="mssg" placeholder="message" required />
<br>
<input name="submit" type="submit" value="Envoyer" />
</form>
<br><br>

<?php
afficherTouteLaTable($con);
?>
<br> 
<br>
<br>
<form action="" method="post" name="dec">
<input name="dex" type="hidden" value="dex" />
<input name="submit" type="submit" value="Déconnexion" />
</form>
</div>
</body>
</html>

<style>
td,
th {
    border: 1px solid rgb(190, 190, 190);
    padding: 10px;
}

td {
    text-align: center;
}

tr:nth-child(even) {
    background-color: #eee;
}

th[scope="col"] {
    background-color: #696969;
    color: #fff;
}

th[scope="row"] {
    background-color: #d7d9f2;
}

caption {
    padding: 10px;
    caption-side: bottom;
}

table {
    border-collapse: collapse;
    border: 2px solid rgb(200, 200, 200);
    letter-spacing: 1px;
    font-family: sans-serif;
    font-size: .8rem;
}
</style>