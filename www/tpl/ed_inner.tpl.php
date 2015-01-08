<div class="promo">
	<div id="fixcon" class="hide">
		<div class="console">
			<div id="console" class="scroll-y"></div>
		</div>
	</div><?
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$url = $aUrl[0];
		if ((strpos($url, '/quick_start') !== false || strpos($url, '/text_editor') !== false) && strpos($url, '/quick_start/keywords') === false) {?>
			<div class="hide">
			<?
			include APP_ROOT . '/files/quick_book/keyworddiv.php';?>
			</div>
			<?
		}
	?><div class="hide"><?	include APP_ROOT . '/files/quick_book/functionsdiv.php';?></div>
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
				<li>
					<img class="btn" src="<?=WEB_ROOT?>/img/project32.png" id="qsEditorSetPro" title="<?=$lang['Project']?>"/>
				</li>
				<li class="cfnameli" >
					<span class="cfname"><span id="currentFileName">Несохраненный_файл</span><span>.js</span></span>
				</li>
			</ul>
			<div class="simple_code_editor">
				<!--div class="oh left"><div id="qseLines"></div></div-->
				<div id="qseLineWrapper" class="oh left"><div id="qseLines"></div></div>
				<textarea id="qs_editor_s" rows="15" spellcheck="false" class="left" wrap="off"></textarea>
				<pre class id="qs_editor_hl" spellcheck="false" class="left" ></pre>
				<input type="button" class="left focus_hook abs" id='tabhook'>
				<div class="clearfix"></div>
			</div>
			<div class="status_bar right"><?=$lang['Line']?>: <span id="qsline">0</span>, <?=$lang['Column']?>: <span id="qscol">0</span></div>
			
			<div class="clearfix">&nbsp;</div>
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
					<div id="keywordLog" style="max-width:800px"></div>
				</div>
	
			</div>
		</div>
		
		<div id="qsSetRelDlgWrap" class="hide">
			<div class="" id="qsSetRelDlg">
				<div class="left">
					<select multiple id="qsrdAll"></select>
				</div>
				<div class="left qsrelbuttons">
					<button id="qsrdLTR">&gt;&gt;</button><br>
					<button id="qsrdRTL">&lt;&lt;</button>
				</div>
				<div class="left">
					<select multiple id="qsrdSets"></select>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		
		<div class="abs codehint hide" id="codeTooltip">innerHTML, locale</div>
		
	</article>
</div>
