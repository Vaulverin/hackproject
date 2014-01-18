<?php
    class Controller_Action extends Controller
    {
        protected  $currentModel = 'Model_Action';
        /** @var $model Model_Action **/
        protected $model;

        public function action_add($page){
            $this -> data['form'] = $this -> model -> getAddForm($page);
            $this->generate_view($page);
        }

        public function action_edit($page, $id){
            $this -> data['form'] = $this -> model -> getEditForm($page, $id);
            $this->generate_view($page);
        }

        private function generate_view($page) {
            $this -> data['headers'] = $this -> model -> headers;
            $this -> view -> generate('action_template_view.php', $this->template, $page,  $this -> data);
        }
    }