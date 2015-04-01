<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Extension;

use Scribe\MantleBundle\Templating\Extension\Part\AdvancedExtensionTrait;
use Scribe\MantleBundle\Templating\Extension\Part\ContainerAwareExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;

/**
 * Class FormScribeExtrasExtension.
 */
class FormScribeExtrasExtension extends Twig_Extension
{
    use AdvancedExtensionTrait, ContainerAwareExtensionTrait;

    /**
     * constructor.
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
        $this->addFunctionMethod('formSubmit',          'form_scribe_submit');
        $this->addFunctionMethod('formSubmitNoWrap',    'form_scribe_submit_no_wrap');
        $this->addFunctionMethod('formLabel',           'form_scribe_label');
        $this->addFunctionMethod('formWidget',          'form_scribe_widget');
        $this->addFunctionMethod('formItemNoLabel',     'form_scribe_item_no_label');
        $this->addFunctionMethod('formItemNoLabelOrGroup', 'form_scribe_item_no_label_or_group');
        $this->addFunctionMethod('formItem',            'form_scribe_item');
        $this->addFunctionMethod('formItemHorizontal',  'form_scribe_item_horizontal');
        $this->addFunctionMethod('formStart',           'form_scribe_start');
        $this->addFunctionMethod('formStartHorizontal', 'form_scribe_start_horizontal');
        $this->addFunctionMethod('formEnd',             'form_scribe_end');
        $this->addFunctionMethod('formSubmitOld',       'form_make_submit');
        $this->addFunctionMethod('formError',           'form_scribe_error');
    }

    /**
     * @param FormType $form
     * @param string   $defaultRoute
     *
     * @return mixed
     */
    public function formSubmitNoWrap($form, $title, $defaultRoute = null, $btnClasses = [])
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:submit-no-wrapper.html.twig',
            [
                'form'               => $form,
                'title'              => $title,
                'cancel'             => $this->getReferer($defaultRoute),
                'renderCancelButton' => $defaultRoute === null ? true : false,
                'btnClasses'         => implode(' ', $btnClasses),
            ]
        );
    }

    /**
     * @param FormType $form
     * @param string   $defaultRoute
     *
     * @return mixed
     */
    public function formSubmit($form, $title, $defaultRoute = null, $btnClasses = [])
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:submit.html.twig',
            [
                'form'               => $form,
                'title'              => $title,
                'cancel'             => $this->getReferer($defaultRoute),
                'renderCancelButton' => $defaultRoute === null ? true : false,
                'btnClasses'         => implode(' ', $btnClasses),
            ]
        );
    }

    /**
     * @param FormType $form
     * @param string   $label
     *
     * @return mixed
     */
    public function formLabel($form, $label = null, $classes = [])
    {
        $classesStr = implode(' ', $classes);

        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:label.html.twig',
            [
                'form'  => $form,
                'label' => $label,
                'classes' => $classesStr,
            ]
        );
    }

    /**
     * @param FormType $form
     * @param string   $placeholder
     *
     * @return mixed
     */
    public function formWidget($form, $placeholder, array $attributes = array())
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:widget.html.twig',
            [
                'form'        => $form,
                'placeholder' => $placeholder,
                'attributes'  => $attributes,
            ]
        );
    }

    /**
     * @param FormType $form
     *
     * @return mixed
     */
    public function formError($form)
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:error.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    /**
     * @param FormType $form
     * @param string   $label
     * @param string   $placeholder
     * @param null|int $cols
     *
     * @return mixed
     */
    public function formItem($form, $label, $placeholder, $cols = null, array $attributes = array())
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:item.html.twig',
            [
                'label'  => $this->formLabel($form, $label),
                'widget' => $this->formWidget($form, $placeholder, $attributes),
                'error'  => $this->formError($form),
                'cols'   => $cols,
            ]
        );
    }

    /**
     * @param FormType $form
     * @param string   $label
     * @param string   $placeholder
     * @param null|int $cols
     *
     * @return mixed
     */
    public function formItemHorizontal($form, $label, $placeholder, $cols = null, array $attributes = array())
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:itemHorizontal.html.twig',
            [
                'label'  => $this->formLabel($form, $label, ['col-sm-2', 'control-label']),
                'widget' => $this->formWidget($form, $placeholder, $attributes),
                'error'  => $this->formError($form),
                'cols'   => $cols,
            ]
        );
    }

    /**
     * @param FormType $form
     * @param string   $label
     * @param string   $placeholder
     * @param null|int $cols
     *
     * @return mixed
     */
    public function formItemNoLabel($form, $label, $placeholder, $cols = null, array $attributes = array())
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:item.html.twig',
            [
                'label'  => null,
                'widget' => $this->formWidget($form, $placeholder, $attributes),
                'error'  => $this->formError($form),
                'cols'   => $cols,
            ]
        );
    }

    /**
     * @param FormType $form
     * @param string   $label
     * @param string   $placeholder
     * @param null|int $cols
     *
     * @return mixed
     */
    public function formItemNoLabelOrGroup($form, $label, $placeholder, $cols = null, array $attributes = array())
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:itemNoGroup.html.twig',
            [
                'label'  => null,
                'widget' => $this->formWidget($form, $placeholder, $attributes),
                'error'  => $this->formError($form),
                'cols'   => $cols,
            ]
        );
    }

    /**
     * @param Form $form
     *
     * @return string
     */
    public function formStart($form, $classes = [], $attr = [])
    {
        $attr['class'] = implode(' ', $classes);

        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:start.html.twig',
            [
                'form' => $form,
                'attr' => $attr,
            ]
        );
    }

    /**
     * @param Form $form
     *
     * @return string
     */
    public function formStartHorizontal($form, $classes = [], $attr = [])
    {
        $classes = array_merge(['form-horizontal'], $classes);

        return $this->formStart($form, $classes, $attr);
    }

    /**
     * @param Form $form
     *
     * @return string
     */
    public function formEnd($form)
    {
        return $this->getEngine()->render(
            'ScribeMantleBundle:Form:end.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    /**
     * @param null|string $defaultRoute
     *
     * @return string
     */
    private function getReferer($defaultRoute = null)
    {
        $refererContext = $this->container->get('request.referer.context');
        $referer        = $refererContext->initWithDefault($defaultRoute)->getRedirect();

        return $referer;
    }

    public function formSubmitOld($title, $defaultRoute = null)
    {
        $engine         = $this->container->get('templating');
        $refererContext = $this->container->get('request.referer.context');
        $referer        = $refererContext->initWithDefault($defaultRoute)->getRedirect();

        return $engine->render(
            'ScribeMantleBundle:Form:submit-old.html.twig',
            [
                'title'  => $title,
                'cancel' => $referer,
            ]
        );
    }
}
