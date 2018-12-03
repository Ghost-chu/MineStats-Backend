<?php
require "Utils.php";
require "DataManager.php";
$util = new Utils();
$dataManager = new DataManager();
$postData = json_decode(file_get_contents("php://input"), true);
$type = $postData['type'];
$id = $postData['id'];
$uuid = $postData['uuid'];
$name = $postData['name'];
$data = $postData['data'];
$banned = $postData['banned'];
$profile = $postData['profile'];
$advancement = $postData['advancement'];
if ($type == null) {
    return;
}
switch ($type) {
    case "playerID2UUID":
        $util->$util->checkNull($id);
        die($dataManager->requestPlayerID($id));
    case "playerUUID2ID":
        $util->checkNull($uuid);
        die($dataManager->requestPlayerUUID($uuid));
    case "playerUUID2Name":
        $util->checkNull($uuid);
        die($dataManager->requestPlayerNameByUUID($uuid));
    case "playerID2Name":
        $util->checkNull($id);
        die($dataManager->requestPlayerNameByID($id));
    case "updateData":
        $util->checkNull($data);
        $util->checkNull($profile);
        $util->checkNull($uuid);
        $util->checkNull($name);
        $util->checkNull($banned);
        $util->checkNull($advancement);
        if ($postData['key'] != "SunnySide JavaPlugin Upload License")
            die("Access Denied Invaild key");
        if (!base64_decode($data))
            die("Access Denied data not a good base64 string");
        $line = $dataManager->insertPlayerStats($uuid, $name, $data, $profile, $advancement, $banned);
        die($line);
    case "players":
        $dataManager->getPlayers();
        die();
    case "playersID":
        $dataManager->getPlayersID();
        die();
    case "lastUpdate":
        die($dataManager->getUpdateTime());
    case "getStatsByUUID":
        $util->checkNull($uuid);
        die($dataManager->getPlayerStatsByUUID($postData['uuid']));
    case "getBannedByUUID":
        $util->checkNull($uuid);
        die($dataManager->getPlayerBannedByUUID($uuid));
    case "getAdvancementByUUID":
        $util->checkNull($uuid);
        die($dataManager->getPlayerAdvancementByUUID($uuid));
    case "getProfileByUUID":
        $util->checkNull($uuid);
        die("Parameter mismatch: uuid=null");
    default:
        die("Somethings wrong, Please check SS wiki.");
}

