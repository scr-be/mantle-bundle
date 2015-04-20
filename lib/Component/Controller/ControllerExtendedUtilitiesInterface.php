<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\CssSelector\XPath\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Scribe\Component\Instruction\Set\InstructionSetInterface;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Interface ControllerExtendedUtilitiesInterface.
 */
interface ControllerExtendedUtilitiesInterface extends ControllerBasicUtilitiesInterface
{
    /**
     * Access the entity manager quickly through this short hand method.
     *
     * @return EntityManagerInterface
     */
    public function em();

    /**
     * Flush the pending ORM change set to the database.
     *
     * @param bool $now Should this action literally place *now*?
     *
     * @return bool
     */
    public function emFlush($now = true);

    /**
     * Persist an entity to the database.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change set immediately or not.
     *
     * @return bool
     */
    public function emPersist(AbstractEntity $entity, $flush = false);

    /**
     * Remove an orm entity and optionally flush the transaction.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change set immediately or not.
     *
     * @return bool
     */
    public function emRemove(AbstractEntity $entity, $flush = false);

    /**
     * Access the Twig environment quickly through this short hand method.
     *
     * @return \Twig_Environment
     */
    public function twig();

    /**
     * Renders a template from a file, resolved based on the value of the template parameter.
     *
     * @param string  $templateName The template file to render.
     * @param mixed[] $parameters   An array of parameters passed to the template.
     *
     * @return string
     */
    public function twigTpl($templateName, ...$parameters);

    /**
     * Renders a template from the provided string.
     *
     * @param string  $templateString The template file to render.
     * @param mixed[] $parameters     An array of parameters passed to the template.
     *
     * @return string
     */
    public function twigStr($templateString, ...$parameters);

    /**
     * Returns an HTML response using the provided parameters to construct the Response object instance. The Response
     * object constructor parameters can be found via the Symfony API docs.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function respHTML(...$parameters);

    /**
     * Returns a text response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see respHTML()}.
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function respText(...$parameters);

    /**
     * Returns a JSON response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see respHTML()}.
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function respJSON(...$parameters);

    /**
     * Returns a YAML response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see respHTML()}.
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function respYAML(...$parameters);

    /**
     * Trigger an exception response of any supported type.
     *
     * @param InstructionSetInterface $instructions
     *
     * @return mixed
     */
    public function respException(InstructionSetInterface $instructions);

    /**
     * Create a "Not Found" exception to be thrown.
     *
     * @param string     $message  The exception message string.
     * @param \Exception $previous Optional previous exception instance.
     *
     * @return \Exception
     */
    public function errNotFound($message = null, \Exception $previous = null);

    public function rdrURI(...$parameters);

    public function redirectURL(...$parameters);

    public function route();

    public function routeURI($key, ...$parameters);

    public function routeURL($key, ...$parameters);





    /**
     * Add session message to flashbag.
     *
     * @param string $type    flashbag category (type) to add message to
     * @param string $message message to display
     *
     * @return $this
     */
    public function sessionMessage($type, $message);

    /**
     * Add session success message to flashbag.
     *
     * @param string $message message to display
     *
     * @return $this
     */
    public function sessionMessageSuccess($message);

    /**
     * Add session error message to flashbag.
     *
     * @param string $message message to display
     *
     * @return $this
     */
    public function sessionMessageError($message);

    /**
     * Add session info to flashbag.
     *
     * @param string $message message to display
     *
     * @return $this
     */
    public function sessionMessageInfo($message);

    /**
     * Returns the translation service.
     *
     * @return TranslatorInterface
     */
    public function trans();

    /**
     * Resolves the string value based on a provided key.
     *
     * @param string $key A translation key.
     *
     * @return string
     */
    public function transStr($key);

    /**
     * Returns the request stack service.
     *
     * @return RequestStack
     */
    public function reqStack();

    /**
     * Returns the current request by querying the request stack service. Returns null if no current exists.
     *
     * @return Request|null
     */
    public function reqCurrent();

    /**
     * Returns the master request by querying the request stack service. Returns null if no master request exists.
     *
     * @return Request|null
     */
    public function reqMaster();

    /**
     * Returns the parent request by querying the request stack service. Returns null if no parent request exists.
     *
     * @return Request|null
     */
    public function reqParent();

    /**
     * @return string|null
     */
    public function reqScheme();

    /**
     * @return string|null
     */
    public function reqHost();

    /**
     * @return string|null
     */
    public function reqSchemeAndHost();
}

/* EOF */
