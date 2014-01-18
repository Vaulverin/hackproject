<?
class Controller_Test extends Controller
{
    /** @var $currentModel Model_Test */
    protected $currentModel = 'Model_Test';
    /** @var $model Model_Main * */
    protected $model;

    public function action_show($page)
    {
        //$this -> model -> getInfo();
        $this->currentModel->show_test_data();
        //$this->view->generate('test_view.php', $this->template, $page, $this->data);
    }
}
