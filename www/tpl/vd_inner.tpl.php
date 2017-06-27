<div class="promo"><img src="<?=WEB_ROOT?>/img/wordtest/bg0.png" width="1px" height="1px;">
	<div id="fixcon" class="hide">
		<div class="console">
			<div id="console" class="scroll-y"></div>
		</div>
	</div><?
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$url = $aUrl[0];
		?>
		<div class="hide">
			<?	include APP_ROOT . '/files/quick_book/keyworddiv.php';?>
		</div>
		
	<div class="hide"><? include APP_ROOT . '/files/quick_book/functionsdiv.php';?></div>
	
	<? if ($handler->allow): ?>
		<div class="textcontent scroll-x" id="article">
			<? include APP_ROOT . "/tpl/vd_content.tpl.php";?>
		</div>
	<? else: ?>
		<div class="textcontent " id="article">
			<? include APP_ROOT . "/tpl/vd_disallow.tpl.php";?>
		</div>
	<? endif ?>
	
	<? //include APP_ROOT . '/tpl/qs_add_comment_view.tpl.php'; ?>
	<div id="keywordLogWrap" class="hide">
		<div id="keywordLog" style="max-width:800px; background-color:white;"></div>
	</div>
	</article>
</div>
