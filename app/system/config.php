<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 11.07.13;
 * Experience: 1.5 years.
 */
class config
{
    /**
     * @var string;
     */
    protected static $config_file;

    protected static function init()
    {
        self::$config_file = 'app/system/admin.config';
        if (!file_exists(self::$config_file)) {
            $fp = fopen(self::$config_file, "w");
            fclose($fp);
        }
        if (file_get_contents(self::$config_file) == '') {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $storage = $dom->createElement('storage');
            $storage->setAttribute('selected', 'db_system_storage');
            $dom->appendChild($storage);
            $dom->formatOutput = true;
            $dom->saveXML();
            $dom->save(self::$config_file);
        }
    }

    public static function get_all_storage_types()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(self::$config_file);
        $dom->firstChild->nodeValue = '';
        $s_dir = opendir("app/system/storage/includes/");
        while ($class = readdir($s_dir)) {
            if (!is_dir($class)) {
                preg_match('/(.+)\..+/', $class, $c_name);
                $dom->firstChild->appendChild($dom->createElement('type', $c_name[1]));
            }
        }
        closedir($s_dir);
        $dom->save(self::$config_file);
        $types = $dom->getElementsByTagName('type');
        $data = array();
        foreach($types as $type) {
            $data[] = $type->nodeValue;
        }
        return $data;
    }

    /**
     * @return string;
     */
    public static function get_storage_type()
    {
        self::init();
        $xml = new SimpleXMLElement(file_get_contents(self::$config_file));
        return (string)$xml['selected'];
    }
}
