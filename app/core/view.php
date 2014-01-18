<?
class View
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.
    public $values = null;

    function generate($content_view, $template_view, $page, $data = null)
    {
        /*if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }*/
        include 'app/views/' . $template_view;
    }


    protected function field_varchar($params)
    {
        ?>
    <input class="inpt" maxlength="250" type="text" name="<?=$params['name']?>"
           value="<?if ($this->values != null) echo $this->values[$params['name']]; ?>"/>
    <?
        return $this;
    }

    protected function field_text($params)
    {
        ?>
    <script>
        bkLib.onDomLoaded(function () {
            new nicEditor({fullPanel:true}).panelInstance('<?=$params['name']?>');
        });
    </script>
    <br/>
    <div class="editor info-main">
        <textarea id="<?=$params['name']?>" class="txt"
                  name="<?=$params['name']?>"><?if ($this->values != null) echo $this->values[$params['name']]; ?></textarea>
    </div>
    <?
        return $this;
    }

    protected function field_image($params)
    {
        ?>
    <div id="pht_<?=$params['name']?>" class="phts" onclick="uploadImage('_<?=$params['name']?>');">Загрузить</div>
    <span id="status_<?=$params['name']?>" class="status"></span>
    <div id="files_<?=$params['name']?>" class="snglPht">
        <?if ($this->values != null): ?>
        <img class="preview" onclick="delete_image(this);" src="/photos/<?=$this->values[$params['name']]?>"
             id="_<?=$params['name']?>"/>
        <? endif;?>
    </div>
    <input id="post_<?=$params['name']?>" type="hidden" name="<?=$params['name']?>"
           value="<?=$this->values[$params['name']]?>"/>
    <?
        return $this;
    }

    protected function field__date($params)
    {
        $date = date("Y-m-d");
        if ($this->values != null) $date = $this->values[$params['name']];
        ?>
    <input readonly="readonly" id="datepicker" type="text" name="<?=$params['name']?>" value="<?=$date?>"/>
    <?
        return $this;
    }

    protected function field_f_key($params)
    {
        ?>
    <select name="<?=$params['name']?>">
        <?
        foreach ($params['defaultParams'] as $row) {
            ?>
            <option value="<?=$row['id']?>" <?if ($this->values != null && $row['id'] == $this->values[$params['name']]) echo 'selected'; ?>><?=$row['name']?></option>
            <?
        }
        ?>
    </select>
    <?
        return $this;
    }

    protected function field_file($params)
    {
        ?>
    <br/><input type="file" name="<?=$params['name']?>"/>
    <?
        if ($this->values[$params['name']] != null AND file_exists('../files/' . $this->values[$params['name']])) {
            ?>
        Текущий файл: <a href="/files/<?=$this->values[$params['name']]?>"
                         target="_blank"><?=$this->values[$params['name']]?></a>
        <?
        }
        return $this;
    }

    protected function field_checkBox($params)
    {
        ?>
    <input type="checkbox" name="<?=$params['name']?>"
           value="<?if ($this->values != null) echo $this->values[$params['name']]; ?>"/>
    <?
        return $this;
    }

    protected function field__time($params)
    {
        $time = date('H:i', strtotime("+2 hours"));
        if ($this->values != null) $time = $this->values[$params['name']];
        ?>
    <input type="time" name="<?=$params['name']?>" value="<?=$time?>"/>
    <?
        return $this;
    }

}