<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 5/17/2020
 * Time: 00:13
 */
namespace PCRON;
use PCRON\SqlStorage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 *
 *  mm représente les minutes (de 0 à 59)
 *  hh représente l'heure (de 0 à 23)
 *  jj représente le numéro du jour du mois (de 1 à 31)
 *  MMM représente l'abréviation du nom du mois (jan, feb, ...) ou bien le numéro du mois (de 1 à 12)
 *  JJJ représente l'abréviation du nom du jour ou bien le numéro du jour dans la semaine :
    0 = dimanche
    1 = lundi
 * Class Pcron
 * @package PCRON
 */
class Pcron
{
    /** @var pcronStorageInterface storage */
    private $storage;

    public function __construct()
    {
        $this->_log("Create new Pcron instance");
    }

    public function __destruct()
    {
        unset($this->storage);
    }

    /**
     * @param string $msg
     */
    private function _log(string $msg):void
    {
        print "[".date('Y-m-d H:i:s')."] $msg ".PHP_EOL;
    }

    /**
     * runCron : the main function
     */
    public function runCron()
    {
        $this->_log("Launch Cron run action");
        // get storage
        $this->storage = new SqlStorage();
        $configs = $this->storage->getPcronData();
        $pid_file = __DIR__.'/storage/cron.pid';
        $f_handler = fopen($pid_file,'w');
        fwrite($f_handler,getmygid());
        fclose($f_handler);
        $this->_log("cron: started with sqlite");
        $current_time = time();
        $next_time = strtotime("+60 seconds",$current_time);
        while (true)
        {
            $currentTime = time();
            if ($currentTime < $next_time) {
                sleep($next_time - $currentTime + 0.1);
            }

            /** @var \PCRON\Model\Cron $config */
            foreach ($configs as $config)
            {
                try {
                    # minute
                    $timeMatch = $this->match(date('i',$next_time),$config->getMinute());
                    # hour
                    $timeMatch&= $this->match(date('h',$next_time),$config->getHeure());
                    # day
                    $timeMatch&= $this->match(date('d',$next_time),$config->getDay());
                    # month
                    $timeMatch&= $this->match(date('m',$next_time),$this->getMonthNb($config->getMonthName()));
                    # weekday
                    $timeMatch&= $this->match(date('w',$next_time),$this->getDayWeekNb($config->getDayName()));
                    if($timeMatch) {
                        $this->runCmd($config->getCmd());
                    }
                } catch (Exception $e) {
                    $this->_log($e->getMessage());
                }
            }
            $next_time+=60;
        }
    }

    /**
     * runCmd : execute a command line
     *
     * @param $cmd
     */
    private function runCmd($cmd)
    {
        $this->_log("Commande to launched is : $cmd");
        $process = Process::fromShellCommandline($cmd);
        $process->start();
        $this->_log("Process ".$process->getPid()." launched successfully");
        while ($process->isRunning()) {
            $this->_log($process->getOutput());
        }
        $this->_log($process->getOutput());
    }

    /**
     * match : check if expression match
     *
     * @param string $value
     * @param string $express
     * @return int
     */
    function match($value,$express)
    {
        if($express == '*') {
            return 1;
        }
        $values = explode(',',$express);
        foreach ($values as $v)
        {
            if((int)$v == $value) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * getMonthNb : extract the nb month from month name
     *
     * @param string $m
     * @return string
     */
    private function getMonthNb(string $m)
    {
        if($m == '*') {
            return '*';
        }
        $date = date_parse($m);
        return $date['month']??$m;
    }

    /**
     * getDayWeekNb : extract the day numbr in the week
     *
     * @param string $dw
     * @return string
     */
    private function getDayWeekNb(string $dw)
    {
        if($dw == '*') {
            return '*';
        }
        return date('N', strtotime($dw));
    }
}