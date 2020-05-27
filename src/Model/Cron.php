<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 5/21/2020
 * Time: 23:09
 */
namespace PCRON\Model;

/**
 * Class Cron
 * @package PCRON\Model
 */
class Cron
{
    private $id;
    private $minute;
    private $heure;
    private $day;
    private $month_name;
    private $day_name;
    private $cmd;

    /**
     * @return mixed
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param mixed $minute
     * @return Cron
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param mixed $heure
     * @return Cron
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     * @return Cron
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMonthName()
    {
        return $this->month_name;
    }

    /**
     * @param mixed $month_name
     * @return Cron
     */
    public function setMonthName($month_name)
    {
        $this->month_name = $month_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayName()
    {
        return $this->day_name;
    }

    /**
     * @param mixed $day_name
     * @return Cron
     */
    public function setDayName($day_name)
    {
        $this->day_name = $day_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * @param mixed $cmd
     * @return Cron
     */
    public function setCmd($cmd)
    {
        $this->cmd = $cmd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Cron
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }




}