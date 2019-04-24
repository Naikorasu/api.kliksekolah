<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDescriptionToBudgetRelocationSourcesAndBudgetRelocationRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation_sources', function (Blueprint $table) {
            $table->text('description')->nullable();
        });

        Schema::table('budget_relocation_recipients', function (Blueprint $table) {
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_relocation_sources', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('budget_relocation_recipients', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
