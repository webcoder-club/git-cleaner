<?php

class Helper
{
    /**
     * Начинается ли строка $haystack с подстроки $needle
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function isStringStartWith(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) === 0;
    }

    /**
     * Выводит сколько дней между заданной датой и текущей
     * @param DateTime $dateTime
     * @return int
     */
    public static function getDaysDiff(DateTime $dateTime): int
    {
        $now = new DateTime();
        $interval = $dateTime->diff($now);

        return (int)$interval->format('%a');
    }
}