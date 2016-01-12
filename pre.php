<?php

//遍历所有版本号。
$base_dir = __DIR__.'/source';

foreach( dirlist($base_dir) as $i ){
	$version_dir = $base_dir.DIRECTORY_SEPARATOR.$i;
	if(!is_dir($version_dir)){
		continue;
	}
	//遍历每个版本号下面的各种语言，en留下，其他杀掉。
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
				if($file == 'copyright.xml'){
					//内容太长影响编辑器工作，另行处理。
					copy(__DIR__.DIRECTORY_SEPARATOR.'copyright.xml', $filename);
					continue;
				}

				//不要重复处理：
				$content = file_get_contents($filename);
				if(!strpos($content, '-//OASIS//DTD DocBook XML V4.5//EN')){
					$content = explode("\n", $content, 2);
					$content[0] = str_replace('<?xml version="1.0" encoding="utf-8" ?>', '<?xml version="1.0" encoding="utf-8" ?>'."<!DOCTYPE article PUBLIC '-//OASIS//DTD DocBook XML V4.5//EN' 'http://www.oasis-open.org/docbook/xml/4.5/docbookx.dtd'>", $content[0]);
					$content = implode("\n", $content);
					file_put_contents($filename, $content);
				}

			}
		}
		else{
			deltree($lang_dir);
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