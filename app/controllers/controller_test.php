<?
class Controller_Test extends Controller
{
    protected $currentModel = 'Model_Test';
    /** @var $model Model_Test * */
    protected $model;

    public function action_index()
    {
        //$this -> model -> getInfo();
        $this->model->show_test_data();
        //$this->view->generate('test_view.php', $this->template, $page, $this->data);
    }
}
