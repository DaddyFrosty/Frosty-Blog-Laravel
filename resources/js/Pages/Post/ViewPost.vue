<template>
	<Common>
		<template v-if="post == undefined" v-slot:namespace_path>.Posts.404</template>
		<template v-else v-slot:namespace_path>.Posts.{{ post_url }}</template>
		<div class="post-view" v-if="post">
			<div class="header">
				<div class="title">{{ post.title }}</div>
				<div>
					<span class="date">{{ post.created_at }}</span>
					-
					<span class="author keyword">{{ post.author }}</span>
				</div>
				<!--			<button class="button bg-keyword mt-3">Edit</button>-->
			</div>
			<div class="body" v-html="post.body"></div>
		</div>
	</Common>
</template>

<script>
import Common from "@/Pages/Layout/Common.vue";

export default {
	props: {
		post: Object,
		post_url: String
	},
	components: { Common }
}
</script>
