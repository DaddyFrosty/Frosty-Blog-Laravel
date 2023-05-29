<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use BBCode\Facades\BBCode;

class BBCodeTagsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Adds the tags: keyword, type, string, namespace, name, var, scope, default
		BBCode::addTag(
			name:    'keyword',
			pattern: '/\[keyword\](.*?)\[\/keyword\]/s',
			replace: '<keyword>$1</keyword>',
			content: '$1'
		);
		
		BBCode::addTag(
			name:    'type',
			pattern: '/\[type\](.*?)\[\/type\]/s',
			replace: '<type>$1</type>',
			content: '$1'
		);

		BBCode::addTag(
			name:    'string',
			pattern: '/\[string\](.*?)\[\/string\]/s',
			replace: '<string>$1</string>',
			content: '$1'
		);

		BBCode::addTag(
			name:    'namespace',
			pattern: '/\[namespace\](.*?)\[\/namespace\]/s',
			replace: '<namespace>$1</namespace>',
			content: '$1'
		);

		BBCode::addTag(
			name:    'name',
			pattern: '/\[name\](.*?)\[\/name\]/s',
			replace: '<name>$1</name>',
			content: '$1'
		);

		BBCode::addTag(
			name:    'var',
			pattern: '/\[var\](.*?)\[\/var\]/s',
			replace: '<cvar>$1</cvar>',
			content: '$1'
		);

		BBCode::addTag(
			name:    'scope',
			pattern: '/\[scope\](.*?)\[\/scope\]/s',
			replace: '<scope>$1</scope>',
			content: '$1'
		);

		BBCode::addTag(
			name:    'default',
			pattern: '/\[default\](.*?)\[\/default\]/s',
			replace: '<default>$1</default>',
			content: '$1'
		);
    }
}
