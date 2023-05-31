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

		<div class="w-full mt-auto">
			<a class="link" v-if="!user" :href="route( 'login.steam' )">
				Login
			</a>
			<div class="user row avatar-div" v-else>
				<div class="grow flex items-end">
					<a class="remove w-full" :href="route( 'logout' )">
						Logout
					</a>
				</div>
				<div class="avatar">
					<img :src="user.avatar_url" :alt="user.name + '\'s Avatar'" />
					<span class="name" :style="{ color: user.color }">
						{{ user.name }}
					</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
	props: {},
	computed: {
		user()
		{
			// {
			// 	uid: String,
			// 	name: String,
			// 	avatar_url: String,
			// 	color: String,
			// }
			let userData = this.$page.props.user;
			if ( !userData )
				return null;

			const c = userData.color_arr;
			if ( !c || c.length < 3 )
			{
				userData["color"] = "";
				return userData;
			}

			userData["color"] = `rgb( ${c[0]}, ${c[1]}, ${c[2]} )`;
			return userData;
		}
	},
	components: {
		Link
	},
}
</script>
