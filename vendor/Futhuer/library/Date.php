<?php

namespace Futhuer;

class Date {

    const FORMAT = 'd.m.Y';

    const DAY   = 'Day';
    const WEEK  = 'Week';
    const MONTH = 'Month';
    const YEAR  = 'Year';

    const OP_ADD = '+';
    const OP_SUB = '-';

    private $date;

    public function __construct($date) {
        $this->date = $date;
    }

    /**
     *
     * @param char $operator '+' or '-'
     * @param int $difference int
     * @param string $datepart Part of the Date like day, week, month or year
     * @return string
     */
    public function modify($operator, $difference, $datepart){
        $this->date = date(self::FORMAT,strtotime($this->date . $operator . $difference . " " . $datepart)); //01.02.2013 + 3 Week
        return $this->date;
    }

    
}

?>
