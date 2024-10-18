<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_keys', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('domain')->unique();
            $table->string('purchase_code');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_used')->default(false);
            // Advanced fields
            $table->enum('status', ['active', 'expired', 'revoked', 'pending'])->default('active');
            $table->string('activation_code')->unique()->nullable();
            $table->string('used_by_ip')->nullable();
            $table->string('used_on_device')->nullable();
            $table->unsignedInteger('activation_count')->default(0);
            $table->boolean('is_revoked')->default(false);
            $table->timestamp('revoked_at')->nullable();
            $table->unsignedBigInteger('revoked_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->text('notes')->nullable();
            $table->json('item_details')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('revoked_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_keys');
    }
}
