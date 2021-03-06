<?php

namespace Portal\Validators;

class DateTimeValidator
{
    private const TIME_REGEX = '/([01][0-9]|2[0-3]):[0-5][0-9]/';
    private const DATE_REGEX = '/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/';

    /**
     * Sanitise as a date in YYYY-MM-DD format
     *
     * @param string $date
     *
     * @return string|null
     * @throws \Exception
     */
    public static function validateDate(?string $date)
    {
        if (!empty($date) && !preg_match(self::DATE_REGEX, $date)) {
            throw new \Exception('Please enter correct date');
        } if (empty($date)) {
            return null;
        } else {
            return $date;
        }
    }

    /**
     * Sanitise as a time in HH:MM 24H format.
     *
     * @param string $time
     * @return string|null
     * @throws \Exception
     */
    public static function validateTime(?string $time)
    {
        if (!empty($time) && !preg_match(self::TIME_REGEX, $time)) {
            throw new \Exception('Please enter correct time');
        } if (empty($time)) {
            return null;
        } else {
            return $time;
        }
    }

    /**
     * Validate that end time is later than start time
     *
     * @param $startTime
     * @param $endTime
     * @return bool
     * @throws \Exception
     */
    public static function validateStartEndTime($startTime, $endTime)
    {
        if ($startTime >= $endTime) {
            throw new \Exception('End time should be later than start time');
        } else {
            return true;
        }
    }
}
