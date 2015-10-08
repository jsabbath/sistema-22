<?php

if (isset($_GET["archivo"])) {
    $f = '..\\'.$_GET["archivo"];
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$f\"\n");
    $fp = fopen("$f", "r");
    fpassthru($fp);
}
