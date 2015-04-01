<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface as OI;
use Symfony\Component\Console\Input\InputInterface as II;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class ScribeCommand.
 */
abstract class AbstractCommand extends ContainerAwareCommand
{
    protected $input    = null;
    protected $output   = null;
    protected $engine   = null;
    protected $progress = null;
    protected $dialog   = null;
    protected $writeIndentLog = [];

    protected function setupBasicServices(II $input, OI $output)
    {
        list($engine, $progress, $dialog) =
            $this->getServices([
                'templating',
                'progress',
                'dialog',
            ])
        ;

        $this->input    = $input;
        $this->output   = $output;
        $this->engine   = $engine;
        $this->progress = $progress;
        $this->dialog   = $dialog;

        $style_title   = new OutputFormatterStyle('white', 'black');
        $style_status  = new OutputFormatterStyle('black', 'blue');
        $style_success = new OutputFormatterStyle('green', 'white');
        $style_em_info = new OutputFormatterStyle('blue', 'white');
        $style_error   = new OutputFormatterStyle('red', 'white', ['bold']);
        $this->output->getFormatter()->setStyle('title', $style_title);
        $this->output->getFormatter()->setStyle('status', $style_status);
        $this->output->getFormatter()->setStyle('success', $style_success);
        $this->output->getFormatter()->setStyle('info_em', $style_em_info);
        $this->output->getFormatter()->setStyle('error', $style_error);
    }

