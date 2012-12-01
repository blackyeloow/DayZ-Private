<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "control") !== false))
{
	$pagetitle = "Server control";
	?>
	
	<div id="page-heading">
	<?php
		echo "<title>".$pagetitle." - ".$sitename."</title>";
		echo "<h1>".$pagetitle."</h1>";

		$commandString_server = "start \"\" /d \"".$patharma."\" /b ".'"'.$pathserver.'"'.$exeserver_string;
		$commandString_bec = "start \"\" /d \"".$pathbec."\" ".'"'.$pathbec.'\\'.$exebec.'"'.$exebec_string;
		
		$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$exeserver.'" /FO CSV');
		$serverexestatus = explode(",", strtolower($serverexestatus))[0];
		$serverexestatus = str_replace('"', "", $serverexestatus);
		$becexestatus = exec('tasklist /FI "IMAGENAME eq '.$exebec.'" /FO CSV');
		$becexestatus = explode(",", strtolower($becexestatus))[0];
		$becexestatus = str_replace('"', "", $becexestatus);
		
		if (isset($_GET['action'])) {
			switch($_GET['action']) {
				case 0:
					pclose(popen($commandString_server, 'r'));
					mysql_query("INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('START SERVER','{$_SESSION['login']}', NOW())");
					sleep(6);
					break;
				case 1:
					$output = exec('taskkill /IM '.$serverexestatus);
					mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('STOP SERVER', '{$_SESSION['login']}', NOW())");
					sleep(6);
					break;
				case 3:
					pclose(popen($commandString_bec, 'r'));
					mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('START BEC', '{$_SESSION['login']}', NOW())");
					sleep(6);
					break;
				case 4:
					$output = exec('taskkill /IM '.$becexestatus);
					mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('STOP BEC', '{$_SESSION['login']}', NOW())");
					sleep(6);
					break;
				case 5:
					$cmd = "#restart";
					$answer = rcon($serverip, $serverport, $rconpassword, $cmd);
					mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('RESTART SERVER', '{$_SESSION['login']}', NOW())");
					sleep(1);
					break;
				default:
					sleep(1);
			}
		}

		$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$exeserver.'" /FO CSV');
		$serverexestatus = explode(",", strtolower($serverexestatus))[0];
		$serverexestatus = str_replace('"', "", $serverexestatus);
		$becexestatus = exec('tasklist /FI "IMAGENAME eq '.$exebec.'" /FO CSV');
		$becexestatus = explode(",", strtolower($becexestatus))[0];
		$becexestatus = str_replace('"', "", $becexestatus);

		$serverrunning = false; if ($serverexestatus == strtolower($exeserver)) {$serverrunning = true;}
		$becrunning = false; if ($becexestatus == strtolower($exebec)) {$becrunning = true;}
	?>
	</div>

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
		<tr>
			<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
		</tr>
		<tr>
			<td id="tbl-border-left"></td>
			<td>
			<div id="content-table-inner">	
				<div id="table-content">
				<?php if ($serverrunning){ ?>
					<div id="message-green">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">Server is running.</td>
						<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>
					<div id="step-holder">	
						<div class="step-no"><a href="index.php?view=control&action=5"><img src="images/start.png"/></div>
						<div class="step-dark-left">Restart</div>
						<div class="step-dark-right">&nbsp;</div>
						<div class="step-no"><a href="index.php?view=control&action=1"><img src="images/stop.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=1">Stop</a></div>
						<div class="step-dark-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<?php if ($becrunning){ ?>
					<div id="message-green">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="green-left">BattlEye Extended Controls is running.</td>
							<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif"   alt="" /></a></td>
						</tr>
						</table>
					</div>
					<div id="step-holder">	
							<div class="step-no-off"><img src="images/start.png"/></div>
							<div class="step-light-left">Start</div>
							<div class="step-light-right">&nbsp;</div>
							<div class="step-no"><a href="index.php?view=control&action=4"><img src="images/stop.png"/></a></div>
							<div class="step-dark-left"><a href="index.php?view=control&action=4">Stop</a></div>
							<div class="step-dark-round">&nbsp;</div>
							<div class="clear"></div>
					</div>
					<?php } else { ?>
					<div id="message-yellow">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="yellow-left">BattlEye Extended Controls is not running.</td>
							<td class="yellow-right"><a class="close-yellow"><img src="images/table/icon_close_yellow.gif"   alt="" /></a></td>
						</tr>
						</table>
					</div>
					<div id="step-holder">	
						<div class="step-no"><a href="index.php?view=control&action=3"><img src="images/start.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=3">Start</a></div>
						<div class="step-dark-right">&nbsp;</div>
						<div class="step-no-off"><img src="images/stop.png"/></div>
						<div class="step-light-left">Stop</div>
						<div class="step-light-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<?php }
					} else { ?>
					<div id="message-red">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="red-left">Server is stopped.</td>
							<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif"   alt="" /></a></td>
						</tr>
						</table>
					</div>
					<div id="step-holder">	
						<div class="step-no"><a href="index.php?view=control&action=0"><img src="images/start.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=0">Start</a></div>
						<div class="step-dark-right">&nbsp;</div>
						<div class="step-no-off"><img src="images/stop.png"/></div>
						<div class="step-light-left">Stop</div>
						<div class="step-light-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			</td>
			<td id="tbl-border-right"></td>
		</tr>
		<tr>
			<th class="sized bottomleft"></th>
			<td id="tbl-border-bottom">&nbsp;</td>
			<th class="sized bottomright"></th>
		</tr>
	</table>
	<div class="clear">&nbsp;</div>
	
<?php
}
else
{
	header('Location: index.php');
}
?>