<?php

use Database\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['LESSON', 'COMMENT']);
            $table->string('title');
            $table->string('rule');
        });
        Schema::create('badge_rules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('rule');
            $table->integer('sequence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badge_rules');
        Schema::dropIfExists('achievements_rules');
    }
}
