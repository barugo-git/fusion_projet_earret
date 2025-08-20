<?php
// src/Form/DataTransformer/DateToStringTransformer.php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateToStringTransformer implements DataTransformerInterface
{
    /**
     * Transforms a \DateTimeInterface object to a string (dd/mm/yyyy).
     *
     * @param \DateTimeInterface|null $value
     * @return string
     */
    public function transform($value): string
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof \DateTimeInterface) {
            throw new TransformationFailedException('Expected a \DateTimeInterface.');
        }

        return $value->format('d/m/Y');
    }

    /**
     * Transforms a string (dd/mm/yyyy) to a \DateTimeImmutable object.
     *
     * @param string|null $value
     * @return \DateTimeImmutable|null
     */
    public function reverseTransform($value): ?\DateTimeImmutable
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return \DateTimeImmutable::createFromInterface($value);
        }

        if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            throw new TransformationFailedException('Invalid date format (expected dd/mm/yyyy).');
        }

        $date = \DateTimeImmutable::createFromFormat('d/m/Y', $value);

        if (!$date) {
            throw new TransformationFailedException('Invalid date.');
        }

        return $date;
    }
}