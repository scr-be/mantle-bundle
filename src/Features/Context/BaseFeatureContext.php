<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Abstract class BaseFeatureContext
 * Defines basic contexts, helper functions, and global constants for use within
 * each bundle featurecontext definitions.
 */
class BaseFeatureContext extends MinkContext implements Context
{
    /**
     * @var string
     */
    const SECURITY_BASIC_USER_NAME = 'flast@scribenet.com';

    /**
     * @var string
     */
    const SECURITY_BASIC_USER_PASS = 'n,XYQu9q';

    /**
     * @var string
     */
    const SECURITY_BASIC_USER_ROLE = 'ROLE_HUB_USER';

    protected $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Then /^Container should have parameter "([^"]*)"$/
     */
    public function containerShouldHaveParameter($config_key)
    {
        $container = $this->kernel->getContainer();
        $container->getParameter($config_key);
    }

    /**
     * @Given /^The app kernel is available$/
     */
    public function theAppKernelIsAvailable()
    {
        if (! $this->kernel instanceof KernelInterface) {
            throw new \Exception('The App Kernel is not available');
        }
    }

    /**
     * @Given /^The container is available$/
     */
    public function theContainerIsAvailable()
    {
        if (! $this->kernel->getContainer() instanceof \appTestDebugProjectContainer) {
            throw new \Exception('The App Debug Project Container is not available');
        }
    }

    /**
     * @param string $target
     */
    public function findByText($text, $target)
    {
        $page = $this->getSession()->getPage();
        $anchors = $page->findAll('css', $target);
        foreach ($anchors as $a) {
            if ($a->getText() == $text) {
                return $a;
            }
        }
    }

    /**
     * @return string
     */
    public function relativeToAbsolute($target)
    {
        $matches = [];
        preg_match('/[^\/]+/', $target, $matches);
        $router = $this->kernel->getContainer()->get('router');
        $route = $router->match($target);
        $myRoute = $route['_route'];
        $myRoute = ($myRoute == 'security_dashboard' ? 'login' : $myRoute); # hard-code the redirect...
        $url = $router->generate($myRoute, [], true);

        return $url;
    }

    /**
     * @Given /^I follow "([^"]*)" with context$/
     */
    public function followWithContext($linkText)
    {
        $session = $this->getSession();
        $url = $session->getCurrentUrl();
        $session->setRequestHeader('Referer', $url);
        $link = $this->findByText($linkText, 'a');
        $relTarget = $link->getAttribute("href");
        $absTarget = $this->relativeToAbsolute($relTarget);
        $session->visit($absTarget);
    }

    /**
     * @Given /^I press "([^"]*)" with context$/
     */
    public function pressWithContext($linkText)
    {
        $session = $this->getSession();
        $url = $session->getCurrentUrl();
        $session->setRequestHeader('Referer', $url);
        $link = $this->findByText($linkText, 'button');
        $link->click();
    }

    /**
     * @Given /^I unload the page to "([^"]*)"$/
     */
    public function unloadThePageTo($fileName)
    {
        $html = $this->getSession()->getDriver()->getContent();
        file_put_contents($fileName, $html);
    }

    /**
     * @Given /^spill "([^"]*)"$/
     */
    public function spill($something)
    {
        var_dump(eval('return '.$something.';'));
    }

    // below are basic feature context actions for use in hooks

    public function makeUserCommand()
    {
        exec(
            'app/console scribe:security:user:make '.
            self::SECURITY_BASIC_USER_NAME.' '.
            self::SECURITY_BASIC_USER_PASS.' '.
            self::SECURITY_BASIC_USER_ROLE
        );
    }

    public function deleteUserProjectsCommand()
    {
        exec(
            'app/console scribe:hub:project:clear '.
            self::SECURITY_BASIC_USER_NAME
        );
    }

    /**
     * @When /^I follow the first item in the "([^"]*)" elements group$/
     */
    public function followFirstItem($cssPattern)
    {
        $page = $this->getSession()->getPage();
        $page->findAll('css', $cssPattern)[0]->click();
    }

     /**
      * @Given /^the url should not match "([^"]*)"$/
      */
     public function theUrlShouldNotMatch($pattern)
     {
         $url = $this->getSession()->getCurrentUrl();
         if (preg_match("|".preg_quote($pattern)."|", $url)) {
             throw new \Exception('We did not go to a new blog page!');
         }
     }
}

/* EOF */
