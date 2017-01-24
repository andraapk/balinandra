<div class="col-md-12 text-center">
	<?php
		$tmp_paging = $paging->appends(Input::all())->render();
		$paging = str_replace("href=", "class='pagination-link' style='cursor:pointer;' href=", $tmp_paging);
		$paging = preg_replace("/\[[^)]+\]/","[]", $paging);
		$paging = str_replace('&laquo;','<i class="fa fa-angle-left" aria-hidden="true"></i>', $paging);
		$paging = str_replace('&raquo;','<i class="fa fa-angle-right" aria-hidden="true"></i>', $paging);
	?>
	{!! $paging !!}
</div>	