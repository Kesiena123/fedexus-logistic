<?php
$pdo = new PDO('sqlite:' . dirname(__DIR__) . '/database/database.sqlite');
$stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type = 'index' AND name LIKE '%_idx'");
$indexes = $stmt->fetchAll(PDO::FETCH_COLUMN);
foreach ($indexes as $index) {
    if ($index !== 'guest_chat_conversations_chat_status_idx' && $index !== 'guest_chat_messages_delivery_status_idx' && $index !== 'guest_chat_conversations_chat_status_index') {
        $pdo->exec("DROP INDEX IF EXISTS \"{$index}\"");
        echo "Dropped index: {$index}\n";
    }
}
echo "Done\n";
