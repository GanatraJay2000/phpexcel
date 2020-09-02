<?php

class Student
{
    public $identity;
    public $result;
    public $evaluation;

    function __construct($details)
    {
        $this->identity = $details[0];
        $this->result = $details[1];
        $this->evaluation = $details[2];
    }
}
