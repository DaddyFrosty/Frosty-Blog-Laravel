<template>
	<Common>
		<p class="scope">
			Hey I'm <span class="type">{{ $page.props.app.name }}</span> I do a lot of development in
			<span class="keyword">C#</span>, <span class="keyword">C++</span>, and many other <span class="keyword">languages</span>.
		</p>
		<p class="scope">
			This is <span class="name">my personal blog</span> where I post what I'm working on
			<span class="keyword">and</span> the progress on the games / projects I got <span class="keyword">in</span> the works.
		</p>
	</Common>
</template>

<script>
import Common from "@/Pages/Layout/Common.vue";

export default {
	components: {
		Common
	}
}
</script>
