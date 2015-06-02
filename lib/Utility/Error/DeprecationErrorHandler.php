<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Error;

use Scribe\Utility\StaticClass\StaticClassTrait;

/**
 * Class StringFilter.
 */
class DeprecationErrorHandler
{
    use StaticClassTrait;

    /**
     * @var string
     */
    const MSG_PKG_NAME = 'Mantle';

    /**
     * @var string
     */
    const MSG_PART_DEPRECATED_ON = ' This feature was deprecated %s "%s" ';

    /**
     * @var string
     */
    const MSG_PART_REMOVAL_ON = ' and will be removed %s "%s"';

    /**
     * @var string
     */
    const MSG_PART_FOR_DATETIME = ' on ';

    /**
     * @var string
     */
    const MSG_PART_FOR_VERSION = ' in version ';

    /**
     * @var string
     */
    const MSG_FINAL = '%s [%s:%s] %s. %s %s. Error handler implemented';

    /**
     * @var string
     */
    const DATETIME_ZONE_DEFAULT = 'America/New_York';

    /**
     * @var string
     */
    const DATETIME_FORMAT = 'r';

    /**
     * @var string
     */
    const DATETIME_REGEX = '#([0-9]{4})[\/\.-]{1}([0-9]{1,2})[\/\.-]{1}([0-9]{1,2})\s?(([0-9]{1,2}):([0-9]{2}):?([0-9]{2})?)?\s?([\+-]{1}[0-9]{4})?#';

    /**
     * @param string           $methodName   The fully-qualified method calling the deprecation notice.
     * @param int              $methodLine   The line number of the method calling the deprecation notice.
     * @param string           $message      The deprecated feature explanation.
     * @param string|\DateTime $deprecatedOn Either the version or date the deprecation notice was added.
     * @param string|\DateTime $removalOn    Either the version or date the feature will be removed.
     */
    static public function trigger($methodName, $methodLine, $message, $deprecatedOn, $removalOn)
    {
        $message = sprintf(
            self::MSG_FINAL,
            self::MSG_PKG_NAME,
            (string) $methodName,
            (int)    $methodLine,
            (string) $message,
            self::getDeprecatedOnMessage($deprecatedOn),
            self::getRemovalOnMessage($removalOn)
        );

        trigger_error(
            self::getFinalCleanedMessage($message),
            E_USER_DEPRECATED
        );
    }

    /**
     * @param string $message
     *
     * @return string mixed
     */
    static protected function getFinalCleanedMessage($message)
    {
        $message = preg_replace('#[\s]{2,}#', ' ', $message);
        $message = preg_replace('#[\.]{2,}#', '.', $message);

        return $message;
    }

    /**
     * @param string|\DateTime $when
     *
     * @internal
     *
     * @return string
     */
    static protected function getDeprecatedOnMessage($when)
    {
        return self::getMessagePartOn($when, self::MSG_PART_DEPRECATED_ON);
    }

    /**
     * @param string|\DateTime $when
     *
     * @internal
     *
     * @return string
     */
    static protected function getRemovalOnMessage($when)
    {
        return self::getMessagePartOn($when, self::MSG_PART_REMOVAL_ON);
    }

    /**
     * @param string|\Datetime $when
     * @param string           $messageTemplate
     *
     * @internal
     *
     * @return string
     */
    static protected function getMessagePartOn($when, $messageTemplate)
    {
        if (false !== ($dateTimeFromStr = self::getDateTimeFromString($when))) {
            $when = $dateTimeFromStr;
        }

        if ($when instanceof \DateTime) {
            return sprintf(
                $messageTemplate,
                self::MSG_PART_FOR_DATETIME,
                $when->format(self::DATETIME_FORMAT)
            );
        }

        return sprintf(
            $messageTemplate,
            self::MSG_PART_FOR_VERSION,
            (string) $when
        );
    }

    /**
     * @param string|\DateTime $when
     *
     * @return bool|\DateTime
     */
    static protected function getDateTimeFromString($when)
    {
        if ($when instanceof \Datetime || 1 !== preg_match(self::DATETIME_REGEX, $when, $matches) || ($matchCount = count($matches)) < 4) {
            return false;
        }

        $dateTime = (new \DateTime())->setTimezone(new \DateTimeZone(self::DATETIME_ZONE_DEFAULT));

        if (count($matches) >= 4) {
            $dateTime->setDate((int) $matches[1], (int) $matches[2], (int) $matches[3]);
        }

        if ($matchCount >= 7) {
            $dateTime->setTime((int) $matches[5], (int) $matches[6], isset($matches[7]) ? (int) $matches[7] : 00);
        }

        if ($matchCount === 9) {
            self::attemptDateTimeZoneFromString($dateTime, $matches[8]);
        }

        return $dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @param int       $timezoneOffset
     */
    static protected function attemptDateTimeZoneFromString(\DateTime &$dateTime, $timezoneOffset)
    {
        $timezoneOffsetLength = strlen((int) $timezoneOffset);

        if ($timezoneOffsetLength > 2 && $timezoneOffsetLength !== 4) {
            return;
        }

        if ($timezoneOffsetLength === 4) {
            $timezoneOffset /= 100;
        }

        if ($timezoneOffset > 26 || $timezoneOffset < -26) {
            return;
        }

        $timezoneOffset *= 3600;

        $timezoneConstant = timezone_name_from_abbr('', $timezoneOffset, date('I'));

        if ($timezoneConstant !== false) {
            $dateTime->setTimezone(new \DateTimeZone($timezoneConstant));
        }
    }
}

/* EOF */