<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 5/18/2020
 * Time: 22:48
 */
if(!is_dir(__DIR__."/src/storage/")) {
    print "Create storage directory \n";
    mkdir(__DIR__."/src/storage/",0777);
}
print "Connecte to databases \n";
$pdo = new \PDO("sqlite:".__DIR__."/src/storage/databases.db");
//mm hh jj MMM JJJ
$sql = "CREATE TABLE IF NOT EXISTS pcron 
        (
         id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
         minute VARCHAR(255) NOT NULL,
         heure VARCHAR(255) NOT NULL,
         day VARCHAR(255) NOT NULL,
         month_name VARCHAR(255) NOT NULL,
         day_name VARCHAR(255) NOT NULL,
         cmd VARCHAR(255))";
$res = $pdo->query($sql);
// create service instance
const SERVICE_NAME = 'PCRON';
const SERVICE_NAME_DISPLAY = 'PHP crontab service';
const SERVICE_DESC = 'PHP crontab manager';
$res = win32_create_service([
    'service' => SERVICE_NAME,
    'display' => SERVICE_NAME_DISPLAY,
    'description' => SERVICE_DESC,
    'path' =>  'php',
    'params' => __DIR__."\\PcronService.php"
]);
debug_zval_dump($res);