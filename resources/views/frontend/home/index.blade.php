@extends('theme.rasalina.home')

@section('title', 'Home')

@push('meta')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('page-style')

@endpush

@section('content')
        <!-- banner-area -->
        <section class="banner">
            <div class="container custom-container">
                <div class="row align-items-center justify-content-center justify-content-lg-between">
                    <div class="col-lg-6 order-0 order-lg-2">
                        <div class="banner__img text-center text-xxl-end">
                            <img src="{{ asset('theme/rasalina/img/banner/banner_img.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="banner__content">
                            <h2 class="title wow fadeInUp" data-wow-delay=".2s"><span>I will give you Best</span> <br>
                                Product in the shortest time.</h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">I'm a Rasalina based product design & visual
                                designer focused on crafting clean & user‑friendly experiences</p>
                            <a href="about.html" class="btn banner__btn wow fadeInUp" data-wow-delay=".6s">more about me</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="scroll__down">
                <a href="#aboutSection" class="scroll__link">Scroll down</a>
            </div>
            <div class="banner__video">
                <a href="https://www.youtube.com/watch?v=XHOmBV4js_E" class="popup-video"><i
                            class="fas fa-play"></i></a>
            </div>
            <nav class="switcher__tab">
                <span class="switcher__tab__btn light__mode__title">Light</span>
                <span class="mode__switcher"></span>
                <span class="switcher__tab__btn dark__mode__title">Dark</span>
            </nav>
        </section>
        <!-- banner-area-end -->

        <!-- about-area -->
        @include('frontend.home.partials.about')
        <!-- about-area-end -->

        <!-- services-area -->
        @include('frontend.home.partials.service')
        <!-- services-area-end -->

        {{--<!-- work-process-area -->
        <section class="work__process">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section__title text-center">
                            <span class="sub-title">03 - Working Process</span>
                            <h2 class="title">A clear product design process is the basis of success</h2>
                        </div>
                    </div>
                </div>
                <div class="row work__process__wrap">
                    <div class="col">
                        <div class="work__process__item">
                            <span class="work__process_step">Step - 01</span>
                            <div class="work__process__icon">
                                <img class="light" src="{{ asset('theme/rasalina/img/icons/wp_light_icon01.png') }}"
                                     alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/wp_icon01.png') }}" alt="">
                            </div>
                            <div class="work__process__content">
                                <h4 class="title">Discover</h4>
                                <p>Initial ideas or inspiration & Establishment of user needs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="work__process__item">
                            <span class="work__process_step">Step - 02</span>
                            <div class="work__process__icon">
                                <img class="light" src="{{ asset('theme/rasalina/img/icons/wp_light_icon02.png') }}"
                                     alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/wp_icon02.png') }}" alt="">
                            </div>
                            <div class="work__process__content">
                                <h4 class="title">Define</h4>
                                <p>Interpretation & Alignment of findings to project objectives.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="work__process__item">
                            <span class="work__process_step">Step - 03</span>
                            <div class="work__process__icon">
                                <img class="light" src="{{ asset('theme/rasalina/img/icons/wp_light_icon03.png') }}"
                                     alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/wp_icon03.png') }}" alt="">
                            </div>
                            <div class="work__process__content">
                                <h4 class="title">Develop</h4>
                                <p>Design-Led concept and Proposals hearted & assessed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="work__process__item">
                            <span class="work__process_step">Step - 04</span>
                            <div class="work__process__icon">
                                <img class="light" src="{{ asset('theme/rasalina/img/icons/wp_light_icon04.png') }}"
                                     alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/wp_icon04.png') }}" alt="">
                            </div>
                            <div class="work__process__content">
                                <h4 class="title">Deliver</h4>
                                <p>Process outcomes finalised & Implemented</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- work-process-area-end -->--}}

        <!-- portfolio-area -->
        @include('frontend.home.partials.portfolio')
        <!-- portfolio-area-end -->

        <!-- partner-area -->
        @include('frontend.home.partials.client')
        <!-- partner-area-end -->

        <!-- testimonial-area -->
        @include('frontend.home.partials.testimonial')
        <!-- testimonial-area-end -->

        <!-- blog-area -->
        @include('frontend.home.partials.blog')
        <!-- blog-area-end -->
@endsection

@push('plugin-script')

@endpush

@push('page-script')

@endpush