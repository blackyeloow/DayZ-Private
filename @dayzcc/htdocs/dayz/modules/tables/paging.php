<?php	if ($pageNum > 1)	{		$page  = $pageNum - 1;		$prev  = "$self&page=$page";		$first = "$self&page=1";	}	else	{		$prev  = '&nbsp;'; // We're on page one, don't print previous link		$first = '&nbsp;'; // Nor the first page link	}	if ($pageNum < $maxPage)	{		$page = $pageNum + 1;		$next = "$self&sort=$sort&page=$page";		$last = "$self&sort=$sort&page=$maxPage";	}	else	{		$next = '&nbsp;'; // We're on the last page, don't print next link		$last = '&nbsp;'; // Nor the last page link	}	$paging = '<table border="0" cellpadding="0" cellspacing="0" id="paging-table"><tr><td>		<a href="'.$first.'" class="page-far-left"></a>		<a href="'.$prev.'" class="page-left"></a>		<div id="page-info">Page <strong>'.$pageNum.'</strong> / '.$maxPage.'</div>		<a href="'.$next.'" class="page-right"></a>		<a href="'.$last.'" class="page-far-right"></a>		</td></tr></table>';?>