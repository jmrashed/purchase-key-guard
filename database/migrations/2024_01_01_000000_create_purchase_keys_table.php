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
            $table->id(); // Auto-incrementing ID
            $table->string('key')->unique(); // Unique purchase key
            $table->unsignedBigInteger('user_id')->nullable(); // User ID (optional)
            $table->string('type'); // Type of key (e.g., single, multi)
            $table->timestamp('created_at')->useCurrent(); // Timestamp when the key was created
            $table->timestamp('expires_at')->nullable(); // Expiration timestamp
            $table->boolean('is_used')->default(false); // Track if the key has been used
            $table->timestamps(); // created_at and updated_at
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
