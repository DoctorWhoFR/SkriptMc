<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 20/08/2017
 * Time: 20:50
 */

namespace AppBundle\Controller;


class Task
{
    protected $task;
    protected $dueDate;

    public function getName()
    {
        return $this->task;
    }

    public function setName($name)
    {
        $this->task = $name;
    }

    public function getDescription()
    {
        return $this->dueDate;
    }

    public function setDescription($description)
    {
        $this->dueDate = $description;
    }

    public function getVersion()
    {
        return $this->dueDate;
    }

    public function setVersion($description)
    {
        $this->dueDate = $description;
    }

    public function getFile()
    {
        return $this->dueDate;
    }

    public function setFile($description)
    {
        $this->dueDate = $description;
    }

    public function setBigdescription($description)
    {
        $this->dueDate = $description;
    }

    public function getBigdescription()
    {
        return $this->dueDate;
    }
}