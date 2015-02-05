<?php

namespace Avoran\Doctrine\DBAL\Types;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

class DateTimeDefaultTzType extends DateTimeType
{
    const DATETIME_DEFAULT_TZ = 'datetime_default_tz';

    public function getName()
    {
        return self::DATETIME_DEFAULT_TZ;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return ($value !== null) ?
            $value->setTimezone($this->dateTimeZone())->format($platform->getDateTimeFormatString()) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof DateTime) {
            return $value->setTimezone($this->dateTimeZone());
        }

        $val = DateTime::createFromFormat($platform->getDateTimeFormatString(), $value, $this->dateTimeZone());

        if (!$val) {
            $val = date_create($value, $this->dateTimeZone());
        }

        if (!$val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $val;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    private function dateTimeZone()
    {
        return new DateTimeZone(date_default_timezone_get());
    }
}
