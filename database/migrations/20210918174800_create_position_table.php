<?php

use GustavoGama\MetatraderReportTransformer\Database\IlluminateSchemaMigration;
use Illuminate\Database\Schema\Blueprint;

class CreatePositionTable extends IlluminateSchemaMigration
{
    protected function up(): void
    {
        $this->schema->create('positions', function(Blueprint $table){
            $table->integer('id')->unique();
            $table->date('date');
            $table->string('symbol', 10);
            $table->enum('type', ['buy', 'sell']);
            $table->smallInteger('volume');
            $table->decimal('points', 10, 2);
            $table->decimal('commission', 10, 2);
            $table->boolean('is_gain');
            $table->decimal('profit', 10, 2);
            $table->decimal('balance', 10, 2);
        });
    }

    protected function down(): void
    {
        $this->schema->drop('positions');
    }
}
