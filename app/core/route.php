<?
	class Route
	{
		static function start()
		{
			// контроллер и действие по умолчанию
			$controller_name = 'Main';
			$action_name = 'index';
			$value = NULL;
			$id = NULL;

			$routes = explode('/', $_SERVER['REQUEST_URI']);

			// получаем имя контроллера
			if ( !empty($routes[2]) )
			{	
				$controller_name = $routes[2];
			}
			
			// получаем имя экшена
			if ( !empty($routes[3]) )
			{
				$action_name = $routes[3];
			}
			if ( !empty($routes[4]) )
			{
				$value = $routes[4];
			}
            if ( !empty($routes[5]) )
            {
                $id = $routes[5];
            }

			// добавляем префиксы
			$model_name = 'Model_'.$controller_name;
			$controller_name = 'Controller_'.$controller_name;
			$action_name = 'action_'.$action_name;

			// подцепляем файл с классом модели (файла модели может и не быть)

			$model_file = strtolower($model_name).'.php';
			$model_path = "app/models/".$model_file;
			if(file_exists($model_path))
			{
				include "app/models/".$model_file;
			}

			// подцепляем файл с классом контроллера
			$controller_file = strtolower($controller_name).'.php';
			$controller_path = "app/controllers/".$controller_file;
			if(file_exists($controller_path))
			{
				include "app/controllers/".$controller_file;
			}
			else
			{
				/*
				правильно было бы кинуть здесь исключение,
				но для упрощения сразу сделаем редирект на страницу 404
				*/
				Route::ErrorPage404();
			}
			
			// создаем контроллер
			$controller = new $controller_name;
			$action = $action_name;
			
			if(method_exists($controller, $action))
			{
				// вызываем действие контроллера
				$controller->$action($value, $id);
			}
			else
			{
				// здесь также разумнее было бы кинуть исключение
				Route::ErrorPage404();
			}
		
		}
		
		public function ErrorPage404()
		{
			$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
			header('HTTP/1.1 404 Not Found');
			header("Status: 404 Not Found");
			header('Location:'.$host.'404');
		}

    }
?>