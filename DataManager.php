<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/12/3
 * Time: 16:04
 */
require  "SQLDriver.php";
class DataManager
{
    function requestPlayerID($playerUUID)
    {
        global $pdo_players_table, $pdo;
        $sql = 'select * from ' . $pdo_players_table . ' where `uuid`=:uuid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("uuid", $playerUUID);
        $stmt->execute();

        $row = $stmt->fetchAll();

        if (count($row) != 0) {
            return $row[0]['id'];
        } else {
            return -1;
            //No result , Return -1
        }
    }

    function requestPlayerUUID($playerID)
    {
        global $pdo_players_table, $pdo;
        $sql = 'select * from ' . $pdo_players_table . ' where `id`=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("id", $playerID);
        $stmt->execute();

        $row = $stmt->fetchAll();

        if (count($row) != 0) {
            return $row[0]['uuid'];
        } else {
            return -1;
            //No result , Return -1
        }
    }


    function requestPlayerNameByUUID($playerUUID)
    {
        global $pdo_players_table, $pdo;
        $sql = 'select * from ' . $pdo_players_table . ' where `uuid`=:uuid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("uuid", $playerUUID);
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);

        if (count($row) != 0) {
            return $row[0]['name'];
        } else {
            return -1;
            //No result , Return -1
        }
    }

    function getPlayerStatsByUUID($playerUUID)
    {
        global $pdo_stats_table, $pdo;
        $sql = 'select * from ' . $pdo_stats_table . ' where `uuid`=:uuid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("uuid", $playerUUID);
        $stmt->execute();
        $row = $stmt->fetchAll();
        if (count($row) != 0) {
            return $row[0]['stats'];
        } else {
            return -1;
            //No result , Return -1
        }
    }
    function getPlayerAdvancementByUUID($playerUUID)
    {
        global $pdo_stats_table, $pdo;
        $sql = 'select * from ' . $pdo_stats_table . ' where `uuid`=:uuid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("uuid", $playerUUID);
        $stmt->execute();
        $row = $stmt->fetchAll();
        if (count($row) != 0) {
            return $row[0]['advancement'];
        } else {
            return -1;
            //No result , Return -1
        }
    }

    function getPlayerProfileByUUID($playerUUID)
    {
        global $pdo_stats_table, $pdo;
        $sql = 'select * from ' . $pdo_stats_table . ' where `uuid`=:uuid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("profile", $playerUUID);
        $stmt->execute();
        $row = $stmt->fetchAll();
        if (count($row) != 0) {
            return $row[0]['stats'];
        } else {
            return -1;
            //No result , Return -1
        }
    }



    function getPlayerBannedByUUID($playerUUID)
    {
        global $pdo_banned_table, $pdo;
        $sql = 'select * from ' . $pdo_banned_table . ' where `uuid`=:uuid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("uuid", $playerUUID, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchAll();
        if (count($row) != 0) {
            return $row[0]['banned'];
        } else {
            return -1;
            //No result , Return -1
        }
    }

    function getUpdateTime()
    {
        global $pdo_info_table, $pdo;
        $sql = 'select * from ' . $pdo_info_table . ' where `id`=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
        if (count($row) != 0) {
            return $row[0]['lastupdate'];
        } else {
            return -1;
            //No result , Return -1
        }
    }

    function getPlayers()
    {
        global $pdo_players_table, $pdo;
        $sql = 'select * from ' . $pdo_players_table;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();

        foreach ($row as $key => $value) {
            echo $value['uuid'] . "\n";
        }
        die();
    }

    function getPlayersID()
    {
        global $pdo_players_table, $pdo;
        $sql = 'select * from ' . $pdo_players_table;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();

        foreach ($row as $key => $value) {
            echo $key . "\n";
        }
        die();

    }

    function createPlayerIndex($playerUUID, $playerName)
    {
        global $pdo_players_table, $pdo;
        $sql = 'REPLACE INTO `' . $pdo_players_table . '` (`id`,`username`,`uuid`) VALUES (DEFAULT,:username,:uuid);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":uuid", $playerUUID, PDO::PARAM_STR);
        $stmt->bindValue(":username", $playerName, PDO::PARAM_STR);
        $stmt->execute();
        $insertid = $pdo->lastInsertId();
        return $insertid;
    }

    function updatePlayerStats($playerUUID, $statsJSON, $profileBase64,  $advancement, $banned)
    {
        global $pdo_stats_table, $pdo;
        $statsJSON = json_encode(json_decode($statsJSON, true));
        $playerIndex = $this->requestPlayerID($playerUUID);
        $sql = 'REPLACE INTO `' . $pdo_stats_table . '` (`id`,`uuid`,`stats`,`profile`,`advancement`,`banned`) VALUES (:index,:uuid,:stats,:profile,:advancement,:banned);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":index", $playerIndex, PDO::PARAM_INT);
        $stmt->bindValue(":uuid", $playerUUID, PDO::PARAM_STR);
        $stmt->bindValue(":stats", $statsJSON, PDO::PARAM_STR);
        $stmt->bindValue(":profile", $profileBase64, PDO::PARAM_STR);
        $stmt->bindValue(":advancement", $advancement, PDO::PARAM_STR);
        $stmt->bindValue(":banned", (int)$banned, PDO::PARAM_INT);
        $stmt->execute();
        $insertid = $pdo->lastInsertId();
        return $insertid;
    }

    function updateProgramInfo()
    {
        global $pdo_info_table, $pdo;
        $sql = 'REPLACE INTO `' . $pdo_info_table . '` (`id`,`lastupdate`) VALUES (1,:times);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":times", (int)time(), PDO::PARAM_INT);
        $stmt->execute();
        $insertId = $pdo->lastInsertId();
        return $insertId;
    }

    function insertPlayerStats($playerUUID, $playerName, $statsJSON, $profileBase64,$advancement, $banned)
    {
        if ($this->requestPlayerID($playerUUID) == -1)
            $this->createPlayerIndex($playerUUID, $playerName);
        $line = $this->updatePlayerStats($playerUUID, $statsJSON, $profileBase64,  $advancement, $banned);
        $this->updateProgramInfo();
        return $line;
    }
}