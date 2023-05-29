@include( "layouts.header" )
<body>
	<div class="navigation">
		@include( "layouts.navigation.sidebar" )
	</div>

	<div class="content">
		<div class="content-inner">
			<h4 class="namespace namespace-path">
				<span class="keyword">namespace </span>
				{{ env( "APP_NAME" ) . rtrim( $__env->yieldContent( "namespace_path" ) ) }}<span class="default">;</span>
			</h4>
			@yield( "content" )
		</div>
	</div>
</body>
</html>
