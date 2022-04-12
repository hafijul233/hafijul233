<?php

use App\Supports\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateEnumeratorsTable extends Migration
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
        Schema::create('enumerators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->nullable()->index()->constrained('surveys');
            $table->string('name');
            $table->string('name_bd')->nullable();
            $table->string('father');
            $table->string('father_bd')->nullable();
            $table->string('mother');
            $table->string('mother_bd')->nullable();
            $table->string('nid')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->unsignedInteger('exam_level')->nullable();
            $table->string('present_address')->nullable();
            $table->string('present_address_bd')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('permanent_address_bd')->nullable();
            $table->foreignId('gender_id')->nullable()->index()->constrained('catalogs');
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
        Schema::dropIfExists('enumerators');

        //Temporary Disable Foreign Key Constraints
        Schema::enableForeignKeyConstraints();
    }
}
