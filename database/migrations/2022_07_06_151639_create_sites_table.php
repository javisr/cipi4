<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->uuid('site');
            $table->string('user')->unique();
            $table->string('domain')->unique();
            $table->string('path')->nullable();
            $table->string('php')->defualt('8.1');
            $table->string('repo')->nullable();
            $table->string('branch')->nullable();
            $table->text('env')->nullable();
            $table->text('auth')->nullable();
            $table->text('deploy')->nullable();
            $table->text('nginx')->nullable();
            $table->text('supervisord')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
};
