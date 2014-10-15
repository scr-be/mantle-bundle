<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class AbstractCommand
 */
abstract class AbstractCommand extends ContainerAwareCommand
{

    /**
     * @param string[] $which
     * @return array
     */
    final protected function getServices(array $which = [])
    {
        $services = [];
        foreach ($which as $service_key) {
            $services[] = $this->getServiceSelector($service_key);
        }

        return $services;
    }

    /**
     * @param string $service_key
     * @return object
     */
    final protected function getServiceSelector($service_key)
    {
        switch ($service_key) {
            case 'em':
                return $this
                    ->getContainer()
                    ->get('doctrine.orm.entity_manager')
                ;
            case 'progress':
                return $this
                    ->getHelperSet()
                    ->get('progress')
                ;
            case 'dialog':
                return $this
                    ->getHelperSet()
                    ->get('dialog')
                ;
            default:
                return $this
                    ->getContainer()
                    ->get($service_key)
                ;
        }
    }

    final protected function breakLines($string, $width = 80, $padding = 4)
    {
        $max_string_width = $width - ($padding * 2);

        if (strlen($string) <= $max_string_width) {
            return [$string];
        }

        $words = explode(' ', $string);
        $lines = [0 => ''];
        $linei = 0;

        for ($i = 0; $i < count($words); $i++) {
            if (strlen($lines[$linei].$words[$i]) > $max_string_width) {
                $linei++;
            }

            if (!isset($lines[$linei]) || empty($lines[$linei])) {
                $lines[$linei] = $words[$i];
            } else {
                $lines[$linei] .= ' '.$words[$i];
            }
        }

        return $lines;
    }

    final protected function createBlock($lines = [], $fg = 'black', $bg = 'white', $width = 80)
    {
        $out = '<fg='.$fg.';bg='.$bg.'>'."\n";
        $out .= str_pad('', $width, ' ', STR_PAD_BOTH)."\n";

        for ($i = 0; $i < count($lines); $i++) {
            $out .= str_pad($lines[$i], $width, ' ', STR_PAD_BOTH)."\n";
        }

        $out .= str_pad('', $width, ' ', STR_PAD_BOTH);
        $out .= '</fg='.$fg.';bg='.$bg.'>';

        return $out;
    }

    /**
     * @param string $title
     * @param string $more
     */
    final protected function createTitle($title, $more = null)
    {

        $lines = $this->breakLines($more);
        array_unshift($lines, $title);

        return $this->createBlock($lines);
    }

    final protected function createStatus($string, $fg = 'green', $bg = 'black')
    {
        $lines = $this->breakLines($string);
        return $this->createBlock($lines, $fg, $bg);
    }

}
