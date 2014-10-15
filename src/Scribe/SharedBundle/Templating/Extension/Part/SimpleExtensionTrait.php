<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension\Part;

use Twig_Function_Method;

/**
 * Class SimpleExtensionTrait
 */
trait SimpleExtensionTrait
{
    /**
     * @var string
     */
    private $internalTwigMethodName;

    /**
     * @var string
     */
    private $externalTwigMethodName;

    /**
     * @return string
     */
    public function getName()
    {
        return get_class();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setInternalTwigMethodName($name)
    {
        $this->internalTwigMethodName = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getInternalTwigMethodName()
    {
        return $this->internalTwigMethodName;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setExternalTwigMethodName($name)
    {
        $this->externalTwigMethodName = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalTwigMethodName()
    {
        return $this->externalTwigMethodName;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            $this->getExternalTwigMethodName() => new \Twig_Function_Method(
                $this,
                $this->getInternalTwigMethodName(),
                ['is_safe' => ['html']]
            )
        ];
    }

    /**
     * @param string $externalTwigMethodName
     * @param null|string $internalTwigMethodName
     * @return $this
     */
    private function init($externalTwigMethodName, $internalTwigMethodName = null)
    {
        $this->setExternalTwigMethodName($externalTwigMethodName);

        if (null !== $internalTwigMethodName) {
            $this->setInternalTwigMethodName($internalTwigMethodName);
        } else {
            $this->setInternalTwigMethodName($externalTwigMethodName);
        }

        return $this;
    }
}
