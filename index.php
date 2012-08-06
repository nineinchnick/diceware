<html>
<head>
<title>Passphrase Generator</title>
<meta name="viewport" content="width=device-width/" >
</head>

<body>
<h1>Passphrase Generator</h1>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

  include './diceware.class.php';
  $count = (empty($_POST['count'])) ? 5 : $_POST['count'];
  $dw = new Diceware();
?>
<p>
<?php
    echo implode(" ",$dw->get_phrase($count,false));
?>
</p>

<form action="index.php" method="post">
<p>Number: <input type="number" name="count" value="<?php echo $count;?>" /></p>
<p><input type="submit" value="Generate" /></p>
</form>
<div>
<p>
<a href="index.php">Passphrase</a> | <a href="pin.php">PIN</a>
</p>
</div>
</body>
</html>
