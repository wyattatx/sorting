<!doctype html>
<html>
<head>
<title>
Sorting page
</title>
<style>
 table {
   border-collapse: collapse;
   border: 1px solid black;
 }
 th, td {
   padding: 5px;
   border: 1px solid black;
 }
 th { font-weight: bold; }
 
 input[type='submit'] { width:200px;}
 
 table{
	 display: inline-block; vertical-align: top;
	 margin: 20px;
 }
 form{text-align: center;}
 
 .top {text-align: center; margin: 0 auto 1em;}
 
 body {background-color: blue; margin: 0;}
 #content {background-color: white; margin: 0 auto; padding: 1em; max-width: 800px;}
</style>

</head>
<body>

	<div id='content'> 
	<h1 class = 'top'> Sorting tool </h1>
<form>
  Array size: <input type="number" name="size" value='<?php echo(isset($_REQUEST['size']) ? $_REQUEST['size'] : '');?>'><br>
  <p><input type="submit" name="sort" value="Insertion"></p>
  <p><input type="submit" name="sort" value="Selection"></p>
  <p><input type="submit" name="sort" value="Quick"></p>
  <p><input type="submit" name="sort" value="Merge"></p>
  <p><input type="submit" name="sort" value="Radix"></p>
</form>

<?php
// Write the function squared_sum here
error_reporting(E_ALL);
ini_set('display_errors',1);

$arr = array();

if(isset($_REQUEST['size'])) {

	
	
for($i = 0; $i<$_REQUEST['size']; $i++) {
	$arr[] = rand(0,100);
}

?>
<div style='text-align: center;'>
<table class = 'unsorted'>
	<tr><th>Unsorted array</th></tr>
	<?php renderTable($arr); ?>
</table>
<?php

$start = microtime_float();
?>
<table class = 'sorted'>
	<tr><th>sorted array</th></tr>
<?php
switch (strtolower($_REQUEST['sort'])) {
	case 'insertion':
		renderTable(ins($arr));
		break;
	case 'selection':
		renderTable(sel($arr));
		break;
	case 'quick':
		renderTable(quick($arr));
		break;
	case 'merge':
		renderTable(merge_sort($arr));
		break;
	case 'radix':
		renderTable(radix($arr,$_REQUEST['size']));
		break;
}
$stop = microtime_float();
?>
</table>
</div>

<div style='text-align: center;'>
<table>
	<tr>
		<th>DataType </th>
		<th>Number of comparisons </th>
		<th>Number of movements </th>
		<th>O Time </th>
		<th>Real Time </th>
	</tr>
	<tr>
		<td> <?php echo "random" ?> </td>
		<td> <?php //echo $comparisons; ?> </td>
		<td> <?php //echo $movements; ?> </td>
		<td> <?php //echo $Otime; ?> </td>
		<td> <?php echo $stop - $start; ?> </td>
	</tr>
</table>
</div>
<?php
}else{
	echo "Please choose a size and sort";
}

function radix($arr,$size) {
	/*for ($shift = 31; $shift > -1; $shift--)
	{
		$j = 0;
	
		for ($i = 0; $i < $size; $i++)
		{
			$move = ($arr[$i] << $shift) >= 0;

			if ($shift == 0 ? !$move : $move)
				$arr[$i - $j] = $arr[$i];
			else
				$temp[$j++] = $arr[$i];
		}

		for ($i = 0; $i < $j; $i++)
		{
			$arr[($size - $j) + $i] = $temp[$i];
		}
	}

	$temp = null;
	return $arr;*/
	
	$temp = $output = array();
	$len = count($arr);
 
    for ($i = 0; $i < $len; $i++) {
		$temp[$arr[$i]] = 
			(array_key_exists($arr[$i],$temp) && $temp[$arr[$i]] > 0) 
			? ++$temp[$arr[$i]]
			: 1;
    }
 
    ksort($temp);
 
    foreach ($temp as $key => $val) {
		if ($val == 1) {
			$output[] = $key; 
		} else {
			while ($val--) {
				$output[] = $key;
			}
        }
    }
 
    return $output;
}

function merge_sort($arr){
	if(count($arr) == 1 ) return $arr;
	$mid = count($arr) / 2;
    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);
	$left = merge_sort($left);
	$right = merge_sort($right);
	return merge($left, $right);
}

function merge($left, $right){
	$res = array();
	while (count($left) > 0 && count($right) > 0){
		if($left[0] > $right[0]){
			$res[] = $right[0];
			$right = array_slice($right , 1);
		}else{
			$res[] = $left[0];
			$left = array_slice($left, 1);
		}
	}
	while (count($left) > 0){
		$res[] = $left[0];
		$left = array_slice($left, 1);
	}
	while (count($right) > 0){
		$res[] = $right[0];
		$right = array_slice($right, 1);
	}
	return $res;
}

function quick($arr)
 {
	 $loe = $gt = array();
	if(count($arr) < 2)
	{
		return $arr;
	}
	$pivot_key = key($arr);
	$pivot = array_shift($arr);
	foreach($arr as $val)
	{
		if($val <= $pivot)
		{
			$loe[] = $val;
		}elseif ($val > $pivot)
		{
			$gt[] = $val;
		}
	}
	return array_merge(quick($loe),array($pivot_key=>$pivot),quick($gt));
	
}

function sel($arr){
	for($i=0; $i<$_REQUEST['size']-1; $i++) {
	$min = $i;
	for($j=$i+1; $j<$_REQUEST['size']; $j++) {
		if ($arr[$j]<$arr[$min]) {
			$min = $j;
		}
	}
    $arr = swap_positions($arr, $i, $min);
}
return $arr;
}

function swap_positions($data1, $left, $right) {
	$backup_old_data_right_value = $data1[$right];
	$data1[$right] = $data1[$left];
	$data1[$left] = $backup_old_data_right_value;
	return $data1;
}

function ins($arr){
	for($i=0;$i<$_REQUEST['size'];$i++){
		$val = $arr[$i];
		$j = $i-1;
		while($j>=0 && $arr[$j] > $val){
			$arr[$j+1] = $arr[$j];
			$j--;
		}
		$arr[$j+1] = $val;
		//echo $val . "<->" . $j . "<br>";
	}
	return $arr;
}

function microtime_float() {
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

function renderTable($arr) {
	foreach($arr as $val) {
		echo "<tr><td>" . $val . "</td></tr>";
	}
}
?>


</div>
</body>
</html>
