<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 30.07.13;
 * Experience: 1.5 years.
 */
class xml_system_storage implements iStorage
{
    /**
     * @var string
     */
    protected $storage_file;
    /**
     * @var PDO
     */
    protected $dbh;
    /**
     * @var string
     */
    protected $db_name;

    public function constructor()
    {
        global $dbh;
        $this->dbh = $dbh;
        global $dbName;
        $this->db_name = $dbName;
        $this->storage_file = 'app/system/storage.xml';
        if (!file_exists($this->storage_file)) {
            $fp = fopen($this->storage_file, "w");
            fclose($fp);
        }
        if (file_get_contents($this->storage_file) == '') {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $storage = $dom->createElement('storage');
            $dom->appendChild($storage);
            $dom->formatOutput = true;
            $dom->saveXML();
            $dom->save($this->storage_file);
        }
    }

    /**
     * @return array
     */
    public function get_menu()
    {
        // TODO: Implement get_menu() method.
    }

    /**
     * @param string $table
     * @return array
     */
    public function get_table_fields($table)
    {
        // TODO: Implement get_table_fields() method.
    }

    /**
     * @return bool
     */
    public function covert_storage_type()
    {
        $system_data = getData('SELECT * FROM system WHERE type = "table"');
        if ($system_data != null) {
            $dom = new DOMDocument();
            $dom->load($this->storage_file);
            $root = $dom->firstChild;
            $root->nodeValue = '';
            foreach ($system_data as $table) {
                $item = $dom->createElement('table');
                $item->setAttribute('id', $table['name']);
                $item->setAttribute('alias', $table['alias']);
                $item->setAttribute('plugins', $table['params']);
                $item->setAttribute('display', $table['vsblt']);
                $tmp = $this->dbh->prepare('SELECT * FROM system WHERE name LIKE "' . $table . '_%"');
                $tmp->execute();
                while ($row = $tmp->fetch()) {
                    $field = $dom->createElement('field');
                    preg_match('/' . $table . '_(.*)/', $row['name'], $result);
                    $field->setAttribute('name', $result[1]);
                    $field->setAttribute('type', $row['type']);
                    $field->setAttribute('alias', $row['alias']);
                    $field->setAttribute('display', $row['vsblt']);
                    $item->appendChild($field);
                }
                $root->appendChild($item);
            }
        }
    }


}
