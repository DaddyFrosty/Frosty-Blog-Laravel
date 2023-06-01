<template>
	<Head>
		<title>{{ V_FormatTitle( "Edit Post" ) }}</title>
	</Head>
	<Common>
		<template v-if="post == undefined" v-slot:namespace_path>.Posts.404</template>
		<template v-else v-slot:namespace_path>.Posts.{{ Namespaceify( post.url_title ) }}</template>

		<form
			class="post-view"
			@submit.prevent="postForm.post( isEdit ? route( 'posts.submit_edit_post', { 'PostId': post.url_title } ) : route( 'posts.submit_create_post' ) )"
		>
			<ErrorMessage :errors="$props.errors" />
			<div class="header" :class="{ 'error': $props.errors }">
				<div class="row">
					<div class="grow">
						<input type="text" v-model="postForm.title" name="title"/>
						<div class="mt-2" v-if="isEdit">
							<span class="date">{{ post.created_at }}</span>
<!--							- -->
<!--							<span class="author keyword">{{ post.author }}</span>-->
						</div>

						<button type="submit" class="button bg-keyword mt-3" v-if="isEdit" :disabled="postForm.processing">
							Save
						</button>
						<button type="submit" class="button bg-success mt-3" v-else :disabled="postForm.processing">
							Post
						</button>
					</div>

					<div class="author keyword" v-if="isEdit">
						<img :src="post.author.avatar_url" :alt="post.author.name + '\'s Avatar'" />
						{{ post.author.name }}
					</div>
				</div>
			</div>
			<div class="body">
				<textarea v-model="postForm.body" name="body"></textarea>
			</div>
		</form>
	</Common>
</template>

<script>
import { Head, useForm } from "@inertiajs/vue3";

import Common from "@/Pages/Layout/Common.vue";
import ErrorMessage from "@/Components/ErrorMessage.vue";

import { Namespaceify } from "@/utility";

export default {
	props: {
		current_post_state: {
			title: String,
			created_at: String,
			author: {
				name: String,
				avatar_url: String,
			},
			namespace: String,
		},

		isEdit: Boolean, // edit / create.
		errors: Array,
	},
	methods: {
		Namespaceify
	},
	components: {
		Head,
		Common,
		ErrorMessage,
	},
	setup( props ) {
		const post = props.current_post_state;
		const postForm = useForm( {
			title: props.isEdit ? post.title : "",
			body: props.isEdit ? post.body : "",
		} );

		return { postForm, post };
	},
}
</script>
