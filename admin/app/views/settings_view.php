<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 30.07.13;
 * Experience: 1.5 years.
 */
?>
<form>
    <p>
        Хранение данных
        <select>
            <?
            foreach($data['params'] as $param) {
                ?>
                <option<?if(config::get_storage_type() == $param) echo ' selected';?>><?=$param?></option>
                <?
            }
            ?>
        </select>
    </p>
</form>