<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
			$table->string( "name", 32 )->unique();
			$table->string( "color", 16 )->default( '[]' );
			$table->boolean( "default" )->default( false );
			$table->integer( "order" )->default( 0 );
			$table->longText( "permissions" )->default( '{}' );
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
        Schema::dropIfExists('permissions');
    }
};
