<?php
$doc_root = $_SERVER["DOCUMENT_ROOT"];
$doc_root = str_replace("Z:\\home\\fx.loc\\www\\", '' , $doc_root);
define ("WEB_ROOT", str_replace($doc_root, "", APP_ROOT));
define ("SUMMER_TIME", 3600);
