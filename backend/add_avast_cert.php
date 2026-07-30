<?php

use System\Security\Cryptography\X509Certificates\OpenFlags;
use System\Security\Cryptography\X509Certificates\X509Store;

// Extract Avast CA certificate from Windows store and add to cacert.pem
$store = new X509Store('Root', 'CurrentUser');
$store->Open(OpenFlags::ReadOnly);
$avastCerts = [];
foreach ($store->Certificates as $cert) {
    if (stripos($cert->Subject, 'avast') !== false || stripos($cert->Issuer, 'avast') !== false) {
        $avastCerts[] = $cert;
    }
}
$store->Close();
echo 'Found '.count($avastCerts)." Avast certificates\n";
foreach ($avastCerts as $cert) {
    echo 'Subject: '.$cert->Subject."\n";
    echo 'Issuer: '.$cert->Issuer."\n";
}
