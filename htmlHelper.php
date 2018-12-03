<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/12/2
 * Time: 23:52
 */
require  "SQLDriver.php";
require "nbt.class.php";
require  "DataManager.php";
$DataManager = new DataManager();
clearstatcache();
function makeMainPreparePage(){

    $DOCUMENT_ROOT = ".";
    $fp = fopen($DOCUMENT_ROOT."/htmlTemplate/prepareIndex.html",'r');
    return fread($fp,filesize($DOCUMENT_ROOT."/htmlTemplate/prepareIndex.html"));
}
function makePlayerStatsPage($playerUUID){
    $DataManager = new DataManager();
    $DOCUMENT_ROOT = ".";
    $fp = fopen($DOCUMENT_ROOT."/htmlTemplate/playerStats.html",'r');
    $document = fread($fp,filesize($DOCUMENT_ROOT."/htmlTemplate/playerStats.html"));
    $document = str_replace('${uuid}',$playerUUID,$document); //Replace UUID
    //DO achievement


    $achievementsPart = $this->getAllPart($playerUUID);



    //$document = str_replace('${Achievement}',$achievements,$document); //

    $doucument = str_replace('${uuid}',$playerUUID,$document);
}
//function getAllPart($uuid){
//    $DataManager = new DataManager();
//    $type = array();
//    $finalHTML = "";
//    foreach (getAllAC($DataManager->getPlayerAdvancementByUUID($uuid)) as $achievement){
//        $data = explode("|",$achievement);
//       $minecraft = str_replace("minecraft:","",$data[0]);
//       $done = $data[1];
//       $formated = explode("/",$minecraft);
//       if(count($minecraft)==3){
//           $a = $minecraft[0];
//           $b = $minecraft[1];
//           $c = $minecraft[2];
//           $minecraft = array();
//           $minecraft[0] = $a;
//           $minecraft[1] = $b." ".$c;
//       }
//       if(!array_key_exists($minecraft[0],$type))
//           array_push($type,$minecraft);
//
//
//
//    }
//}
//function getAllAC($str)
//{
//    $json = json_decode($str, true);
//    $array=array();
//    foreach ($json as $key => $value) {
//    array_push($array, $key . "|" . $key['done']);
//    }
//    return $array;
//}


