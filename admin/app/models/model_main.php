<?
class Model_Main extends Model
{
    protected function set_headers()
    {
        $this->headers = '
                <script type="text/javascript" src="/admin/js/jquery.dataTables.js"></script>
                <script type="text/javascript" src="/admin/js/forMainPage.js"></script>
                <style type="text/css" title="currentStyle">@import "/admin/css/demo_table.css";</style>
            ';
    }

    /**
     * @param string $page
     * @return array
     */
    private function getPageFields($page)
    {
        $data = array();
        $fields = $this->storage->get_table_fields($page);
        foreach ($fields as $row) {
            if ($row['vsblt'] == 'on') {
                $data[] = $row;
            }
        }
        return $data;
    }

    /**
     * @param string $page
     * @return array
     */
    public function getMainTable($page)
    {
        $data = array();
        if ($page == NULL) return $data;
        $temp['columns'] = $this->getPageFields($page);
        $fields = array($page . '.id');
        $condition = '';
        $alf = array('a', 'b', 'c', 'd', 'e', 'f', 'i', 'j', 'k', 'l', 'm', 'n');
        $i = 0;
        foreach ($temp['columns'] as $row) {
            $name = $row['name'];
            if ($row['type'] == 'f_key') {
                preg_match('/f_(.*)_id/', $name, $table);
                $table = $table[1];
                $condition .= ' INNER JOIN ' . $table . ' ON ' . $name . ' = ' . $table . '.id';
                $name = $table . '.name';
            }
            //else $name = $page .'.'. $name;
            $data['fields'][] = array('field' => $alf[$i], 'type' => $row['type']);
            $data['headNames'][] = $row['alias'];
            $fields[] = $name . ' as ' . $alf[$i];
            $i++;
        }
        $data['content'] = getData($this->getQuery($fields, $page, $condition));
        return $data;
    }
}