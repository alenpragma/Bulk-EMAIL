<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('smtps', function (Blueprint $table) {
            $table->id();
            $table->string('from_name');
            $table->string('emails');
            $table->string('email_pass');
            $table->string('host_name');
            $table->integer('imap_port');
            $table->integer('campaign');
            $table->integer('limit');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('smtps');
    }
}
