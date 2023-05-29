@extends("layouts.common")
@section("namespace_path", "")

@section("content")

<p class="scope">
	Hey I'm <span class="type">{{ env( "APP_NAME" ) }}</span> I do a lot of development in
	<span class="keyword">C#</span>, <span class="keyword">C++</span>, and many other <span class="keyword">languages</span>.
</p>
<p class="scope">
	This is <span class="name">my personal blog</span> where I post what I'm working on
	<span class="keyword">and</span> the progress on the games / projects I got <span class="keyword">in</span> the works.
</p>

@endsection