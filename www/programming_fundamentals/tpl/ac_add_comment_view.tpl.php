<noindex>
<div id="qsAddCommentFormWrap" class="hide">
	<div id="qsAddCommentForm">
		<div class="">
			<?=FV::hid('parentId', 0)?> <?=FV::hid('commentId')?>
			<div class="cm_quote hide">	</div>
			<div class="cm_form_title">
				<?=FV::labinp('cmTitle', $lang['comment_form_title_label']) ?>
			</div>
			<div>
				<label class="cm_textar_label" for="cmBody"><?=$lang['comment_form_body_label']?></label><br>
				<textarea id="cmBody" class="cm_textarea" rows="15"></textarea>
			</div>
			
			<? if(isset($app->reg_captcha)): ?>
			
			<div class="left">
				<div class="tcenter commcap">
					<label class="slabel comm_cap_legend" for="str"><?=$lang['Captcha_comm_legend']?></label>
					<img id="refimg" src="<?=WEB_ROOT?>/img/random">
					<input type="text" value="" id="commfstr" name="commfstr">
				</div>
			</div>
			
			<? endif ?>
			
			<div class="right">
				<input type="button" value="<?=$lang['Send_comment']?>" class="btn" id="cmSendForm" name="cmSendForm">
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
</noindex>
