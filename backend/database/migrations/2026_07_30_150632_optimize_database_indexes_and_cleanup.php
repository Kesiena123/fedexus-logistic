<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $indexDefs = [
        'email_logs' => [
            ['email_logs_sender_id_idx', ['sender_id']],
            ['email_logs_recipient_user_id_idx', ['recipient_user_id']],
        ],
        'notification_preferences' => [
            ['notification_preferences_user_id_idx', ['user_id']],
        ],
        'payment_audit_logs' => [
            ['payment_audit_logs_admin_user_id_idx', ['admin_user_id']],
        ],
        'payment_proofs' => [
            ['payment_proofs_payment_request_id_idx', ['payment_request_id']],
            ['payment_proofs_payment_transaction_id_idx', ['payment_transaction_id']],
            ['payment_proofs_verified_by_idx', ['verified_by']],
        ],
        'payment_requests' => [
            ['payment_requests_shipment_id_idx', ['shipment_id']],
            ['payment_requests_created_by_idx', ['created_by']],
            ['payment_requests_verified_by_idx', ['verified_by']],
        ],
        'payment_transactions' => [
            ['payment_transactions_payment_request_id_idx', ['payment_request_id']],
        ],
        'payments' => [
            ['payments_verified_by_idx', ['verified_by']],
            ['payments_shipment_id_stage_idx', ['shipment_id', 'stage']],
        ],
        'shipment_attachments' => [
            ['shipment_attachments_uploaded_by_idx', ['uploaded_by']],
        ],
        'shipments' => [
            ['shipments_driver_id_idx', ['driver_id']],
            ['shipments_warehouse_id_idx', ['warehouse_id']],
        ],
        'tracking_events' => [
            ['tracking_events_shipment_id_idx', ['shipment_id']],
            ['tracking_events_created_by_idx', ['created_by']],
        ],
    ];

    public function up(): void
    {
        foreach ($this->indexDefs as $table => $indexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            foreach ($indexes as [$name, $columns]) {
                try {
                    DB::statement('ALTER TABLE `' . $table . '` ADD INDEX `' . $name . '` (`' . implode('`, `', $columns) . '`)');
                } catch (\Exception $e) {
                    // index may already exist
                }
            }
        }
    }

    public function down(): void
    {
        foreach ($this->indexDefs as $table => $indexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            foreach ($indexes as [$name, $columns]) {
                try {
                    DB::statement('ALTER TABLE `' . $table . '` DROP INDEX `' . $name . '`');
                } catch (\Exception $e) {
                    //
                }
            }
        }
    }
};
