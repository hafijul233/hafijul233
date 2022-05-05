<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Supports\Constant;


class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Temporary Disable Foreign Key Constraints
        Schema::disableForeignKeyConstraints();

        //Table Structure
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->json('stack_holder')->nullable();
            $table->string('associate')->nullable();
            $table->string('url')->nullable();
            $table->longText('description')->nullable();
            $table->enum('enabled', array_keys(Constant::ENABLED_OPTIONS))
                  ->default(Constant::ENABLED_OPTION)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        //Temporary Disable Foreign Key Constraints
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Temporary Disable Foreign Key Constraints
        Schema::disableForeignKeyConstraints();

        //Remove Table Structure
        Schema::dropIfExists('projects');

        //Temporary Disable Foreign Key Constraints
        Schema::enableForeignKeyConstraints();
    }
}
