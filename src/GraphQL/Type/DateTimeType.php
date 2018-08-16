<?php

namespace App\GraphQL\Type;

class DateTimeType
{
    public static function serialize(\DateTime $value): string
    {
        return $value->format('Y-m-d H:i:s');
    }

    public static function parseValue(string $value = null)
    {
        if (!$value) {
            return null;
        }

        return \DateTime::createFromFormat('Y-m-d H:i:s', $value);
    }

    public static function parseLiteral($valueNode): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $valueNode->value);
    }
}
