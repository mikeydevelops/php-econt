<?php

namespace MikeyDevelops\Econt\Utilities;

use DateTimeZone;

class DateTime extends \DateTime
{
    /**
     * The default timezone of the object.
     *
     * @var string
     */
    protected static $timezone = 'Europe/Sofia';

    /**
     * Parse a date into a DateTime object.
     *
     * @param  integer|string|\DateTimeInterface  $date  The date to parse.
     *          If it is an integer, it is parsed as unix timestamp.
     *          A string is parsed using strtotime when no format is provided,
     *          otherwise using DateTime::createFromFormat().
     *          If a DateTimeInterface is provided, it is cloned to a DateTime instance.
     * @param  string|null  $format  [optional]  The format of the provided $date string.
     * @param  \DateTimeZone|string|null  [optional]  Set the time zone of the instance.
     * @return \DateTime
     */
    public static function create($date, ?string $format = null, $timezone = null): DateTime
    {
        $tz = static::timezone($timezone);

        if (is_string($date) && !is_null($format)) {
            return static::createFromFormat($format, $date, $tz);
        }

        $isUnix = false;

        if (is_numeric($date)) {
            $isUnix  = true;
            $date = "@$date";
        }

        $date = new static($date, $tz);

        $isUnix && $date->setTimezone($tz);

        return $date;
    }

    /**
     * Set the default timezone.
     *
     * @param  \DateTimeZone|string  $timezone  One of the supported timezone names, an offset value (+0200), or a timezone abbreviation (BST).
     * @see https://www.php.net/manual/en/timezones.php
     * @see https://www.php.net/manual/en/datetimezone.construct.php
     */
    public static function setDefaultTimezone($timezone): void
    {
        if (! $timezone instanceof DateTimeZone) {
            $timezone = new DateTimeZone($timezone);
        }

        static::$timezone = $timezone->getName();
    }

    /**
     * Get a \DateTimeZone instance based on provided timezone or get the default if null provided.
     *
     * @param  \DateTimeZone|string|null  $timezone  One of the supported timezone names, an offset value (+0200), or a timezone abbreviation (BST).
     * @return \DateTimeZone
     */
    public static function timezone($timezone = null): DateTimeZone
    {
        if ($timezone instanceof DateTimeZone) {
            $timezone = $timezone->getName();
        }

        return new DateTimeZone($timezone ?? static::$timezone);
    }
}
