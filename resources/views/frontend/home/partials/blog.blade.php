@if(isset($blogs) && count($blogs) > 0)
    <section class="blog">
        <div class="container">
            <div class="row gx-0 justify-content-center">
                @foreach($blogs as $category => $blog)
                    @if($blog instanceof \App\Models\Backend\Blog\Post)
                <div class="col-lg-4 col-md-6 col-sm-9">
                    <div class="blog__post__item">
                        <div class="blog__post__thumb">
                            <a href="{{ route('frontend.posts.show', [$blog->id, $blog->slug]) }}">
                                <img
                                        src="{{ asset('theme/rasalina/img/blog/blog_post_thumb01.jpg') }}"
                                        alt=""></a>
                            <div class="blog__post__tags">
                                <a href="{{ route('frontend.posts.index', $blog->slug) }}">{{ $category }}</a>
                            </div>
                        </div>
                        <div class="blog__post__content">
                            <span class="date">{!! $blog->published_at->format('d F Y') !!}</span>
                            <h3 class="title">
                                <a href="{{ route('frontend.posts.show', [$blog->id, $blog->slug]) }}">
                                    {!! \App\Supports\Utility::textTruncate(($blog->title), 100) !!}
                                </a>
                            </h3>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('frontend.posts.show', [$blog->id, $blog->slug]) }}" class="read__more">Read mORe</a>
                            </div>
                        </div>
                    </div>
                </div>
                    @endif
                @endforeach
{{--                <div class="col-lg-4 col-md-6 col-sm-9">
                    <div class="blog__post__item">
                        <div class="blog__post__thumb">
                            <a href="blog-details.html"><img
                                        src="{{ asset('theme/rasalina/img/blog/blog_post_thumb02.jpg') }}"
                                        alt=""></a>
                            <div class="blog__post__tags">
                                <a href="blog.html">Social</a>
                            </div>
                        </div>
                        <div class="blog__post__content">
                            <span class="date">13 january 2021</span>
                            <h3 class="title"><a href="blog-details.html">Make communication Fast and
                                    Effectively.</a></h3>
                            <a href="blog-details.html" class="read__more">Read mORe</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-9">
                    <div class="blog__post__item">
                        <div class="blog__post__thumb">
                            <a href="blog-details.html"><img
                                        src="{{ asset('theme/rasalina/img/blog/blog_post_thumb03.jpg') }}"
                                        alt=""></a>
                            <div class="blog__post__tags">
                                <a href="blog.html">Work</a>
                            </div>
                        </div>
                        <div class="blog__post__content">
                            <span class="date">13 january 2021</span>
                            <h3 class="title"><a href="blog-details.html">How to increase your productivity at work
                                    - 2021</a></h3>
                            <a href="blog-details.html" class="read__more">Read mORe</a>
                        </div>
                    </div>
                </div>--}}
            </div>
            <div class="blog__button text-center">
                <a href="{{ route('frontend.posts.index') }}" class="btn">more blog</a>
            </div>
        </div>
    </section>
@endif