<?php

$certs = file_get_contents('C:\\tools\\php85\\cacert.pem');
preg_match_all('/Subject: (.*?)\n/', $certs, $matches);
foreach ($matches[1] as $i => $m) {
    if ($i > 20) {
        break;
    }
    echo $m."\n";
}
