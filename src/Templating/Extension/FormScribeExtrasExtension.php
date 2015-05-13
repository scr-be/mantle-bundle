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

use Twig_Environment;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class FormScribeExtrasExtension.
 */
class FormScribeExtrasExtension extends AbstractTwigExtension
{
    /**
     * Initialize the instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->enableOptionHtmlSafe()
            ->enableOptionNeedsEnv()
        ;

        $this->addFunction('form_scribe_submit',                 [$this, 'formSubmit']);
        $this->addFunction('form_scribe_submit_no_wrap',         [$this, 'formSubmitNoWrap']);
        $this->addFunction('form_scribe_label',                  [$this, 'formLabel']);
        $this->addFunction('form_scribe_widget',                 [$this, 'formWidget']);
        $this->addFunction('form_scribe_item_no_label',          [$this, 'formItemNoLabel']);
        $this->addFunction('form_scribe_item_no_label_or_group', [$this, 'formItemNoLabelOrGroup']);
        $this->addFunction('form_scribe_item',                   [$this, 'formItem']);
        $this->addFunction('form_scribe_item_horizontal',        [$this, 'formItemHorizontal']);
        $this->addFunction('form_scribe_start',                  [$this, 'formStart']);
        $this->addFunction('form_scribe_start_horizontal',       [$this, 'formStartHorizontal']);
        $this->addFunction('form_scribe_end',                    [$this, 'formEnd']);
        $this->addFunction('form_make_submit',                   [$this, 'formSubmitOld']);
        $this->addFunction('form_scribe_error',                  [$this, 'formError']);
    }

    public function formSubmitNoWrap(Twig_Environment $twigEnvironment, $form, $title, $defaultRoute = null, $btnClasses = [])
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:submit-no-wrapper.html.twig',
            [
                'form'               => $form,
                'title'              => $title,
                'cancel'             => $this->getReferrer($defaultRoute),
                'renderCancelButton' => ($defaultRoute === null ?: false),
                'btnClasses'         => implode(' ', $btnClasses)
            ]
        );
    }

    public function formSubmit(Twig_Environment $twigEnvironment, $form, $title, $defaultRoute = null, $btnClasses = [])
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:submit.html.twig',
            [
                'form'               => $form,
                'title'              => $title,
                'cancel'             => $this->getReferrer($defaultRoute),
                'renderCancelButton' => ($defaultRoute === null ?: false),
                'btnClasses'         => implode(' ', $btnClasses)
            ]
        );
    }

    public function formLabel(Twig_Environment $twigEnvironment, $form, $label = null, $classes = [])
    {
        $classesStr = implode(' ', $classes);

        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:label.html.twig',
            [
                'form'    => $form,
                'label'   => $label,
                'classes' => $classesStr
            ]
        );
    }

    public function formWidget(Twig_Environment $twigEnvironment, $form, $placeholder, array $attributes = [])
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:widget.html.twig',
            [
                'form'        => $form,
                'placeholder' => $placeholder,
                'attributes'  => $attributes
            ]
        );
    }

    public function formError(Twig_Environment $twigEnvironment, $form)
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:error.html.twig',
            [
                'form' => $form
            ]
        );
    }

    public function formItem(Twig_Environment $twigEnvironment, $form, $label, $placeholder, $cols = null, array $attributes = [])
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:item.html.twig',
            [
                'label'  => $this->formLabel($twigEnvironment, $form, $label),
                'widget' => $this->formWidget($twigEnvironment, $form, $placeholder, $attributes),
                'error'  => $this->formError($twigEnvironment, $form),
                'cols'   => $cols
            ]
        );
    }

    public function formItemHorizontal(Twig_Environment $twigEnvironment, $form, $label, $placeholder, $cols = null, array $attributes = [])
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:itemHorizontal.html.twig',
            [
                'label'  => $this->formLabel($twigEnvironment, $form, $label, ['col-sm-2', 'control-label']),
                'widget' => $this->formWidget($twigEnvironment, $form, $placeholder, $attributes),
                'error'  => $this->formError($twigEnvironment, $form),
                'cols'   => $cols
            ]
        );
    }

    public function formItemNoLabel(Twig_Environment $twigEnvironment, $form, $label, $placeholder, $cols = null, array $attributes = [])
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:item.html.twig',
            [
                'label'  => null,
                'widget' => $this->formWidget($twigEnvironment, $form, $placeholder, $attributes),
                'error'  => $this->formError($twigEnvironment, $form),
                'cols'   => $cols
            ]
        );
    }

    public function formItemNoLabelOrGroup(Twig_Environment $twigEnvironment, $form, $label, $placeholder, $cols = null, array $attributes = [])
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:itemNoGroup.html.twig',
            [
                'label'  => null,
                'widget' => $this->formWidget($twigEnvironment, $form, $placeholder, $attributes),
                'error'  => $this->formError($twigEnvironment, $form),
                'cols'   => $cols
            ]
        );
    }

    public function formStart(Twig_Environment $twigEnvironment, $form, $classes = [], $attr = [])
    {
        $attr['class'] = implode(' ', $classes);

        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:start.html.twig',
            [
                'form' => $form,
                'attr' => $attr
            ]
        );
    }

    public function formStartHorizontal(Twig_Environment $twigEnvironment, $form, $classes = [], $attr = [])
    {
        $classes = array_merge(['form-horizontal'], $classes);

        return $this->formStart($twigEnvironment, $form, $classes, $attr);
    }

    public function formEnd(Twig_Environment $twigEnvironment, $form)
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:end.html.twig',
            [
                'form' => $form
            ]
        );
    }

    public function formSubmitOld(Twig_Environment $twigEnvironment, $title, $defaultRoute = null)
    {
        return $twigEnvironment->render(
            'ScribeMantleBundle:Form:submit-old.html.twig',
            [
                'title'  => $title,
                'cancel' => $this->getReferrer($defaultRoute)
            ]
        );
    }

    public function getReferrer($defaultRoute)
    {
        return $defaultRoute;
    }
}
