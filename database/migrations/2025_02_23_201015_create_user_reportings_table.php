<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReportingsTable extends Migration
{
    public function up()
    {
        Schema::create('user_reportings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reporting_to_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('segment_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('model_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('vertical_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_reportings');
    }
}
