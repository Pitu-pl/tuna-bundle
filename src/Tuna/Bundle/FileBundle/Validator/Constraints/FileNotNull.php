<?php

namespace TheCodeine\FileBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FileNotNull extends Constraint
{
    public $message = 'error.file.empty';
}
