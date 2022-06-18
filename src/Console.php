<?php

namespace tracktik\electronics;

use Exception;

class Console extends ElectronicItem
{
    public const type="Console";

    public function __construct()
    {
        parent::setType(self::type);
    }

    public function maxExtras(): int
    {
        /// didn't do php docs because docs of ElectronicItem still apply and my IDE pulls them up.  Re documenting it
        /// would cause possible upkeep issues
        return 4;
    }

    /**
     * @throws Exception - You can't change a console in to something else
     */
    public function setType(string $type): void
    {
        throw new Exception("Changing class type is not allowed");
    }
}