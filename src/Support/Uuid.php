<?php 

namespace Limanweb\Uuid\Support;

use Carbon\Carbon;

class Uuid
{
    /**
     * Generate UUID with next structure:
     * 
     * SSSSSSSS-UUUU-UAAA-EEEE-RRRRRRRRRRRR
     * 
     *   S - seconds
     *   U - microseconds
     *   A - appCode
     *   E - entityCode
     *   R - random
     * 
     * @param int $entityCode
     * @param int $appCode
     * @return string
     */
    public static function genUuid(int $entityCode = null, int $appCode = null) : string
    {
        $entityCode = $entityCode ?? 0;
        $appCode    = $appCode ?? 0;
        
        if ($entityCode > 65535 || $appCode > 4095) {
            throw new \Exception('genUuid() invalid arguments');
        }

        $now = Carbon::now();
        
        $micro = self::microHex($now->micro);

        return  self::timestampHex($now->timestamp).'-'.                                        // S
                substr($micro, 0, 4).'-'.substr($micro, -1).                                    // U
                str_pad(dechex($appCode), 3, '0', STR_PAD_LEFT).'-'.                            // A
                str_pad(dechex($entityCode), 4, '0', STR_PAD_LEFT).'-'.                         // E
                str_pad(dechex(random_int(0, 65535*65535*65535 - 1)), 12, '0', STR_PAD_LEFT);   // R
    }

    /**
     * Retrieves timestamp  
     * from 1-13 digits of UUID generated by self::genUuid()
     * 
     * @param string $uuid
     * @param string $format
     * @return DateTime|\Carbon\Carbon|string
     */
    public static function getUuidTimestamp(string $uuid, string $format = 'Carbon')
    {

        $tz = date_default_timezone_get();

        $uuid = str_replace('-', '', $uuid);
        $ts = hexdec(substr($uuid, 0, 8)).'.'.substr(sprintf("%'.06d", hexdec(substr($uuid, 8, 5))), -6);

        if ($format == 'DateTime') {

            return \DateTime::createFromFormat('U.u', $ts)->setTimezone(new \DateTimeZone($tz));

        } elseif ($format == 'Carbon') {

            return Carbon::createFromFormat('U.u', $ts)->timezone($tz);

        }

        return Carbon::createFromFormat('U.u', $ts)->timezone($tz)->format($format);
    }
    
    /**
     * Retrieves application code 
     * from 14-16 digits of UUID generated by self::genUuid()
     * 
     * @param string $uuid
     * @return int
     */
    public static function getUuidAppCode(string $uuid) : int
    {
        return (int) hexdec(substr($uuid, 15, 3));
    }
    
    /**
     * Retrieves application code
     * from 14-16 digits of UUID generated by self::genUuid()
     *
     * @param string $uuid
     * @return int
     */
    public static function getUuidEntityCode(string $uuid) : int
    {
        return (int) hexdec(substr($uuid, 19, 4));
    }
    
    /**
     * Convert int-timestamp to hex-string
     *
     * @param int $timestamp
     * @return string
     */
    public static function timestampHex(int $timestamp = null)
    {
        $timestamp = $timestamp ?? now()->timestamp;
        
        return str_pad(dechex($timestamp), 8, '0', STR_PAD_LEFT);
    }

    /**
     * Convert int-microseconds to hex-string
     *
     * @param int $timestamp
     * @return string
     */
    public static function microHex(int $micro = null)
    {
        $micro = $micro ?? now()->micro;
        
        return str_pad(dechex($micro), 5, '0', STR_PAD_LEFT);
    }
}