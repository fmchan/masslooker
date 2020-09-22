<?php

$filename = './data/followers/yanyee__2.json';
if (file_exists($filename)) {
$list = json_decode(file_get_contents($filename));
if (is_object($list))
	print_r($list);
	//echo count($list);
}
