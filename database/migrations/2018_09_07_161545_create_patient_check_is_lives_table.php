<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientCheckIsLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_check_is_lives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ASMENS_KODAS',11)->default(0);
            $table->string('VARDAS',500)->default(0);
            $table->string('PAVARDE',500)->default(0);
            $table->string('GIMIMODATA',500)->default(0);
            $table->string('MIRTIESDATA',500)->default(0);
            $table->string('SVEIDROSADRESAS',500)->default(0);
            $table->string('KULSISTEMOSADRESAS',500)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_check_is_lives');
    }
}
