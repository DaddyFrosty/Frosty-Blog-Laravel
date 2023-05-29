@extends("layouts.common")
@section("namespace_path")
@if ( isset( $post ) && $post != null )
{{ ".Posts." . str_replace( " ", "_", ucwords( str_replace( "_", " ", $post->url_title ) ) ) }}
@else
.404
@endif
@endsection

@section( "content" )

@if ( isset( $post ) && $post != null )
	<div class="post-view">
		<div class="header">
			<div class="title">{{ $post->title }}</div>
			<div>
				<span class="date">{{ $post->created_at }}</span>
				-
				<span class="author keyword">{{ $post->author }}</span>
			</div>
<!--			<button class="button bg-keyword mt-3">Edit</button>-->
			{{-- <%= link_to "Edit", { controller: "posts", action: "edit_article", id: @post.url_title }, class: "button bg-keyword mt-3" %> --}}
		</div>
		<div class="body">
			{!! BBCode::parse( $post->body ) !!}
		</div>
	</div>
@endif

@endsection