<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( "users", function ( Blueprint $table ) {
            $table->id();
			$table->string( "uid", 36 )->unique();
			$table->string( "name", 32 );
			$table->string( "steam_name", 32 )->nullable();
			$table->string( "avatar", 255 );
			$table->foreignIdFor( Permission::class )->nullable()->constrained( 'permissions' )->nullOnDelete();
			$table->bigInteger('steamid64')->unique();
			$table->rememberToken();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( "users" );
    }
};
