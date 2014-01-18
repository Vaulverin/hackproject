<?
    $form = $data['form'];
?>
<h2><?=$form['title']?></h2>
<form action="/admin/data/push/<?=$page;?>/<?=$form['id']?>" method="post" enctype="multipart/form-data">
    <?
        $this -> values =  $form['values'][0];
        foreach($form['params'] as $row)
        {
            $field = 'field_'. $row['type'];
            if(method_exists($this, $field))
            {
                if($row['name'] != 'id'){
                    ?>
                        <?=$row['alias']?> : <?$this->$field($row);?>
                        <br/>
                    <?
                }
            }
            else echo 'Error: Method "'. $field .'" not found.<br/>';
        }
    ?>
    <a class="button" id="save">Сохранить</a>
    <a href="/admin/main/show/<?=$page?>" class="button">Отмена</a>
</form>