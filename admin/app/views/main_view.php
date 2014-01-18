<a href="/admin/action/add/<?=$page?>" class="button">Добавить</a>
<a class="button" id="del">Удалить</a>
<div id="contForTable">
    <table id="main_table" >
        <?
            $mainTable = $data['mainTable'];
        ?>
        <thead>
            <tr>
                <td>#</td>
                <?
                    foreach($mainTable['headNames'] as $name)
                    {
                        ?>
                            <td><?=$name?></td>
                        <?
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?
                $count = count( $mainTable['fields']);
                foreach($mainTable['content'] as $row)
                {
                    ?>
                        <tr><td class="sysCol"><input class="check" type="checkbox" value="<?=$row['id']?>"/></td>
                    <?
                    foreach($mainTable['fields'] as $fields)
                    {
                        if($fields['type'] == "checkBox"){
                            if($row[$fields['field']] == "on") echo "<td>Да</td>";
                            else echo "<td>Нет</td>";
                        }
                        else{
                            ?>
                                <td><a href="/admin/action/edit/<?=$page?>/<?=$row['id']?>" title="Изменить"><?=$row[$fields['field']]?></a></td>
                            <?
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</div>