<template>
	<div class="navigation">
		<Sidebar />
	</div>

	<div class="content">
		<div class="content-inner">
			<h4 class="namespace namespace-path">
				<span class="keyword">namespace </span>
				{{ $page.props.app.name }}<slot name="namespace_path"></slot><span class="default">;</span>
			</h4>
			<slot></slot>
		</div>
	</div>
</template>

<script>
import Sidebar from "@/Pages/Layout/Navigation/Sidebar.vue";

export default {
	components: { Sidebar }

}
</script>
