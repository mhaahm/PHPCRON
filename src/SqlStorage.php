<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 5/17/2020
 * Time: 22:37
 */

namespace PCRON;

use PCRON\pcronStorageInterface;
use PCRON\Model\Cron;
/**
 * Class SqlStorage
 * @package PCRON
 */
class SqlStorage implements pcronStorageInterface
{

    /**
     * getPcronData : extract pcron data
     *
     * @return array
     */
   public function getPcronData():array
   {
       $dir = __DIR__."/../storage/";
       if(!is_dir($dir)) {
            mkdir($dir,0777);
       }
       $pdo = new \PDO("sqlite:".__DIR__."/storage/databases.db");
       if(!$pdo) {
           print "No connexion to databases sqlite \n";
           return [];
       }
       $sql = "select * from `pcron`";
       $res = $pdo->query($sql);
       $data = [];
       if($res) {
           $rows = $res->fetchAll();
           foreach ($rows as $row)
           {
               $cron = new Cron();
               $cron
                   ->setId($row['id'])
                   ->setCmd($row['cmd'])
                   ->setDay($row['day'])
                   ->setDayName($row['day_name'])
                   ->setHeure($row['heure'])
                   ->setMinute($row['minute'])
                   ->setMonthName($row['month_name']);
               $data[] = $cron;
           }
           return $data;
       }
       return [];
   }
}