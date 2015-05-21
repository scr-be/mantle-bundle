<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model;

/**
 * Class HasUrls.
 */
trait HasUris
{
    /**
     * The urls property.
     *
     * @var array
     */
    protected $urls;

    /**
     * Should be called from constructor of entity using this trait.
     *
     * @return $this
     */
    public function initializeUrls()
    {
        $this->urls = [];

        return $this;
    }

    /**
     * Setter for urls property.
     *
     * @param array|null $urls array of urls
     *
     * @return $this
     */
    public function setUrls(array $urls = null)
    {
        $this->urls = $urls;

        return $this;
    }

    /**
     * Getter for urls property.
     *
     * @return array|null
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Checker for urls property.
     *
     * @return bool
     */
    public function hasUrls()
    {
        return (bool) (count((array) $this->getUrls()) > 0);
    }

    /**
     * Check for value in urls array.
     *
     * @param mixed $value value needle to look for
     *
     * @return bool
     */
    public function hasUrlValue($value)
    {
        return (bool) (in_array($value, (array) $this->getUrls()));
    }

    /**
     * Check for key in urls array.
     *
     * @param string $key key needle to look for
     *
     * @return bool
     */
    public function hasUrlKey($key)
    {
        return (bool) (array_key_exists($key, (array) $this->getUrls()));
    }

    /**
     * Retrieve a single url array value.
     *
     * @param string $key the array key to get the value of
     *
     * @return string|null
     */
    public function getUrlValue($key)
    {
        if ($this->hasUrlKey($key)) {
            return $this->getUrls()[$key];
        }

        return;
    }

    /**
     * Set a key->value urls property pair.
     *
     * @param string $key       assignment array key
     * @param mixed  $value     new array item value
     * @param bool   $overwrite overwrite a row if the key already exists
     *
     * @return $this
     */
    public function setUrlValue($key, $value, $overwrite = true)
    {
        $key = (string) $key;

        if ($this->hasUrlKey($key) !== true || $overwrite === true) {
            $this->urls[ $key ] = $value;
        }

        return $this;
    }

    /**
     * Nullify the urls property.
     *
     * @return $this
     */
    public function clearUrls()
    {
        $this->setUrls([]);

        return $this;
    }
}

/* EOF */
