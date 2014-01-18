<?
class Model_Action extends Model
{
    public function set_headers()
    {
        $this->headers = '
                <script type="text/javascript" src="/admin/js/jquery-ui-1.8.23.custom.min.js"></script>
                <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
                <script type="text/javascript" src="/admin/js/ajaxupload.3.5.js"></script>
                <script type="text/javascript" src="/admin/js/forAction.js"></script>
            ';
        return $this;
    }

    /**
     * @param string $page
     * @return array
     */
    private function getPageFields($page)
    {
        $data = array();
        $fields = $this->storage->get_table_fields($page);
        foreach($fields as $row) {
            $temp['name'] = $row['name'];
            $temp['alias'] = $row['alias'];
            $temp['type'] = $row['type'];
            switch ($row['type']) {
                case "f_key":
                    preg_match('/f_(.*)_id/', $row['name'], $table);
                    $table = $table[1];
                    $temp['defaultParams'] = getData($this->getQuery(array('id', 'name'), $table));
                    break;
                default:
                    $temp['defaultParams'] = null;
                    break;
            }
            $data['params'][] = $temp;
        }
        return $data;
    }

    /**
     * @param string $page
     * @return array
     */
    public function getAddForm($page)
    {
        $data = $this->getPageFields($page);
        $data['title'] = 'Добавление записи';
        $data['values'] = null;
        return $data;
    }

    /**
     * @param string $page
     * @param int $id
     * @return array
     */
    public function getEditForm($page, $id)
    {
        $data = $this->getPageFields($page);
        $fields = array();
        foreach ($data['params'] as $row) {
            $fields[] = $row['name'];
        }
        $data['title'] = 'Изменение записи';
        $data['id'] = $id;
        $data['values'] = getData($this->getQuery($fields, $page, 'WHERE id =' . $id));
        return $data;
    }
}