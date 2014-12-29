<?php
$doc_root = $_SERVER["DOCUMENT_ROOT"];
$web_root = str_replace($doc_root, "", APP_ROOT);
$web_root = str_replace("Z:\\home\\fx.loc\\www", "", $web_root);
$web_root = str_replace("\\", "/", $web_root);
define ("WEB_ROOT", $web_root);
define ("WORK_FOLDER", "programming_fundamentals");
define ("APP_CACHE_LIFE", 15 * 60);
define ("SUMMER_TIME", -3600);
define ("DEV_MODE", true);
