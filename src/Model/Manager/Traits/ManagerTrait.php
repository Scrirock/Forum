<?php

namespace Scrirock\Forum\Model\Manager\Traits;

trait ManagerTrait {

    private static ?ManagerTrait $manager = null;

    /**
     * @return self
     */
    public static function getManager(): self {
        if(is_null(self::$manager)) {
            self::$manager = new self();
        }
        return self::$manager;
    }
}