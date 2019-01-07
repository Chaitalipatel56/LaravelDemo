<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreCloumnToStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            
                $table->string("phoneno")->after('name') ;
                $table->text("address");
                $table->string('email');
                $table->integer('class_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students', function (Blueprint $table) {
            $table->dropColumn('phoneno');
            $table->dropColumn('address');
            $table->dropColumn('email');
            $table->dropColumn('class_id');
        });
    }
}
