<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 26.06.13;
 * Experience: 1.5 years.
 */
class db_system_storage implements iStorage
{
    /**
     * @var $dbh PDO();
     */
    protected $dbh;

    /**
     * @return db_system_storage
     */
    public function __constructor()
    {
        global $dbh;
        $this->dbh = $dbh;
        return $this;
    }

    /**
     * @param string $table
     * @return array
     */
    public function get_table_fields($table)
    {
        $data = getData('SELECT name, alias, type, vsblt FROM system WHERE name LIKE :name AND alias <> ""', array(':name' => $table . '_%'));
        $result = array();
        foreach ($data as $row) {
            preg_match('/' . $table . '_(.*)/', $row['name'], $name);
            $row['name'] = $name[1];
            $result[] = array(
                'name' => $row['name'],
                'alias' => $row['alias'],
                'type' => $row['type'],
                'vsblt' => $row['vsblt']
            );
        }
        return $result;
    }

    /**
     * @return array
     */
    public function get_menu()
    {
        return getData('SELECT name, alias FROM system WHERE type = :type AND vsblt = :vsblt', array('type' => 'table', 'vsblt' => 'on'));
    }

    /**
     * @return bool
     */
    public function covert_storage_type()
    {
        // TODO: Implement covert_storage_type() method.
    }


}
