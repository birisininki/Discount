<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_id')->constrained('request_types')->onDelete('cascade')->onUpdate('cascade');
            $table->smallInteger('status')->default(0);
            $table->decimal('amount')->nullable();
            $table->dateTime('handle_datetime')->nullable();
            $table->dateTime('process_datetime')->nullable();
            $table->string('message')->nullable();
            $table->string('promotion_code')->nullable();
            $table->timestamps();

            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
