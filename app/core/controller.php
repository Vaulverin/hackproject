<?
	class Controller {
		
		/** @var $model Model() **/
        protected $model;
        protected $view;
        protected $data;
        protected  $currentModel = 'Model';
        protected $template = 'template_view.php';
        protected $storage;

		function __construct()
		{
            $this -> model = new $this -> currentModel();
            $this->view = new View();
            $this->storage = fStorage::get_storage();
            $this -> data['menu'] = $this->storage->get_menu();
        }
		
		function action_index()
		{
            $this -> view -> generate('cap.php', $this -> template, 'main', $this -> data);
		}
		
		protected function checkId($id)
        {
            $id = (int)$id;
            if($id == 0) return 1;
            return $id;
        }
	}