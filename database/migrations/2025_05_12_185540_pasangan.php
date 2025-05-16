<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pasangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->integer('urutan_anak')->nullable();
            $table->enum('status_kehidupan', ['Hidup', 'Wafat']);
            $table->date('tanggal_kematian')->nullable();
            $table->unsignedBigInteger('anggota_keluarga_id');
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('anggota_keluarga_id')
                ->references('id')
                ->on('anggota_keluarga')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasangan');
    }
};
