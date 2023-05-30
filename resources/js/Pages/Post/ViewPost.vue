<template>
	<Head>
		<title>{{ V_FormatTitle( post?.title ?? "404" ) }}</title>
	</Head>
	<Common>
		<template v-if="post == undefined" v-slot:namespace_path>.Posts.404</template>
		<template v-else v-slot:namespace_path>.Posts.{{ Namespaceify( post.url_title ) }}</template>
		<div class="post-view" v-if="post">
			<div class="header">
				<div class="title">{{ post.title }}</div>
				<div>
					<span class="date">{{ post.created_at }}</span>
					-
					<span class="author keyword">{{ post.author }}</span>
				</div>
					<Link v-if="post.canEdit"
						  :href="route( 'posts.edit_post', { 'PostId': post.url_title } )"
						  class="button bg-keyword mt-3">Edit</Link>
			</div>
			<div class="body" v-html="post.body"></div>
		</div>
	</Common>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";

import Common from "@/Pages/Layout/Common.vue";
import { Namespaceify } from "@/utility";

export default {
	props: {
		post: {
			title: String,
			created_at: String,
			author: String,
			namespace: String,
			canEdit: Boolean,
		},
	},
	methods: {
		Namespaceify
	},
	components: {
		Head,
		Link,
		Common
	}
}
</script>
