<?php

namespace Scribe\SharedBundle\Component\Exceptions;

class IconFormatterException extends \Exception 
{
    const INVALID_STYLE  = 10;
    const MISSING_ENTITY = 11;
    const MISSING_ARGS   = 12;
}
