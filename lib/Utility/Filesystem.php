<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility;

use Scribe\Utility\Controller\ControllerUtils;
use Scribe\Exception\InvalidArgumentException;
use Scribe\SharedBundle\Entity\CachedFilesystemEntrySizeRepository;

/**
 * Class Filesystem.
 */
class Filesystem
{
    /**
     * Bytes string representation.
     *
     * @var string
     */
    const UNIT_TYPE_BYTE = 'B';

    /**
     * Kilobyte string representation.
     *
     * @var string
     */
    const UNIT_TYPE_KILOBYTE = 'KB';

    /**
     * Megabyte string representation.
     *
     * @var string
     */
    const UNIT_TYPE_MEGABYTE = 'MB';

    /**
     * Gigabyte string representation.
     *
     * @var string
     */
    const UNIT_TYPE_GIGABYTE = 'GB';

    /**
     * Terabyte string representation.
     *
     * @var string
     */
    const UNIT_TYPE_TERABYTE = 'TB';

    /**
     * Petabyte string representation.
     *
     * @var string
     */
    const UNIT_TYPE_PETABYTE = 'PB';

    /**
     * Conversion divisor for base-10 sizes.
     *
     * @var string
     */
    const UNIT_BASE_10 = 1000;

    /**
     * Conversion divisor for base-02 sizes.
     *
     * @var string
     */
    const UNIT_BASE_02 = 1024;

    /**
     * General purpose utility class shared between all controllers.
     *
     * @var ControllerUtils
     */
    private $utils;

    /**
     * Repo class for cached filesystem directory sizes.
     *
     * @var CachedFilesystemEntrySizeRepository
     */
    private $cachedFilesystemEntrySizeRepository;

    /**
     * Initialize and setup this object instance.
     *
     * @param ControllerUtils                     $utils
     * @param CachedFilesystemEntrySizeRepository $cachedFilesystemEntrySizeRepository
     */
    public function __construct(
        ControllerUtils $utils,
        CachedFilesystemEntrySizeRepository $cachedFilesystemEntrySizeRepository)
    {
        $this->utils                               = $utils;
        $this->cachedFilesystemEntrySizeRepository = $cachedFilesystemEntrySizeRepository;
    }

    /**
     * @param string $path
     * @param string $separator
     */
    public static function sanitizePath($path, $separator = DIRECTORY_SEPARATOR)
    {
        return preg_replace('#'.$separator.'+#', $separator, $path);
    }

    /**
     * Ingests a directory path with optional assignment of the directory
     * separator and returns the path parts (read: folders) as either a
     * single= or multi-dimensional array.
     *
     * @param string $path                   a path string to parse
     * @param bool   $singleDimensionalArray if set to true, this functions return value reverts back to
     *                                       previous behaviour of a single-dimensional array return formatted
     *                                       as a {@see $pathParts} -> {@see $pathIncrementalParts} key->value array
     * @param string $directorySeparator     optional specifier of a different directory separator than the
     *                                       separator used for the currently-running operating system
     *
     * @return array
     */
    public static function parseDirectoryPathToParts($path, $singleDimensionalArray = false, $directorySeparator = DIRECTORY_SEPARATOR)
    {
        // split the path into an array on its directory separator
        $pathParts = explode($directorySeparator, $path);

        // if the first part is empty assume absolute root path
        $rootPath = empty($pathParts[0]) ? true : false;

        // filter array for empty values (example: double directory separators would cause this)
        $pathParts = array_values(array_filter($pathParts, function ($part) {
                    return (bool) !empty($part);
                }));

        // get our working variable ready as empty array
        $pathIncrementalParts = [];

        // for each item in path, do...
        for ($i = 0; $i < count($pathParts); $i++) {

            // get our temp path build array ready
            $pathBuilder = [];

            // loop backwards in path parts, beginning with current part
            for ($j = $i; $j >= 0; $j--) {
                // this gives us an array of dir parts up to the current part
                array_unshift($pathBuilder, $pathParts[$j]);
            }

            $incrementalPath = $rootPath === true ?
                DIRECTORY_SEPARATOR.implode($directorySeparator, $pathBuilder) :
                implode($directorySeparator, $pathBuilder);

            // push the temp built path onto part of returned array
            array_push($pathIncrementalParts, $incrementalPath);
        }

        // does the user want a single-dimensional array?
        if ($singleDimensionalArray === true) {
            return array_combine($pathParts, $pathIncrementalParts);
        }

        // return a multi-dimensional array of both discrete and incremental arrays
        return [
            $pathParts,
            $pathIncrementalParts,
            count($pathParts),
        ];
    }

    /**
     * Ingests an arbitrary size of either base-02 or base-10 and converts it to the largest size that
     * results in a whole number, before returning an array with two objects - one with the original
     * size information, and a second with the converted size information.
     *
     * @param integer $sizeToConvert    the size value to convert
     * @param string  $providedUnitType the unit type provided
     * @param string  $maxUnitType      an optional max unit type for the conversion
     * @param integer $unitBase         an optional specifier of either a base-02 or base-10 number
     *
     * @return array
     */
    public static function convertSizeUnitType($sizeToConvert, $providedUnitType = self::UNIT_TYPE_BYTE, $maxUnitType = self::UNIT_TYPE_PETABYTE, $unitBase = self::UNIT_BASE_02)
    {
        // order our units
        $units = [
            self::UNIT_TYPE_BYTE,
            self::UNIT_TYPE_KILOBYTE,
            self::UNIT_TYPE_MEGABYTE,
            self::UNIT_TYPE_GIGABYTE,
            self::UNIT_TYPE_TERABYTE,
            self::UNIT_TYPE_PETABYTE,
        ];

        // check for a valid provided and max unit type
        if (!in_array($providedUnitType, $units) || !in_array($maxUnitType, $units)) {
            throw new InvalidArgumentException('Invalid unit type specified: '.$unitBase);
        }

        // use the unit-type array position (its key) to determine the starting step and max depth
        $step  = array_search($providedUnitType, $units);
        $depth = array_search($maxUnitType, $units);

        // begin the conversion with the passed size
        $size = $sizeToConvert;

        // continue while size is small than 1 of the next unit or we reach our max depth
        while ($size >= $unitBase && $step <= $depth) {

            // divide the size by the unit base
            $size /= $unitBase;

            // increment our depth counter
            $step++;
        }

        // compile an object of the original size info
        $originalSizeInfo = (object) [
            'type' => 'provided',
            'size' => $sizeToConvert,
            'unit' => $providedUnitType,
            'base' => $unitBase,
        ];

        // compile an object of the new size info
        $convertedSizeInfo = (object) [
            'type' => 'converted',
            'size' => $size,
            'unit' => $units[$step],
            'base' => $unitBase,
        ];

        // return an array with both original and new size info objects
        return [
            $convertedSizeInfo,
            $originalSizeInfo,
        ];
    }
}

/* EOF */
