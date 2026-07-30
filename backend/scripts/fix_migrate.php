<?php
$pdo = new PDO('sqlite:' . dirname(__DIR__) . '/database/database.sqlite');
$pdo->exec("DELETE FROM migrations WHERE migration LIKE '%2026_07_30_000002%'");
$pdo->exec("DELETE FROM migrations WHERE migration LIKE '%optimize_database%'");
echo "Deleted stale migration records\n";
