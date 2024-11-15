<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('surat_masuk_id')->nullable();
            $table->string('pengirim');
            $table->string('penerima');
            $table->date('tanggal_kirim');
            $table->string('subject');
            $table->text('isi_surat');
            $table->string('status_surat');
            $table->string('lampiran')->nullable();
            $table->string('no_surat')->unique()->default('');
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('set null');
            $table->foreign('surat_masuk_id')->references('id')->on('surat_masuk')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_keluar');
    }
}
