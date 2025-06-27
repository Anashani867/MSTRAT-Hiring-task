<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->timestamp('server_datetime')->nullable();
        $table->timestamp('datetime_utc')->nullable();
        $table->timestamp('update_datetime_utc')->nullable();
        $table->timestamp('last_login_datetime_utc')->nullable();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone');
        $table->enum('status', ['Active', 'Inactive', 'Deleted', 'Expired'])->default('Active');
        $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('photo')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
