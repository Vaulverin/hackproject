<?php
    class Controller_Data extends Controller
    {
        protected $currentModel = 'Model_Data';
        /** @var $model Model_Data **/
        protected $model;

        public function action_push($page, $id = null) {
            try{
                $this -> data['title'] = 'Успех';
                if($id == null) $this -> data['text'] = $this->model->insertRow($page);
                else $this -> data['text'] = $this->model->updateRow($page, $id);
                $this->data['text'] .= '<script type="text/javascript">setTimeout(function() {location = "/admin/main/show/'.$page.'";}, 1000);</script>';
            }
            catch(Exception $error)
            {
                $this -> data['title'] = 'Ошибка';
                $this -> data['text'] =  $error -> getMessage();
            }
            $this -> view -> generate('message_view.php', $this -> template, 'main', $this -> data);
        }

        public function action_delete($page, $id) {
            try{
                $this -> data['text'] = $this->model->delete_row($page, $id);
                $this->data['text'] .= '<script type="text/javascript">setTimeout(function() {location = "/admin/main/show/'.$page.'";}, 1000);</script>';
            }
            catch(Exception $error)
            {
                $this -> data['text'] =  $error -> getMessage();
            }
            return $this->data['text'];
        }

        public function action_upload_image($field_name) {
            try{
                $this -> data['text'] = $this->model->upload_file($field_name, '../temp/', 'images');
                if($this -> data['text'] == '') throw new Exception('Ошибка при отправке файла!');
            }
            catch(Exception $error)
            {
                $this -> data['text'] =  $error -> getMessage();
            }
            echo $this->data['text'];
        }
    }
