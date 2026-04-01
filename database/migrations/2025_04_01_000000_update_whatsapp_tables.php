<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new columns to whatsapp_settings
        Schema::table('whatsapp_settings', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('device_id');
            $table->text('api_token')->nullable()->after('provider');
            $table->string('sender_number')->nullable()->after('api_token');
            $table->json('reminder_settings')->nullable()->after('sender_number');
            $table->string('auto_send_time')->nullable()->default('09:00')->after('reminder_settings');
        });

        // Create whatsapp_templates table
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag')->default('info');
            $table->text('content');
            $table->string('icon')->nullable()->default('bell');
            $table->string('icon_color')->nullable()->default('#3b82f6');
            $table->string('tag_color')->nullable()->default('bg-blue-500/20 text-blue-400');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('whatsapp_settings', function (Blueprint $table) {
            $table->dropColumn(['provider', 'api_token', 'sender_number', 'reminder_settings', 'auto_send_time']);
        });

        Schema::dropIfExists('whatsapp_templates');
    }
};
