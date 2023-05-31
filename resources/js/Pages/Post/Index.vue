<template>
	<Head>
		<title>{{ V_FormatTitle( "Posts" ) }}</title>
	</Head>
	<Common>
		<template v-slot:namespace_path>.Posts</template>

		<div class="relative">
			<div v-if="canCreate || canClearCache" class="absolute right-0 -top-11">
				<Link v-if="canCreate"
					  :href="route( 'posts.create_post' )"
					  class="button bg-keyword">Create Post</Link>

				<form class="inline-block" v-if="canClearCache"
					  @submit.prevent="clearCacheForm.delete( route( 'posts.clear_cache' ) )">
					<button type="submit" class="button bg-warning ml-1" :disabled="clearCacheForm.processing">Clear Cache</button>
				</form>
			</div>

			<h3 v-if="posts == undefined || posts.length === 0">
				No posts found.
			</h3>
			<ul v-else class="no-pad posts">
				<li class="post" v-for="post in posts">
					<Link :href="route( 'posts.view_post', { 'PostId': post.url_title } )">
					<div class="row">
						<div class="first">
							<div class="title">{{ post.title }}</div>
							<div class="date">{{ post.created_at }}</div>
						</div>
						<div class="second">
							<div class="author keyword">
								<img :src="post.author.avatar_url" :alt="post.author.name + '\'s Avatar'" />
								{{ post.author.name }}
							</div>
						</div>
					</div>
					</Link>
				</li>
			</ul>
		</div>
	</Common>
</template>

<script>
import { Link, Head, useForm } from "@inertiajs/vue3";

import Common from "@/Pages/Layout/Common.vue";

export default {
	props: {
		posts: {
			title: String,
			url_title: String,
			created_at: String,
			author: {
				name: String,
				avatar_url: String,
			},
		},
		canCreate: Boolean,
		canClearCache: Boolean,
	},
	components: {
		Link,
		Head,
		Common
	},
	setup( props )
	{
		const clearCacheForm = useForm( {
			_method: "delete",
		} );

		return {
			clearCacheForm,
		};
	}
}
</script>
