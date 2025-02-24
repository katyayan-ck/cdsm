<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKey extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('designation_id')
                ->references('id')
                ->on('designations')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('vertical_id')
                ->references('id')
                ->on('verticals')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('segment_id')
                ->references('id')
                ->on('segments')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('model_id')
                ->references('id')
                ->on('models')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('variant_id')
                ->references('id')
                ->on('variants')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['designation_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['segment_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['model_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['vertical_id']);
        });
    }
}
