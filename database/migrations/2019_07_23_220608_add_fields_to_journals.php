<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToJournals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journals', function (Blueprint $table) {
            if(!Schema::hasColumn('journals','accepted_by')) {
              $table->string('accepted_by',255)->default('');
            }
            if(!Schema::hasColumn('journals','submitted_by')) {
              $table->string('submitted_by', 255)->default('');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn('accepted_by', 'submitted_by');
        });
    }
}
