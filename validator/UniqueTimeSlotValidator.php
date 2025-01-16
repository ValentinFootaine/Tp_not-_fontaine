<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\ReservationRepository;

class UniqueTimeSlotValidator extends ConstraintValidator
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $reservation = $this->context->getObject();

        if (!$this->reservationRepository->isTimeSlotAvailable($reservation->getDate(), $reservation->getTimeSlot())) {
            $this->context->buildViolation($constraint->message)
                ->atPath('timeSlot')
                ->addViolation();
        }
    }
}