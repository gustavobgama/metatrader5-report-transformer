<?php

use GustavoGama\MetatraderReportTransformer\Database\IlluminateSchemaMigration;
use Illuminate\Database\Schema\Blueprint;

class CreatePositionTable extends IlluminateSchemaMigration
{
    protected function up(): void
    {
        $this->schema->create('positions', function(Blueprint $table){
            $table->integer('id')->unique();
            $table->date('entry_time');
            $table->string('symbol', 10);
            $table->enum('type', ['buy', 'sell']);
            $table->smallInteger('volume');
            $table->decimal('entry_price', 10, 2);
            $table->decimal('stop_loss', 10, 2)->nullable();
            $table->decimal('take_profit', 10, 2)->nullable();
            $table->decimal('exit_price', 10, 2)->nullable();
            $table->decimal('commission', 10, 2);
            $table->decimal('profit', 10, 2);
        });
    }

    protected function down(): void
    {
        $this->schema->drop('positions');
    }
}
