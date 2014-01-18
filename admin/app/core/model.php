<?
class Model
{
    public $headers = '';
    /** @var $dbh PDO()  * */
    protected $dbh;
    /**
     * @var iStorage
     */
    protected $storage;

    public function __construct()
    {
        $this->storage = fStorage::get_storage();
        return $this->setDbh()
            ->current_construct()
            ->set_headers();
    }

    private function setDbh()
    {
        global $dbh;
        $this->dbh = $dbh;
        return $this;
    }

    protected function set_headers()
    {
        return $this;
    }

    protected function current_construct()
    {
        return $this;
    }

    public function getQuery($fields, $table, $condition = '')
    {
        $query = 'SELECT ';
        $count = count($fields);
        foreach ($fields as $field) {
            $query .= $field;
            if (--$count) $query .= ', ';
        }
        $query .= ' FROM ' . $table . ' ' . $condition;
        return $query;
    }

    public function escapeStyleAttributes($str)
    {
        return preg_replace(array('/ style=".*?"/s', '/ align=".*?"/s', '/ color=".*?"/s', '/ face=".*?"/s'), '', $str);
    }
}