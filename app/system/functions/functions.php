<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 05.07.13;
 * Experience: 1.5 years.
 */
function getData($query, $params = array())
{
    global $dbh;
    $data = array();
    $tmp = $dbh->prepare($query);
    $tmp->execute($params);
    while ($row = $tmp->fetch()) {
        $data [] = $row;
    }
    return $data;
}