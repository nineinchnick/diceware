<html>
<head><title>PIN Generator</title></head>

<body>
<h1>PIN Number Generator</h1>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include './RandDotOrg.class.php';
  $tr = new RandDotOrg('pin generator - joe@desertflood.com');
  $num = (empty($_POST['length'])) ? 4 : $_POST['length'];
  $count = (empty($_POST['count'])) ? 5 : $_POST['count'];
  $min = 0;
  $max = 9;
  $base = 10;
  $len = $num * $count;
  $ar = $tr->get_integers($len, $min, $max, $base);
  $str = implode("",$ar);
?>
<ul>
<?php
  for($i=0; $i<$len; $i=$i+$num) {
    echo "<ul>".substr($str,$i,$num)."</ul>";
  }
?>
</ul>

<form action="index.php" method="post">
<p>Length: <input type="number" name="length" value="<?php echo $num;?>" /></p>
<p>Number: <input type="number" name="count" value="<?php echo $count;?>" /></p>
<p><input type="submit" value="Generate" /></p>
</form>
</body>
</html>
