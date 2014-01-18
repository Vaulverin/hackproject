<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Панель Управления</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf8" />
        <link href="/admin/css/admin.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" href="/admin/css/smoothness/jquery-ui-1.8.23.custom.css" rel="stylesheet">
        <script type="text/javascript" src="/admin/js/jquery-1.8.1.min.js"></script>
        <?=$data['headers']?>
        <script type="text/javascript">
            var page = '<?=$page?>';
        </script>
    </head>
    <body>
        <div id="menu">
            <a href="/admin/main/exit" id="ext" class="button">ВЫХОД</a>
            <a href="/admin/admin_settings" class="button <? if('admin_settings' == $page) echo "selected"; ?>">Настройки Панели</a>
            <?
                foreach( $data['menu'] as $row )
                {
                    ?>
                    <a href="/admin/main/show/<?=$row['name']?>" class="button <? if($row['name'] == $page) echo "selected"; ?>"><?=$row['alias']?></a>
                    <?
                }
            ?>
        </div>
        <div id="content">

            <?php include 'app/views/'.$content_view; ?>

        </div>
    </body>
</html>