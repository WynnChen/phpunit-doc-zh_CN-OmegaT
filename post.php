<?php

//遍历所有版本号。
$base_dir = __DIR__.'/target';

foreach( dirlist($base_dir) as $i ){
	$version_dir = $base_dir.DIRECTORY_SEPARATOR.$i;
	if(!is_dir($version_dir)){
		continue;
	}
	//遍历每个版本号下面，en（翻译）改为zh_cn.
	foreach(dirlist($version_dir) as $j){
		$lang_dir = $version_dir.DIRECTORY_SEPARATOR.$j;
		if($j == 'en'){
			//内部的所有文件，如果是xml的额外处理
			foreach(dirlist($lang_dir) as $file){
				$filename = $lang_dir.DIRECTORY_SEPARATOR.$file;
				if(!is_file($filename)){
					continue;
				}
				if(substr($filename, -4) != '.xml'){
					continue;
				}
				$content = file_get_contents($filename);
				//这个doctype被标准化了
				$content = str_replace('<!DOCTYPE article PUBLIC "-//OASIS//DTD DocBook XML V4.5//EN" "http://www.oasis-open.org/docbook/xml/4.5/docbookx.dtd">', '', $content);
				file_put_contents($filename, $content);
			}
			rename($version_dir.DIRECTORY_SEPARATOR.'en', $version_dir.DIRECTORY_SEPARATOR.'zh_cn');
		}
	}

}

echo 'done.';




function dirlist($dir){
	return array_diff(scandir($dir), array('..', '.'));
}

function delTree($dir) {
	exec("rd /s /q \"{$dir}\"");
}

chdir('..');