<?php
    require_once('../../php/util.php');
    require_once('../../php/settings.php');
    eval(FileUtil::getPluginConf('diskspace'));

    $quotaFilePath = '/quota.json';
    $ret = array(
        "total" => 0,
        "free" => 0
    );

    if (file_exists($quotaFilePath)) {
        $quotaData = json_decode(file_get_contents($quotaFilePath), true);
        if (json_last_error() === JSON_ERROR_NONE && isset($quotaData['quota_allowance'], $quotaData['disk_usage'])) {
            $totalBytes = $quotaData['quota_allowance'] * 1024 * 1024 * 1024; // Convert GB to bytes
            $usedBytes = $quotaData['disk_usage'] * 1024 * 1024 * 1024; // Convert GB to bytes
            $freeBytes = $totalBytes - $usedBytes;

            $ret["total"] = $totalBytes;
            $ret["free"] = $freeBytes;
        }
    }

    CachedEcho::send(JSON::safeEncode($ret), "application/json");
