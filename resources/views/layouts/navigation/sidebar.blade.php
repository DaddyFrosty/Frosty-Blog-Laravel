<div class="sidebar">
	<a class="solution" href="#frosty-content" data-toggle="collapse" aria-expanded="true">
		Frosty
	</a>
	<ul id="frosty-content" class="solution-top collapsable show" data-remember="sidebar-solution">
		<li>
			<a href="{{ route( "index" ) }}" class="file {{ (request()->is( "/" )) ? "active" : "" }}">
				Index
			</a>
		</li>
		<li>
			<a href="{{ route( "posts.index" ) }}" class="folder {{ (request()->is( "posts" )) ? "active" : "" }}">
				Posts
			</a>
			<ul id="posts-content">
				@foreach ( $posts as $post )
					<li>
						<a	href="{{ route( "posts.view_post", [ "PostId" => $post["url_title"] ] ) }}"
							class="file {{ (request()->is( "posts/" . $post["url_title"] )) ? "active" : "" }}">
{{--							@if ( mb_strlen( $post->title ) > $sidebar_maxlen )--}}
{{--								{{ mb_substr( $post->title, 0, $sidebar_maxlen ) }}...--}}
{{--							@else--}}
{{--								{{ $post->title }}--}}
{{--							@endif--}}
							{{ $post["title"] }}
						</a>
					</li>
				@endforeach
			</ul>
		</li>
	</ul>
</div>
