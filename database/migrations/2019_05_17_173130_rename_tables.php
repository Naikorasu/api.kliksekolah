<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('budgets_detail', function (Blueprint $table) {
          $table->rename('budget_details');
      });

      Schema::table('budget_realization', function (Blueprint $table) {
          $table->rename('budget_realizations');
      });

      Schema::table('budgets_account', function (Blueprint $table) {
          $table->rename('budget_accounts');
      });

      Schema::table('budget_relocation', function (Blueprint $table) {
          $table->rename('budget_relocations');
      });

      Schema::table('budget_relocation_revision', function (Blueprint $table) {
          $table->rename('budget_relocation_revisions');
      });

      Schema::table('fund_request', function (Blueprint $table) {
          $table->rename('fund_requests');
      });

      Schema::table('non_budget', function (Blueprint $table) {
          $table->rename('non_budgets');
      });

      Schema::table('users_relationship', function (Blueprint $table) {
          $table->rename('user_relationships');
      });

      Schema::table('user_group', function (Blueprint $table) {
          $table->rename('user_groups');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
