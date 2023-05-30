<template>
	<Common>
		<template v-slot:namespace_path>.Posts</template>
		<h3 v-if="posts == undefined || posts.length === 0">
			No posts found.
		</h3>
		<ul v-else class="no-pad posts">
			<li class="post" v-for="post in posts">
				<Link :href="route( 'posts.view_post', { 'PostId': post.url_title } )">
				<div class="col">
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
	</Common>
</template>

<script>
import { Link } from "@inertiajs/vue3";

import Common from "@/Pages/Layout/Common.vue";

export default {
	props: {
		posts: Object
	},
	components: {
		Link,
		Common
	}
}
</script>
