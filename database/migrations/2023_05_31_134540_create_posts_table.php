<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
			$table->string( "title" );
			$table->string( "url_title" );

			$table->string( "author_uid", 36 )->nullable();
			$table->foreign( "author_uid" )->references( "uid" )->on( "users" )->nullOnDelete();
// ALTER TABLE `posts`
//	ADD CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_uid`) REFERENCES `users` (`uid`) ON UPDATE NO ACTION ON DELETE NO ACTION;

//  alter table `posts`
// add constraint `posts_author_uid_foreign` foreign key (`author_uid`) references `users` (`uid`) on delete set null

			$table->text( "body" );
			$table->enum( "visible", [ "hidden", "restricted", "visible" ] )->default( "visible" );
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
        Schema::dropIfExists('posts');
    }
};
