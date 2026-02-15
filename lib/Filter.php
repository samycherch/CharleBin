<?php

/**
 * PrivateBin
 *
 * a zero-knowledge paste bin
 *
 * @link      https://github.com/PrivateBin/PrivateBin
 * @copyright 2012 Sébastien SAUVAGE (sebsauvage.net)
 * @license   https://www.opensource.org/licenses/zlib-license.php The zlib/libpng License
 * @version   1.5.1
 */

namespace PrivateBin;

use Exception;

/**
 * Filter
 *
 * Provides data filtering functions.
 */
class Filter
{
    /**
     * format a given time string into a human readable label (localized)
     *
     * accepts times in the format "[integer][time unit]"
     *
     * @access public
     * @static
     * @param  string $time
     * @throws Exception
     * @return string
     */
    public static function formatHumanReadableTime($time)
    {
        $units = [
            's' => I18n::_('second'),
            'm' => I18n::_('minute'),
            'h' => I18n::_('hour'),
            'd' => I18n::_('day'),
            'w' => I18n::_('week'),
            'M' => I18n::_('month'),
            'y' => I18n::_('year'),
        ];
        if (preg_match('/^(\d+)([smhdwMy])$/', $time, $matches)) {
            $value = (int)$matches[1];
            $unit  = $matches[2];
            if ($value > 1) {
                $units[$unit] .= 's';
            }
            return sprintf(I18n::_('%d %s'), $value, $units[$unit]);
        } else {
            throw new Exception('Invalid time format');
        }
    }

    /**
     * format a given number of bytes in IEC 80000-13:2008 notation (localized)
     *
     * @access public
     * @static
     * @param  int $size
     * @return string
     */
    public static function formatHumanReadableSize($size)
    {
        $iec = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        $i   = 0;
        while (($size / 1024) >= 1) {
            $size = $size / 1024;
            ++$i;
        }
        return number_format($size, ($i ? 2 : 0), '.', ' ') . ' ' . I18n::_($iec[$i]);
    }
}
