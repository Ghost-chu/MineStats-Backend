<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/12/3
 * Time: 16:01
 */
require "SQLDriver.php";
require "config.php";

class Utils
{
    function deleteDir($dir)
    {
        if (!$handle = @opendir($dir)) {
            return false;
        }
        while (false !== ($file = readdir($handle))) {
            if ($file !== "." && $file !== "..") {       //排除当前目录与父级目录
                $file = $dir . '/' . $file;
                if (is_dir($file)) {
                    $this->deleteDir($file);
                } else {
                    @unlink($file);
                }
            }

        }
        @rmdir($dir);
    }

    function checkNull($isNull)
    {

        if ($isNull == null) {
            die("Parameter " . $isNull . " cannot be NULL");
            return true;
        } else {
            return false;
        }
    }
    function curl_get_http($url,$path=""){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
        curl_close($curl);
        if($path==null)
            return $tmpInfo;
        $handle = fopen($path,"w+");
        fwrite($handle,$tmpInfo);
        fclose($handle);
        return $tmpInfo;
    }
    function get_file($url, $folder = "./") {
        set_time_limit (24 * 60 * 60); // 设置超时时间
        $destination_folder = $folder . '/'; // 文件下载保存目录，默认为当前文件目录
        if (!is_dir($destination_folder)) { // 判断目录是否存在
            $this->mkdirs($destination_folder); // 如果没有就建立目录
        }
        $newfname = $destination_folder . basename($url); // 取得文件的名称
        try {
            $file = fopen($url, "rb"); // 远程下载文件，二进制模式
        }catch(Exception $e){
            throw $e->getPrevious();
        }
        if ($file) { // 如果下载成功
            $newf = fopen ($newfname, "wb"); // 远在文件文件
            if ($newf) // 如果文件保存成功
                while (!feof($file)) { // 判断附件写入是否完整
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8); // 没有写完就继续
                }
        }
        if ($file) {
            fclose($file); // 关闭远程文件
        }
        if ($newf) {
            fclose($newf); // 关闭本地文件
        }
        return true;
    }
    function mkdirs($path , $mode = "0755") {
        if (!is_dir($path)) { // 判断目录是否存在
            $this->mkdirs(dirname($path), $mode); // 循环建立目录
            mkdir($path, $mode); // 建立目录
        }
        return true;

    }

}