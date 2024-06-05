<?php

eval(FileUtil::getPluginConf($plugin["name"]));

$quotaFilePath = '/quota.json';

if (file_exists($quotaFilePath)) {
	$jResult .= "plugin.interval = " . $diskUpdateInterval . "; plugin.notifySpaceLimit = " . ($notifySpaceLimit * 1024 * 1024) . ";";
	$theSettings->registerPlugin($plugin["name"], $pInfo["perms"]);
} else {
	$jResult .= "plugin.disable();";
}
