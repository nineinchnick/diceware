<html>
<head>
<title>Passgen25</title>
<meta name="viewport" content="width=device-width/" >
</head>
<body>
<h1>Passgen25</h1>

<?php
$salt = "";
if(!empty($_POST['salt'])) {
    $salt = $_POST['salt']."\n";
    $password = md5($salt);
    $password = substr($password,0,7);
    echo "<p>".$password."</p>\n";
}
?>
<form action="passgen25.php" method="post">
<p>Salt: <input type="text" name="salt" value="<?php echo $salt;?>" autocomplete="off" /></p>
<p><input type="submit" value="Generate" /></p>
</form>
<?php include 'footer.php'; ?>
</body>
</html>

