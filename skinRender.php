<?php
$skin = $_GET['uuid'];
$skinPath = "./public/player/".$skin."/skin.png";
$skinPage = fread(fopen("./htmlTemplate.html","r"),filesize("./htmlTemplate.html"));
str_replace('${skinPath}',$skinPath,$skinPage);
die($skinPage);

