<?php

use App\Models\AdminAuditLog;

$log = AdminAuditLog::where('action', 'shipment.approved')->latest()->first();
if ($log) {
    echo 'Previous keys: '.implode(', ', array_keys($log->previous_values ?? []))."\n";
    echo 'New keys: '.implode(', ', array_keys($log->new_values ?? []))."\n";
} else {
    echo "No shipment.approved audit logs found\n";
}
