<div class="promo"><img src="<?=WEB_ROOT?>/img/wordtest/bg0.png" width="1px" height="1px;">
	<div id="fixcon" class="hide">
		<div class="console">
			<div id="console" class="scroll-y"></div>
		</div>
	</div><?
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$url = $aUrl[0];
		if (strpos($url, '/quick_start') !== false && strpos($url, '/quick_start/keywords') === false) {?>
			<div class="hide">
			<?	include APP_ROOT . '/files/quick_book/keyworddiv.php';?>
			</div>
			<?
		}
	?>
	<div class="hide"><?	include APP_ROOT . '/files/quick_book/functionsdiv.php';?></div>
	<?=FV::hid('acceptMark', 1);?>
		<div class="textcontent scroll-y" id="article">
			<? if ($handler->comments_data): ?>
				<div class="center ctitleplace">
					<div id="comments_title" class="qbtn btn">
						<img src="<?=WEB_ROOT?>/img/updown16.png"><span><?=$lang['Comments_upcase']?></span>
					</div>
				</div>
				<div id="qsCmList" class="qs_commets_list">
					<?CViewHelper::$UlTreeItemRenderCallback = 'renderCommentForAdmin';?>
					<?CViewHelper::renderUlTree($handler->comments_data, 'body', array('id' => 'id'), 'vcomments nomark', 'cm_item'); ?>
					<?CViewHelper::$UlTreeItemRenderCallback = null;?>
				</div>
			<? endif ?>
		</div>
		<hr style="color:##D2DAE2;padding:0; margin:0;"/>
		<? include APP_ROOT . '/tpl/ac_add_comment_view.tpl.php'; ?>
		
	</article>
</div>
