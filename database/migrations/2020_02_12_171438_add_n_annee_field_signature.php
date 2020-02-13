<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNAnneeFieldSignature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('signatures', function (Blueprint $table) {
            $table->integer('nAnnee')->after('nSemaine');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('signatures', function (Blueprint $table) {
            $table->dropColumn('nAnnee');
        });
    }
}
