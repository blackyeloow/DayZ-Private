<?php
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$pnumber = mysql_num_rows($res);			

	if (isset($_GET['page']))
	{
		$pageNum = $_GET['page'];
	}
	
	$offset = ($pageNum - 1) * $rowsPerPage;
	$maxPage = ceil($pnumber/$rowsPerPage);			

	for ($page = 1; $page <= $maxPage; $page++)
	{
		if ($page == $pageNum)
		{
			$nav .= " $page ";
		}
		else
		{
			$nav .= "$self&page=$page";
		}
	}

	$query = $query." LIMIT ".$offset.",".$rowsPerPage.";";
	$res = mysql_query($query) or die(mysql_error());
	$number = mysql_num_rows($res);

	$tableheader = header_player($show, $order);

	while ($row = mysql_fetch_array($res)) {$tablerows .= row_player($row, $serverworld);}

	include ('paging.php');
?>