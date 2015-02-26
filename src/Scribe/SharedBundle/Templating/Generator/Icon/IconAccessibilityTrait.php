<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Generator\Icon;

use Scribe\SharedBundle\Templating\Generator\Exceptions\TemplatingGeneratorException;

/**
 * Class IconAccessibilityTrait
 *
 * @package Scribe\SharedBundle\Templating\Generator\Icon
 */
trait IconAccessibilityTrait
{
    /**
     * Should the icon be hidden from screen-readers?
     *
     * @var bool
     */
    private $ariaHidden = true;

    /**
     * Descriptive text for an icon to improve accessibility
     *
     * @var null|string
     */
    private $ariaLabel = null;

    /**
     * The role the icon plans within the document
     *
     * @var string
     */
    private $ariaRole = 'presentation';

    /**
     * Short list of the role values supported at this time
     *
     * @var array
     */
    private $validAriaRoles = [
        'img', 'link', 'button', 'presentation'
    ];

    /**
     * Getter for aria hidden accessibility value
     *
     * @return bool
     */
    protected function getAriaHidden()
    {
        return (bool) $this->ariaHidden;
    }

    /**
     * Setter for aria hidden accessibility value
     *
     * @param  bool $hidden
     * @return $this
     */
    public function setAriaHidden($hidden = true)
    {
        $this->ariaHidden = (bool) $hidden;

        return $this;
    }

    /**
     * Checker for aria hidden accessibility value
     *
     * @return bool
     */
    protected function isAriaHidden()
    {
        return (bool) ($this->ariaHidden === true);
    }

    /**
     * Reset icon aria hidden accessibility value
     *
     * @return $this
     */
    public function resetAriaHidden()
    {
        $this->ariaHidden = true;

        return $this;
    }

    /**
     * Getter for aria label accessibility value
     *
     * @return null|string
     */
    protected function getAriaLabel()
    {
        return $this->ariaLabel;
    }

    /**
     * Setter for aria label accessibility value
     *
     * @param  null|string $label
     * @return $this
     */
    public function setAriaLabel($label = null)
    {
        $this->ariaLabel = $label;

        return $this;
    }

    /**
     * Checker for aria label accessibility value
     *
     * @return bool
     */
    protected function hasAriaLabel()
    {
        return (bool) ($this->ariaLabel !== null);
    }

    /**
     * Reset aria label accessibility value
     *
     * @return $this
     */
    public function resetAriaLabel()
    {
        $this->ariaLabel = null;

        return $this;
    }

    /**
     * Getter for aria role accessibility value
     *
     * @return null|string
     */
    protected function getAriaRole()
    {
        return $this->ariaRole;
    }

    /**
     * Setter for aria role accessibility value
     *
     * @param  string $role
     * @return $this
     */
    public function setAriaRole($role)
    {
        if (true !== in_array($role, $this->validAriaRoles)) {

            throw new IconException(
                'You attempted to set an invalid aria role attribute. Valid values: ' . implode(',', $this->validAriaRoles),
                IconException::CODE_INVALID_ARGS
            );
        }

        $this->ariaRole = $role;

        return $this;
    }

    /**
     * Checker for aria role accessibility value
     *
     * @return bool
     */
    protected function hasAriaRole()
    {
        return (bool) ($this->ariaRole !== null);
    }

    /**
     * Reset aria role accessibility value
     *
     * @return $this
     */
    public function resetAriaRole()
    {
        $this->ariaRole = 'presentation';

        return $this;
    }
}

/* EOF */