    /**
     * @param array $which
     *
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
     *
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

    final protected function breakLines($string, $width = 120, $padding = 3)
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
                $lines[$linei] .= $words[$i];
            }

            if ($i !== count($words) - 1) {
                $lines[$linei] .= ' ';
            }
        }

        return $lines;
    }

    final protected function createBlock($lines = [], $fg = 'black', $bg = 'white', array $attr = [], $pad_type = STR_PAD_BOTH, $leadAndEndEmptyLine = true, $width = 120, $padding = 3)
    {
        $out = '<fg='.$fg.';bg='.$bg;
        if (count($attr) > 0) {
            for ($i = 0; $i < count($attr); $i++) {
                $out .= ';options='.$attr[$i];
            }
        }
        $out .= '>';

        if ($leadAndEndEmptyLine === true) {
            $out .= "\n".str_pad('', ($width+($padding*2)), ' ', STR_PAD_BOTH)."\n";
        }

        for ($i = 0; $i < count($lines); $i++) {
            for ($j = 0; $j < $padding; $j++) {
                $out .= ' ';
            }
            $out .= str_pad($lines[$i], $width, ' ', $pad_type);
            for ($j = 0; $j < $padding; $j++) {
                $out .= ' ';
            }
            if ($i !== (count($lines)-1) || $leadAndEndEmptyLine === true) {
                $out .= "\n";
            }
        }

        if ($leadAndEndEmptyLine === true) {
            $out .= str_pad('', $width+($padding*2), ' ', STR_PAD_BOTH);
        }

        $out .= '</fg='.$fg.';bg='.$bg;
        if (count($attr) > 0) {
            for ($i = 0; $i < count($attr); $i++) {
                $out .= ';options='.$attr[$i];
            }
        }
        $out .= '>';

        if ($leadAndEndEmptyLine === true) {
            $out .= "\n";
        }

        return $out;
    }

    final protected function createTitle($title, $more = null)
    {
        if (!is_array($more)) {
            $lines = $this->breakLines($more);
        } else {
            $lines = $more;
        }

        array_unshift($lines, '');
        array_unshift($lines, $title);

        return $this->createBlock($lines);
    }

    final protected function createStatus($string, $title = null, $pad_type = STR_PAD_RIGHT)
    {
        if (!is_array($string)) {
            $lines = $this->breakLines($string);
        } else {
            $lines = $string;
        }

        if ($title !== null) {
            array_unshift($lines, '');
            array_unshift($lines, strtoupper($title));
        }

        return $this->createBlock($lines, 'cyan', 'black', [], $pad_type, false);
    }

    final protected function createConfig($string, $title = null, $pad_type = STR_PAD_RIGHT)
    {
        if (!is_array($string)) {
            $lines = $this->breakLines($string);
        } else {
            $lines = $string;
        }

        if ($title !== null) {
            array_unshift($lines, '');
            array_unshift($lines, strtoupper($title));
        }

        return $this->createBlock($lines, 'white', 'magenta', ['bold'], $pad_type);
    }

    final protected function createStatusEm($string, $title = null, $pad_type = STR_PAD_BOTH)
    {
        if (!is_array($string)) {
            $lines = $this->breakLines($string);
        } else {
            $lines = $string;
        }

        if ($title !== null) {
            array_unshift($lines, '');
            array_unshift($lines, strtoupper($title));
        }

        return $this->createBlock($lines, 'white', 'blue', [], $pad_type);
    }

    final protected function createError($string, $title = null, $pad_type = STR_PAD_BOTH)
    {
        if (!is_array($string)) {
            $lines = $this->breakLines($string);
        } else {
            $lines = $string;
        }

        if ($title !== null) {
            array_unshift($lines, strtoupper($title));
        }

        return $this->createBlock($lines, 'white', 'red', ['bold'], $pad_type);
    }

    final protected function createLine($string, $pad_type = STR_PAD_RIGHT)
    {
        if (!is_array($string)) {
            $lines = [$string];
        } else {
            $lines = $string;
        }

        return $this->createBlock($lines, 'white', 'black', [], $pad_type, false);
    }

    final protected function createLineEm($string, $pad_type = STR_PAD_RIGHT)
    {
        if (!is_array($string)) {
            $lines = [$string];
        } else {
            $lines = $string;
        }

        return $this->createBlock($lines, 'white', 'black', ['bold'], $pad_type, false);
    }

    final protected function writeTitle($string, $more = null)
    {
        $this->output->writeln($this->createTitle($string, $more));
    }

    final protected function writeStatus($string, $title = null, $pad_type = STR_PAD_RIGHT)
    {
        $this->output->writeln($this->createStatus($string, $title, $pad_type));
    }

    final protected function writeStatusEm($string, $title = null, $pad_type = STR_PAD_RIGHT)
    {
        $this->output->writeln($this->createStatusEm($string, $title, $pad_type));
    }

    final protected function writeConfig($string, $title = null, $pad_type = STR_PAD_RIGHT)
    {
        $this->output->writeln($this->createConfig($string, $title, $pad_type));
    }

    final protected function writeError($string, $title = null, $pad_type = STR_PAD_BOTH)
    {
        $this->output->writeln($this->createError($string, $title, $pad_type));
    }

    final protected function writeLine($string, $indent_i = 0, $hasChildren = false, $pad_type = STR_PAD_RIGHT)
    {
        $this->output->writeln($this->createLine($this->createLineIndent($indent_i, $hasChildren).$string, $pad_type));
    }

    final protected function writeLineEm($string, $indent_i = 0, $hasChildren = false, $pad_type = STR_PAD_RIGHT)
    {
        $this->output->writeln($this->createLineEm($this->createLineIndent($indent_i, $hasChildren).$string, $pad_type));
    }

    final protected function createLineIndent($indent_i, $hasChildren = false)
    {
        if (!($indent_i > 0)) {
            return '';
        }

        $first_level_with_children = '◎───┬─';
        $first_level_no_children   = '◎─────';
        $next_level_with_children  = '├───┬─';
        $next_level_no_children    = '├─────';

        if (count($this->writeIndentLog) > 0) {
            $this->previous_indent_i = $this->writeIndentLog[count($this->writeIndentLog)-1];
        } else {
            $this->previous_indent_i = 0;
        }
        $this->writeIndentLog[] = $indent_i;

        if ($indent_i == 1) {
            //◎ ┤ ├ ─ ┬ └ http://www.fileformat.info/info/unicode/category/So/list.htm
            return $this->styleLineIndent(($hasChildren === true ? $first_level_with_children : $first_level_no_children).' ', 'magenta', 'black', ['bold']);
        }

        $indent_string = '    ';

        for ($i = 2; $i < $indent_i; $i++) {
            $indent_string .= '    ';
        }

        return $this->styleLineIndent($indent_string.($hasChildren === true ? $next_level_with_children : $next_level_no_children).' ', 'blue', 'black', ['bold']);
    }

    final protected function styleLineIndent($string, $fg, $bg, array $options = [])
    {
        $formattingOptions = '';
        foreach ($options as $o) {
            $formattingOptions .= "options=$o;";
        }

        $formattingTag = "fg=$fg;bg=$bg;$formattingOptions";

        return "<$formattingTag>$string</$formattingTag>";
    }

    final protected function askBooleanQuestion($question, $default = false, $exitOnFalse = false)
    {
        if ($default !== true && $default !== false) {
            $default = false;
        }

        $promptDefaultText = '['.
            ($default === true ? 'Y' : 'y').
            '/'.
            ($default === false ? 'N' : 'n').
            ']'
        ;
        $confirmationQuestion = new ConfirmationQuestion('<question>'.$question.'? '.$promptDefaultText.':</question> ', false);

        $this->output->write('   ');
        if (($result = $this->getHelper('question')->ask($this->input, $this->output, $confirmationQuestion)) !== true && $exitOnFalse === true) {
            $this->writeError('Exiting at the user\'s request');
            die(0);
        }

        return $result;
    }

    protected function getMemoryLimit($humanReadable = true)
    {
        $memoryLimitHard = ini_get('memory_limit');

        if ($humanReadable === true && preg_match('/^(\d+)(.)$/', $memoryLimitHard, $matches)) {
            if ($matches[2] == 'G') {
                $memoryLimitHard = $matches[1] * 1024 * 1024 * 1024;
            } elseif ($matches[2] == 'M') {
                $memoryLimitHard = $matches[1] * 1024 * 1024;
            } elseif ($matches[2] == 'K') {
                $memoryLimitHard = $matches[1] * 1024;
            }
        }

        return $memoryLimitHard;
    }

    protected function isMemoryUsageOptimal()
    {
        $memoryLimitHard = $this->getMemoryLimit(false);

        $memoryLimitSoft = $memoryLimitHard * .75;
        $memoryUsage     = memory_get_usage();

        if ($memoryLimitSoft - $memoryUsage < 0) {
            return false;
        } else {
            return true;
        }
    }
}

/* EOF */
