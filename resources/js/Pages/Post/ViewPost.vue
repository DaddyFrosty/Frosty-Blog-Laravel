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
						  class="button bg-keyword mt-3 mr-1">Edit</Link>

					<button class="button bg-danger mt-3" v-if="post.canDelete" data-toggle="modal" data-target="#delete-modal">
						Delete
					</button>
			</div>
			<div class="body" v-html="post.body"></div>
		</div>
	</Common>
	<ConfirmModal
		id="delete-modal"
		title="Confirm Deletion"
		:body='"Are you sure you want to delete \"" + post.title + "\"?"'
		:options="['Cancel', 'Delete' ]"
		:autoclose="true"
		:onSubmit="deletePost"
	/>
</template>

<script>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";

import Common from "@/Pages/Layout/Common.vue";
import { Namespaceify } from "@/utility";
import ConfirmModal from "@/Components/ConfirmModal.vue";

export default {
	props: {
		post: {
			title: String,
			created_at: String,
			author: String,
			namespace: String,
			canEdit: Boolean,
			canDelete: Boolean,
		},
	},
	components: {
		ConfirmModal,
		Head,
		Link,
		Common
	},
	methods: {
		Namespaceify,
		deletePost() {
			if ( this.isDeleting )
				return;

			const delPath = route( 'posts.delete_post', { 'PostId': this.$props.post.url_title } );
			router.delete( delPath );
			this.isDeleting = true;
		}
	},
	data() {
		return {
			isDeleting: false,
		}
	},
}
</script>
