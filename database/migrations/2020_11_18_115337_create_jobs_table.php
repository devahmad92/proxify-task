<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id()->comment('Stores an incrementing identifier for the job');
            $table->string('url')->comment('Stores a common URL');
            $table->enum('status', ['NEW', 'PROCESSING', 'DONE', 'ERROR'])->default('NEW')->comment('Stores URL status');
            $table->smallInteger('http_code')->nullable()->comment('Stores the resulting HTTP code from the request');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
