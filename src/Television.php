<?php

namespace tracktik\electronics;

use Exception;

class Television extends ElectronicItem
{
    public const type="Television";

    public function __construct()
    {
        parent::setType(self::type);
    }

    public function maxExtras(): int
    {
        return PHP_INT_MAX; //as close to infinity as we can get in integer type
    }

    /**
     * @throws Exception - You can't change a television in to something else
     */
    public function setType(string $type): void
    {
        throw new Exception("Changing class type is not allowed");
    }
}