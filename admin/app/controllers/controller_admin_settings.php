<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 31.07.13;
 * Experience: 1.5 years.
 */
class controller_admin_settings extends Controller
{
    protected $currentModel = 'Model_Admin_Settings';
    /** @var $model Model_Main * */
    protected $model;

    public function action_index()
    {
        $this->data['params'] = $this->model->get_admin_settings();
        $this->data['headers'] = $this->model->headers;
        $this->view->generate('settings_view.php', $this->template, $page, $this->data);
    }
}
