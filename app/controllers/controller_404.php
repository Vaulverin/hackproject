<?
	class Controller_404 extends Controller
	{
		function action_index()
		{	
			$this -> data['title'] = 'Ошибка 404';
            $this -> data['text'] = 'Страница не найдена!';
            $this -> view -> generate('message_view.php', $this -> template, 'main', $this -> data);
		}
	}
?>