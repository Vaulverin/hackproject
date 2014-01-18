<?
class Controller_Main extends Controller
{
    protected $currentModel = 'Model_Main';
    /** @var $model Model_Main * */
    protected $model;

    public function action_show($page)
    {
        //$this -> model -> getInfo();
        $this->data['mainTable'] = $this->model->getMainTable($page);
        $this->data['headers'] = $this->model->headers;
        $this->view->generate('main_view.php', $this->template, $page, $this->data);
    }
}
