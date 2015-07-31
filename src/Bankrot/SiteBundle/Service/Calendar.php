<?php

namespace Bankrot\SiteBundle\Service;


class Calendar
{
    private $month;

    private $year;

    private $fullYear = false;

    /**
     * Возвращает многомерный массив из 6 строк и 7 столбцов, содержащий дни месяца.
     * Массив является удобным представлением для отрисовки календаря. Столбцы соответсвуют дням недели, строки - неделям.
     * Если элемент массива содержит null, значит этот день не принадлежит данному месяцу
     */
    public function getMonthTable()
    {
        $firstDay = date('w', mktime(0, 0, 0, $this->month, 1, $this->year)) - 1;

        if ($firstDay < 0) {
            $firstDay = 6;
        }

        $daysInMonth = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));
        $cellCounter = 0;
        $dayCounter  = 1;

        for ($row = 0; $row < 6; $row++) {
            for ($col = 0; $col < 7; $col++) {
                if ($cellCounter >= $firstDay && $dayCounter <= $daysInMonth) {
                    $result[$row][$col]['number'] = $dayCounter;
                    $dayCounter++;
                }
                else {
                    $result[$row][$col] = null;
                }

                $cellCounter++;
            }
        }

        return $result;
    }

    public function getBeginningTimestamp()
    {
        return mktime(0, 0, 0, $this->month, 1, $this->year);
    }

    public function getEndTimestamp()
    {
        $month       = $this->fullYear ? 12 : $this->month;
        $daysInMonth = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));

        return mktime(0, 0, 0, $month, $daysInMonth, $this->year);
    }

    public function getMonthName($month = null)
    {
        if (!$month) {
            $month = $this->month;
        }

        switch ($month) {
            case 1:
                return 'Январь';
            case 2:
                return 'Февраль';
            case 3:
                return 'Март';
            case 4:
                return 'Апрель';
            case 5:
                return 'Май';
            case 6:
                return 'Июнь';
            case 7:
                return 'Июль';
            case 8:
                return 'Август';
            case 9:
                return 'Сентябрь';
            case 10:
                return 'Октябрь';
            case 11:
                return 'Ноябрь';
            case 12:
                return 'Декабрь';
        }
    }

    public function setMonth($month)
    {
        if ($month === '0') {
            $this->fullYear = true;
        }

        if (!$month) {
            $month = date('n');
        }

        $this->month = $month;
    }

    public function setYear($year)
    {
        if (!$year) {
            $year = date('Y');
        }

        $this->year = $year;
    }

    public function getNextMonth()
    {
        if ($this->month == 12) {
            return 1;
        }
        else {
            return ($this->month + 1);
        }
    }

    public function getNextMonthYear()
    {
        if ($this->month == 12) {
            return ($this->year + 1);
        }
        else {
            return $this->year;
        }
    }

    public function getPrevMonth()
    {
        if ($this->month == 1) {
            return 12;
        }
        else {
            return ($this->month - 1);
        }
    }

    public function getPrevMonthYear()
    {
        if ($this->month == 1) {
            return ($this->year - 1);
        }
        else {
            return $this->year;
        }
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getMonthD()
    {
        if ($this->month < 10) {
            return "0" . $this->month;
        }
        else {
            return $this->month;
        }
    }

    public function getYear()
    {
        return $this->year;
    }
}