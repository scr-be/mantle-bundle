<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AjaxResponse.
 */
class AjaxResponse
{
    /**
     * @param array $jsonData
     * @param int   $httpStatusCode
     *
     * @return JsonResponse
     */
    public static function getResponse(array $jsonData, $httpStatusCode)
    {
        return new JsonResponse($jsonData, $httpStatusCode);
    }

    /**
     * @param string  $message
     * @param integer $statusTextCode
     * @param int     $httpStatusCode
     * @param array   $jsonDataAppend
     *
     * @return JsonResponse
     */
    public static function getStandardizedResponse($message, $statusTextCode, $httpStatusCode, array $jsonDataAppend = [])
    {
        $jsonData = [
            'status-http' => $httpStatusCode,
            'message'     => $message,
            'msg'         => $message,
        ];

        if ($statusTextCode === 200) {
            $jsonData['success'] = $message;
            $jsonData['status'] = 'success';
        } elseif ($statusTextCode >= 400) {
            $jsonData['error'] = $message;
            $jsonData['status'] = 'error';
        } else {
            $jsonData['out-of-bounds'] = $statusTextCode;
            $jsonData['status'] = 'unknown';
        }

        return self::getResponse(array_merge($jsonData, $jsonDataAppend), $httpStatusCode);
    }

    /**
     * @param string $message
     * @param array  $jsonDataAppend
     *
     * @return JsonResponse
     */
    public static function getSuccessResponse($message, array $jsonDataAppend = [])
    {
        return self::getStandardizedResponse($message, 200, 200, $jsonDataAppend);
    }

    /**
     * @param string $message
     * @param int    $httpStatusCode
     * @param array  $jsonDataAppend
     *
     * @return JsonResponse
     */
    public static function getErrorResponse($message, $httpStatusCode = 400, array $jsonDataAppend = [])
    {
        return self::getStandardizedResponse($message, 400, $httpStatusCode, $jsonDataAppend);
    }
}

/* EOF */
