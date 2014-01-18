<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 31.07.13;
 * Experience: 1.5 years.
 */
class model_admin_settings extends Model
{
    public function get_admin_settings()
    {
        return config::get_all_storage_types();
    }
}
