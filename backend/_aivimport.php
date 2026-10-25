<?php
$host='mysql-2043b851-biagodstimei-80c3.f.aivencloud.com';
$port=26301; $db='defaultdb'; $user='avnadmin'; $pass='AVNS_h2COs6kXPZlVgxjmNcn';
$ca='C:/Users/PAPAMNESTY/Desktop/fedex logistic/Fed/FedExUs/backend/storage/certs/aiven-ca.pem';
$file='C:/Users/PAPAMNESTY/Desktop/fedex logistic/Fed/FedExUs/backend/database/logistics_db_infinityfree.sql';
$dsn="mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
$pdo=new PDO($dsn,$user,$pass,[PDO::MYSQL_ATTR_SSL_CA=>$ca,PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=>true]);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql=file_get_contents($file);
$parts=preg_split('/;\r?\n/', $sql);
$ok=0;$errs=0;
foreach($parts as $p){
  $p=trim($p);
  if($p===''||str_starts_with($p,'--')) continue;
  try{ $pdo->exec($p); $ok++; }
  catch(Throwable $e){ $errs++; echo "ERR: ".$e->getMessage()." | ".substr($p,0,90)."\n"; }
}
echo "executed=$ok errors=$errs\n";
foreach($pdo->query("SELECT table_name t, table_rows r FROM information_schema.tables WHERE table_schema='defaultdb' ORDER BY table_name") as $row){ echo "  {$row['t']} rows={$row['r']}\n"; }
