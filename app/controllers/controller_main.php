<?
class Controller_Main extends Controller
{
    protected $currentModel = 'Model_Main';
    /** @var $model Model_Main * */
    protected $model;

    public function action_index($page)
    {
        //$this -> model -> getInfo();

        $this->view->generate('main_view.php', $this->template, $page, $this->data);
    }
}
