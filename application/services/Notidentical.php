<?php

class Notidentical extends Zend_Validate_Identical
{
    public function isValid($value)
    {
        return !parent::isValid($value);
    }
}