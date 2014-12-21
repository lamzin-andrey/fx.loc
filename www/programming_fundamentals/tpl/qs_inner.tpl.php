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
		<div class="textcontent scroll-y" id="article">
			<? include APP_ROOT . "/files/quick_book/" . $handler->book_tpl . '.php';?>
			<? if ($handler->show_test_new_words_button):?>
			<div class="testsButtons">
				<div id="runTest" class="qbtn btn">
					<span>Тест на новые слова</span>
				</div>
				<? foreach ($handler->test_buttons as $id => $text): ?>
					<div id="<?=$id ?>" class="qbtn btn">
						<span><?=$text ?></span>
					</div>
					
				<? endforeach ?>
			</div>
			<? endif?>
			<? if ($handler->comments_data): ?>
				<div class="center ctitleplace">
					<div id="comments_title" class="qbtn btn">
						<img src="<?=WEB_ROOT?>/img/updown16.png"><span><?=$lang['Comments_upcase']?></span>
					</div>
				</div>
				
				<div id="qsCmList" class="qs_commets_list">
					<? if ($app->user_email): ?>
					<div>
						<div id="addCommentBtn" class="qbtn btn add_comment_btn">
							<img src="<?=WEB_ROOT?>/img/cmplus.png"><span><?=$lang['Add_comment']?></span>
						</div>
					</div>
					<? endif ?>
					<?CViewHelper::$UlTreeItemRenderCallback = 'renderComment';?>
					<?CViewHelper::renderUlTree($handler->comments_data, 'body', array('id' => 'id'), 'vcomments nomark', 'cm_item'); ?>
					<?CViewHelper::$UlTreeItemRenderCallback = null;?>
				</div>
			<? else: ?>
				<? if ($app->user_email): ?>
				<div>
					<div id="addCommentBtn" class="qbtn btn add_comment_btn">
						<img src="<?=WEB_ROOT?>/img/cmplus.png"><span><?=$lang['Add_comment']?></span>
					</div>
				</div>
				<? endif ?>
			<? endif ?>
		</div>
		<hr style="color:##D2DAE2;padding:0; margin:0;"/>
		<div class="qs_editor_place">
			<ul class="inline qs_editor_s_tbar">
				<li>
					<img src="<?=WEB_ROOT?>/img/save_d.png" title="<?=$lang['Save']?>" id="qsEditorSave"/>
				</li>
				<li>
					<img class="btn" src="<?=WEB_ROOT?>/img/save_as.png" id="qsEditorSaveAs" title="<?=$lang['SaveAs']?>"/>
				</li>
				<li>
					<img src="<?=WEB_ROOT?>/img/exec_d.png" id="qsEditorContentExec" title="<?=$lang['Run']?>"/>
				</li>
				<li>
					<img class="btn" src="<?=WEB_ROOT?>/img/open32.png" id="qsEditorOpenFile" title="<?=$lang['Openfile']?>"/>
				</li>
				<li class="cfnameli" >
					<span class="cfname"><span id="currentFileName">Несохраненный_файл</span><span>.js</span></span>
				</li>
			</ul>
			<div class="simple_code_editor">
				<div id="qseLineWrapper" class="oh left"><div id="qseLines"></div></div>
				<textarea id="qs_editor_s" rows="15" spellcheck="false" class="left" wrap="off"></textarea>
				<div class="clearfix"></div>
			</div>
			<div class="status_bar right"><?=$lang['Line']?>: <span id="qsline">0</span>, <?=$lang['Column']?>: <span id="qscol">0</span></div>
			<input type="button" style='width:1px;height:1px;' value='' />
		</div>
		<div id="qs-br-wrap" class="hide">
			<div class="qs_file_browser" id="qs-br">
				<div class="file-names-filter tcenter">
					<input type="text" id="searchFileName" class="qs-file-browser-search-text" /> <img class="btn qs-br-search-btn" src="<?=WEB_ROOT?>/img/search32.png" />
					<hr style="color:gray"/>
				</div>
				<div class="space32"></div>
				<ul class="inline-block js-br-files">
					<li data-id="{id}" class="file_view template hide">
						<div data-id="{id}" class="center file-view-imgs">
							<img data-id="{id}" src="<?=WEB_ROOT?>/img/js64.png" class="left js-qsbr-file"> 
							<div class="left file_actions">
								<img data-id="{id}" src="<?=WEB_ROOT?>/img/remove.png" class="btn file-remove" title="<?=$lang['file-remove']?>">
								<img data-id="{id}" src="<?=WEB_ROOT?>/img/rename.png" class="btn file-rename" title="<?=$lang['file-rename']?>">
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="titlefile-{id}" class="js-file-title br-file-title tcenter">{name}</div>
					</li>
					
					<li class="no_file hide">
						<div class="js-file-title w100 tcenter"><?=$lang['no_your_file']?></div>
					</li>
				</ul>
					
				<div class="qs-br-rename-layer" id="qsBrDlgBg">
					<div class="qs-br-rename-dlg hide" id="qsRenameForm">
						<div class="qs-br-rename-dlg-middle">
							<input type="text" id="qsEditTitle"/> <input type="button" id="qsEditTitleSaveBtn" value="<?=$lang['Save']?>"/> <input type="hidden" id="qsEditTitleCurrentId"/> 
						</div>
					</div>
				</div>
				
				<div id="qsBrLoader" class="brloaderplace">
					<img src="<?=WEB_ROOT ?>/img/ploader.gif" />
				</div>
				
				<div id="keywordLogWrap" class="hide">
					<div id="keywordLog" style="max-width:800px; background-color:white;"></div>
				</div>
	
			</div>
		</div>
		
		<div id="qs-test-new-word-wrap" class="hide"><?//TODO не лишнее ли ?>
			<div class="test-new-word" id="qs-test-new-word">
				<? include APP_ROOT . '/tpl/qs_test_new_words_view.tpl.php'; ?>
			</div>
		</div>
		
		<? foreach ($handler->tests as $id => $tpl): ?>
			<div id="<?=$id?>-wrap" class="hide">
				<div class="test-new-word" id="<?=$id?>">
					<? include APP_ROOT . '/tpl/'. $tpl .'.php'; ?>
				</div>
			</div>
		<? endforeach ?>
		
		<? include APP_ROOT . '/tpl/qs_add_comment_view.tpl.php'; ?>
		
	</article>
</div>
