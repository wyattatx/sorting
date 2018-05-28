<!doctype html>
<html>
<head>
<title>
Sorting page
</title>
<style>
 table {
   border-collapse: collapse;`````
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
 
 h2{display: inline-block; vertical-align: top;
	margin-right: 500px; margin-top: 0px; margin-bottom: 0px;}
 
 form{text-align: center;}
 
 .top {text-align: center; margin-top: 0px; margin-bottom: 0px;}
 
 body {background-color: blue; margin: 0;}
 #content {background-color: white; margin: 0 auto; padding: 1em; max-width: 800px;}
 
 .button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}


</style>

</head>
<body>

	<div id='content'> 
	<h1 class = 'top'> Sorting tool </h1>
	<h2 style="font-size:16px"><i>tip: for demonstration purposes, array size 10 or less works best due to the formatting of the webpage. however, this program supports an array of any size</i></h2>


<form>
  Array size: <input type="number" name="size" value='<?php echo(isset($_REQUEST['size']) ? $_REQUEST['size'] : '');?>'><br>
	<p><input type="submit" class="button" name="sort" value="Insertion">
	<input type="submit" class="button" name="sort" value="Selection"></p>
	<p><input type="submit" class="button" name="sort" value="Quick">
	<input type="submit" class="button" name="sort" value="Merge"></p>
	<p><input type="submit" class="button" name="sort" value="Radix">
	<input type="submit" class="button" name="sort" value="Bubble"></p>
	<p><input type="submit" class="button" name="sort" value="Shell"></p>
</form>

<?php
// Write the function squared_sum here
error_reporting(E_ALL);
ini_set('display_errors',1);

$comparisons = 0;
$movements = 0;
$Otime = "";
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
	case 'bubble':
		renderTable(bubble($arr));
		break;
	case 'shell':
		renderTable(shell($arr));
	default:
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
		<td> <?php echo $comparisons; ?> </td>
		<td> <?php echo $movements; ?> </td>
		<td> <?php echo $Otime; ?> </td>
		<td> <?php echo $stop - $start; ?> </td>
	</tr>
</table>
</div>
<?php
}else{
	echo "Please choose a size and sort";
}

function shell($arr)
{
	global $comparisons,$movements,$Otime;
	$Otime = 'O(n(log(n))^2)';
	$x = round(count($arr)/2);
	while($x > 0)
	{
		for($i = $x; $i < count($arr);$i++){
			
			$temp = $arr[$i];
			$j = $i;
			while($j >= $x && $arr[$j-$x] > $temp)
			{
				$comparisons++;
				$arr[$j] = $arr[$j - $x];
				$j -= $x;
				$movements++;
			}
			$arr[$j] = $temp;
		}
		$x = round($x/2.2);
		$comparisons++;
	}
	return $arr;
}

function bubble($arr){
	global $comparisons,$movements,$Otime;
	$Otime = "O(n^2)";
	$temp = 0;
	do
	{
		$swapped = false;
		for( $i = 0, $c = count( $arr ) - 1; $i < $c; $i++ )
		{
			if( $arr[$i] > $arr[$i + 1] )
			{
				$comparisons++;
				list( $arr[$i + 1], $arr[$i] ) =
						array( $arr[$i], $arr[$i + 1] );
				$swapped = true;
			}
			$movements++;
		}
	}
	while( $swapped );
return $arr;
	
}

function radix($arr,$size) {
	global $comparisons,$movements,$Otime;
	$Otime = "O(nk)";
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
			$comparisons++;
			$output[] = $key; 
		} else {
			$comparisons++;
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
	global $comparisons,$movements,$Otime;
	$Otime = "O(n(logn))";
	$res = array();
	while (count($left) > 0 && count($right) > 0){
		if($left[0] > $right[0]){
			$comparisons++;
			$res[] = $right[0];
			$right = array_slice($right , 1);
		}else{
			$res[] = $left[0];
			$left = array_slice($left, 1);
		}
		$movements++;
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

function quick($arr){
	
	global $comparisons,$movements,$Otime;
	$Otime = "O(n(logn))";
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
			$comparisons++;
		}elseif ($val > $pivot)
		{
			$gt[] = $val;
		}
		$movements++;
	}
	return array_merge(quick($loe),array($pivot_key=>$pivot),quick($gt));
	
}

function sel($arr){
	global $comparisons,$movements,$Otime;
	$Otime = "O(n^2)";
	for($i=0; $i<$_REQUEST['size']-1; $i++) {
	$min = $i;
	for($j=$i+1; $j<$_REQUEST['size']; $j++) {
		if ($arr[$j]<$arr[$min]) {
			$min = $j;
			$movements++;
		}
	}
    $arr = swap_positions($arr, $i, $min);
	$comparisons++;
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
	global $comparisons,$movements,$Otime;
	$Otime = "O(n^2)";
	for($i=0;$i<$_REQUEST['size'];$i++){
		$val = $arr[$i];
		$j = $i-1;
		while($j>=0 && $arr[$j] > $val){
			$movements++;
			$arr[$j+1] = $arr[$j];
			$j--;
		}
		$arr[$j+1] = $val;
		$comparisons++;
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

