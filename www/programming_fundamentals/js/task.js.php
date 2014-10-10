<?
define("APP_ROOT", dirname(__FILE__) . '/..');       //чтобы работало повсюду
require_once APP_ROOT . "/config.php";       //config
require_once APP_ROOT . "/CApplication.php"; //logic
@session_start();
$uid = CApplication::getUid();
$fid = req('id');
$query = "SELECT file_content FROM js_scripts WHERE id = {$fid} AND user_id = {$uid} AND is_deleted != 1 LIMIT 1";
//die($query);
$data = dbvalue($query);
if ($data) {
	print $data;
}

