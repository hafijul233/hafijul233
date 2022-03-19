<?php

use App\Supports\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateEducationQualificationsTable extends Migration
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
        Schema::create('education_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enumerator_id')->index()->constrained('enumerators');
            $table->foreignId('exam_level_id')->index()->constrained('exam_levels');
            $table->foreignId('exam_title_id')->index()->constrained('exam_titles');
            $table->foreignId('exam_board_id')->nullable()->index()->constrained('catalogs');
            $table->foreignId('institute_id')->nullable()->index()->constrained('institutes');
            $table->foreignId('exam_group_id')->index()->constrained('exam_groups');
            $table->year('pass_year')->nullable();
            $table->string('roll_number')->nullable();
            $table->unsignedInteger('grade_type');
            $table->string('grade_point')->nullable();
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
        Schema::dropIfExists('education_qualifications');

        //Temporary Disable Foreign Key Constraints
        Schema::enableForeignKeyConstraints();
    }
}
