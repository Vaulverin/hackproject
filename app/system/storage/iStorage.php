<?php
interface iStorage
{
    /**
     * @param string $table
     * @return array
     */
    public function get_table_fields($table);

    /**
     * @return array
     */
    public function get_menu();

    /**
     * @return bool
     */
    public function covert_storage_type();
}
