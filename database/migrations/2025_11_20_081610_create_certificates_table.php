<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            // relasi ke users
            $table->unsignedBigInteger('user_id')->nullable()->index();

            // jenis sertifikat: wajib / pengembangan
            $table->string('type', 30)->nullable();

            // data sertifikat
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            // tanggal aktif & habis masa berlaku
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();

            // path file (pdf / gambar)
            $table->string('file_path')->nullable();

            $table->timestamps();

            // optional: FK
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}
