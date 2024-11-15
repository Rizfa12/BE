<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratMasukTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pengirim');
            $table->string('penerima');
            $table->date('tanggal_terima');
            $table->string('subject');
            $table->text('isi_surat');
            $table->string('status_surat');
            $table->string('lampiran')->nullable();
            $table->string('no_surat')->unique();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_masuk');
    }
}
