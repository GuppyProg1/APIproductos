<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginCodigoToUsuariosTabla extends Migration{

    public function up()
    {
       Schema::table('users', function (Blueprint $table) {

            // columna para guardar el código de verificación
            $table->string('login_code', 6)->nullable()->after('password');

        });

    }

    public function down(){
         Schema::table('users', function (Blueprint $table) {

            // eliminar la columna si se revierte la migración
            $table->dropColumn('login_code');

        });
    }
    
}
