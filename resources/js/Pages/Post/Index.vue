<template>
	<Head>
		<title>{{ V_FormatTitle( "Posts" ) }}</title>
	</Head>
	<Common>
		<template v-slot:namespace_path>.Posts</template>

		<div class="relative">
			<Link v-if="canCreate"
				  :href="route( 'posts.create_post' )"
				  class="button bg-keyword absolute right-0 -top-11">Create Post</Link>

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
							<div class="author keyword">{{ post.author }}</div>
						</div>
					</div>
					</Link>
				</li>
			</ul>
		</div>
	</Common>
</template>

<script>
import { Link, Head } from "@inertiajs/vue3";

import Common from "@/Pages/Layout/Common.vue";

export default {
	props: {
		posts: {
			title: String,
			url_title: String,
			created_at: String,
			author: String,
		},
		canCreate: Boolean,
	},
	components: {
		Link,
		Head,
		Common
	}
}
</script>
