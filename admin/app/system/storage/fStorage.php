<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 11.07.13;
 * Experience: 1.5 years.
 */
class fStorage
{
    /**
     * @return iStorage;
     */
    public static function get_storage()
    {
        $type = config::get_storage_type();
        return new $type();
    }
}
