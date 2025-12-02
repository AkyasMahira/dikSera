<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerawatProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('perawat_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 1)->nullable(); // L / P
            $table->string('religion')->nullable();
            $table->string('phone')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('address')->nullable();
            $table->text('office_address')->nullable();
            $table->string('nip')->nullable();
            $table->string('current_position')->nullable();
            $table->string('work_unit')->nullable();

            $table->string('last_education')->nullable();
            $table->string('education_institution')->nullable();

            $table->string('profile_photo')->nullable(); // foto 3x4

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perawat_profiles');
    }
}
