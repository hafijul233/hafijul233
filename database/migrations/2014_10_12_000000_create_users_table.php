<?php


use App\Supports\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('password');
            $table->boolean('force_pass_reset')->default(false);
            $table->string('remarks')->nullable();
            $table->string('locale', 10)->default(config('app.locale', Constant::LOCALE));
            $table->string('home_page')->default(Constant::DASHBOARD_ROUTE)->nullable();
            $table->enum('enabled', array_keys(Constant::ENABLED_OPTIONS))
                ->default(Constant::ENABLED_OPTION)->nullable();
            $table->rememberToken();
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
