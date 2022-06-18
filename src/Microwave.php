<?php

namespace tracktik\electronics;

use Exception;

class Microwave extends ElectronicItem
{
    public const type="Microwave";

    public function __construct()
    {
        parent::setType(self::type);
    }

    public function maxExtras(): int
    {
        return 0;
    }

    /**
     * @throws Exception - You can't change a microwave in to something else
     */
    public function setType(string $type): void
    {
        throw new Exception("Changing class type is not allowed");
    }
}