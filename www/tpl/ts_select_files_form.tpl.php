<div id="ts-br-wrap" class="hide">
	<div class="qs_file_browser" id="ts-br">
		<div class="file-names-filter tcenter j-selected-files-filter-area">
			<input type="text" id="searchFileFilter" class="qs-file-browser-search-text" /> <img class="btn qs-br-search-btn" src="<?=WEB_ROOT?>/img/search32.png" />
			<hr style="color:gray"/>
		</div>
		<div class="space32"></div>
		<ul class="inline-block js-br-files">
			<li data-id="{id}" class="file_view template hide">
				<div data-id="{id}" class="center file-view-imgs">
					<img data-id="{id}" src="<?=WEB_ROOT?>/img/js64.png" class="left js-qsbr-file"> 
					<div class="left file_actions">
						<input type="checkbox">
					</div>
					<div class="clearfix"></div>
				</div>
				<div id="titlefile-{id}" class="js-file-title br-file-title tcenter">{name}</div>
			</li>
			
			<li class="no_file hide">
				<div class="js-file-title w100 tcenter"><?=$lang['no_your_file']?></div>
			</li>
		</ul>
		
		<div id="tsBrLoader" class="brloaderplace">
			<img src="<?=WEB_ROOT ?>/img/ploader.gif" />
		</div>
		
		<div id="keywordLogWrap" class="hide">
			<div id="keywordLog" style="max-width:800px; background-color:white;"></div>
		</div>

		<div class="dlg_gr_button">
			<input id="tsfSave" type="button" value="<?=$lang['Save']?>">
			<?=FV::hid('tsfSelected'); ?>
			<?=FV::hid('tsfTask'); ?>
		</div>
  
	</div>
</div>
