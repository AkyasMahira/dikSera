<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyMembersTable extends Migration
{
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('relationship')->nullable(); // suami/istri/anak/orang tua dll
            $table->integer('age')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_members');
    }
}
