@extends("layouts.common")
@section("namespace_path", ".Posts")

@section("content")

@if ( !isset( $posts ) || $posts == null || $posts->count() == 0 )
	<h3>
		No posts found.
	</h3>
@else
	<ul class="no-pad posts">
		@foreach ( $posts as $post )
			<li class="post">
				<a href="{{ route( "posts.view_post", [ "PostId" => $post->url_title ] ) }}">
					<div class="row">
						<div class="first">
							<div class="title">{{ $post->title }}</div>
							<div class="date">{{ $post->created_at }}</div>
						</div>
						<div class="second">
							<div class="author keyword">{{ $post->author }}</div>
						</div>
					</div>
				</a>
			</li>
		@endforeach
	</ul>
@endif

@endsection
