<?php
    class Model_Data extends Model
    {
        /**
         * @param $page string
         * @return string
         * @throws Exception
         */
        public function insertRow($page) {
            if(count($_POST) <= 0) throw new Exception('POST - пуст!');
            $fields = $this->storage->get_table_fields($page);
            $count = count($fields);
            $names = '';
            $values = '';
            foreach($fields as $row)
            {
                $name = $row['name'];
                $names .= $name;

                if($row['type'] == 'file') {
                    $values .= "'".$this->upload_file($name)."'";
                }
                else {
                    $values .= "'".$_POST[$name]."'";
                    if($row['type'] == 'image' AND $_POST[$name] != '') {
                        if(!file_exists('../photos/')) mkdir('../photos/', 0755);
                        copy('../temp/'.$_POST[$name], '../photos/'.$_POST[$name]);
                    }
                }
                if(--$count){
                    $names .= ', ';
                    $values .= ', ';
                }
            }
            $query = 'INSERT INTO '. $page .' ('. $names .') VALUES ('. $values .')';
            $tmp = $this -> dbh -> prepare($query);
            if($tmp -> execute()) return 'Запись успешно Добавлена!';
            else throw new Exception('Возникли проблемы при добавлении записи в базу!');
        }

        /**
         * @param $page string
         * @param $id int
         * @return string
         * @throws Exception
         */
        public function updateRow($page, $id) {
            if(count($_POST) <= 0) throw new Exception('POST - пуст!');
            $fields = $this->storage->get_table_fields($page);
            $count = count($fields);
            $names = '';
            foreach($fields as $row)
            {
                $name = $row['name'];
                if($row['type'] == 'file') {
                    $value = $this->upload_file($name);
                    if($value != '') {
                        $this->delete_file($page, $name, $id);
                    }
                    else {
                        $tmp = $this->dbh->prepare('SELECT '.$name.' FROM '.$page.' WHERE id = '.$id);
                        if(!$tmp -> execute()) {
                            throw new Exception('Ошибка при запросе к базе!');
                        }
                        $file = $tmp->fetch();
                        $value = $file[$name];
                    }
                }
                else {
                    $value = $_POST[$name];
                    if($row['type'] == 'image' AND $_POST[$name] != '') {
                        if(!file_exists('../photos/')) mkdir('../photos/', 0755);
                        copy('../temp/'.$_POST[$name], '../photos/'.$_POST[$name]);
                        $this->delete_file($page, $name, $id, '../photos/');
                    }
                }
                $names .= $name.' = "'.$value.'"';
                if(--$count){
                    $names .= ', ';
                }
            }
            $query = 'UPDATE '.$page.' SET '.$names.' WHERE id = '.$id;
            $tmp = $this -> dbh -> prepare($query);
            if($tmp -> execute()) return 'Запись успешно Изменена!';
            else throw new Exception('Возникли проблемы при изменении записи!');
        }

        /**
         * @param $page string
         * @param $id  int
         * @return bool
         * @throws Exception
         */
        public function delete_row($page, $id) {
            $fields = $this->storage->get_table_fields($page);
            foreach($fields as $row) {
                if($row['type'] == 'file') {
                    $this->delete_file($page, $row['name'], $id);
                }
                if($row['type'] == 'image') {
                    $this->delete_file($page, $row['name'], $id, '../photos/');
                }
            }
            $tmp = $this->dbh->prepare('DELETE FROM '.$page.' WHERE id = '.$id);
            if(!$tmp -> execute()) {
                throw new Exception('Ошибка при запросе к базе!');
            }
            return true;
        }

        /**
         * @param string $input_name
         * @param string $folder
         * @param string $ext_type
         * @return string
         * @throws Exception
         */
        public function upload_file($input_name, $folder = '../files/', $ext_type = 'docs') {
            if(is_uploaded_file($_FILES[$input_name]["tmp_name"]))
            {
                $name = $_FILES[$input_name]['name']; // имя файла
                preg_match("/.*\.([a-z0-7^.]+)/i", $name, $ext); // разбиваем на имя и формат
                $ext = $ext[1];
                $newName = time().".".$ext;
                $extensions = array(
                    'docs' => array("pdf", "doc", 'docx', 'xls', 'xlsx', 'rar', 'zip', '7z', 'txt'),
                    'images' => array('jpg', 'png', 'gif')
                );
                if(in_array($ext, $extensions[$ext_type])){
                    if(!file_exists($folder)) mkdir($folder, 0755);
                    move_uploaded_file($_FILES[$input_name]["tmp_name"], $folder.$newName);
                    return $newName;
                }
                else{
                    throw new Exception('Неверный формат файла');
                }
            }
            else {
                return '';
            }
        }

        /**
         * @param string $page
         * @param string $field
         * @param int $id
         * @param string $folder
         * @return bool
         * @throws Exception
         */
        public function delete_file($page, $field, $id, $folder = '../files/') {
            $tmp = $this->dbh->prepare('SELECT '.$field.' FROM '.$page.' WHERE id = '.$id);
            if(!$tmp -> execute()) {
                throw new Exception('Ошибка при запросе к базе!');
            }
            $file = $tmp->fetch();
            if(file_exists($folder.$file[$field]) AND $file[$field] != '') {
                if(!unlink($folder.$file[$field])) {
                    throw new Exception('Ошибка при удалении файла!');
                }
                return true;
            }
            return false;
        }
    }
