<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/rew.php"))
    include_once $_SERVER['DOCUMENT_ROOT'] . "/rew.php";
foreach ($seo as $val) {
    if (preg_match($val[0], $_SERVER["REDIRECT_URL"], $mats)) {
        $_SERVER['PHP_SELF'] = $val[1];
        array_shift($mats);
        foreach ($mats as $v) {
            $_GET['seo'][] = $v;
        }
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $val[1]))
            continue;
        include_once $_SERVER['DOCUMENT_ROOT'] . $val[1];
        exit;
    }
}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/404.php'))
    header("Location: /404.php");
?>