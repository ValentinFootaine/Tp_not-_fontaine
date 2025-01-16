<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;


class UniqueTimeSlot extends Constraint
{
    public $message = 'Cette plage horaire est déjà réservée pour cette date.';
}