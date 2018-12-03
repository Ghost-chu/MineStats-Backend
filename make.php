<?php
require "Utils.php";
require "DataManager.php";
$util = new Utils();
require "SQLDriver.php";
require "htmlHelper.php";
echo("Readying to make players stats pages");
//======================
global $pdo_stats_table,$pdo;
$sql = 'select * from ' . $pdo_stats_table;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll();
//======================
echo ("Total need make ".count($row)." players stats pages...\n");
echo ("Cleaning up files...\n");
$DOCUMENT_ROOT = '.';
$util->deleteDir( $DOCUMENT_ROOT."/public/data");
$fp = fopen( $DOCUMENT_ROOT."/public/index.html",'w+');
fwrite($fp,makeMainPreparePage());
fclose($fp);
@mkdir($DOCUMENT_ROOT."public/player");
//Get all players skin and avatar.
foreach ($row as $key=>$values){
    $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
    $uuid=$values['uuid'];
    @mkdir($DOCUMENT_ROOT."public/player/".$uuid);
    try{
        //TEST
        $util->curl_get_http("https://crafatar.com/avatars/" . $uuid, $DOCUMENT_ROOT . "public/player/" .
            $uuid . "/avatar.png");
    }catch(Exception $e){
        $uuid = "8667ba71b85a4004af54457a9734eed7";
        echo("Failed get player's skins, reset UUID to Steve's UUID\n");
    }
    echo("Makeing ".$uuid."'s player stats\n");
    $util->curl_get_http("https://crafatar.com/avatars/" . $uuid, $DOCUMENT_ROOT . "public/player/" .
            $uuid . "/avatar.png");
    $util->curl_get_http("https://crafatar.com/head/".$uuid,$DOCUMENT_ROOT."public/player/".
        $uuid."/head.png");
    $util->curl_get_http("https://crafatar.com/skin/".$uuid,$DOCUMENT_ROOT."public/player/".
    $uuid."/skin.png");
    $util->curl_get_http("https://crafatar.com/body/".$uuid,$DOCUMENT_ROOT."public/player/".
    $uuid."/body.png");
    $fileHandle = fopen($DOCUMENT_ROOT."public/player/".$uuid."/index.html","w+");
    fwrite($fileHandle,makePlayerStatsPage($uuid));
    fclose($fileHandle);
}