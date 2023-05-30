<template>
	<div class="sidebar">
		<a class="solution" href="#frosty-content" data-toggle="collapse" aria-expanded="true">
			Frosty
		</a>
		<ul id="frosty-content" class="solution-top collapsable show" data-remember="sidebar-solution">
			<li>
				<Link :href="route('index')" class="file" :class="{ 'active': $page.component === 'Index' }">
				Index
				</Link>
			</li>
			<li>
				<Link :href="route( 'posts.index' )" class="folder" :class="{ 'active': $page.component === 'Post/Index' }">
				Posts
				</Link>
				<ul id="posts-content">
					<li v-for="post in $page.props.posts_sidebar">
						<Link :href="route( 'posts.view_post', { 'PostId': post.url_title } )"
						class="file"
						:class="{ 'active':
							$page.component === 'Post/ViewPost' && route( 'posts.view_post', { 'PostId': post.url_title } ).indexOf( $page.url ) !== -1 }">
							{{ post.title }}
						</Link>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
	props: {
	},
	components: {
		Link
	},
}
</script>
