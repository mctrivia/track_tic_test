<?php

namespace tracktik\electronics;

use Exception;

class Controller extends ElectronicItem
{
    public const type="Controller";

    public function __construct()
    {
        parent::setType(self::type);
    }

    public function maxExtras(): int
    {
        return 0;
    }

    /**
     * @throws Exception - You can't change a Controller in to something else
     */
    public function setType(string $type): void
    {
        throw new Exception("Changing class type is not allowed");
    }
}