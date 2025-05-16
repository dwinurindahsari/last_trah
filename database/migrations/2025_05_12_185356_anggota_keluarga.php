<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->integer('urutan');
            $table->enum('status_kehidupan', ['Hidup', 'Wafat']);
            $table->date('tanggal_kematian')->nullable();
            $table->string('alamat')->nullable();
            $table->unsignedBigInteger('tree_id'); // Relasi ke trah
            $table->unsignedBigInteger('parent_id')->nullable(); // Relasi hierarchical
            $table->string('photo')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tree_id')
                ->references('id')
                ->on('trah') // Diubah dari 'family_trees' ke 'trah'
                ->onDelete('cascade');

            $table->foreign('parent_id')
                ->references('id')
                ->on('anggota_keluarga') // Diubah dari 'family_members' ke 'anggota_keluarga'
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};
