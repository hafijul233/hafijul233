@if(isset($services) && count($services) > 0)
    <section class="services">
        <div class="container">
            <div class="services__title__wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="section__title">
                            <span class="sub-title">02 - my Services</span>
                            <h2 class="title">Creates amazing digital experiences</h2>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-4">
                        <div class="services__arrow"></div>
                    </div>
                </div>
            </div>
            <div class="row gx-0 services__active">
                @foreach($services as $service)
                    @if($service instanceof \App\Models\Backend\Portfolio\Service)
                        <div class="col-xl-3">
                            <div class="services__item">
                                <div class="services__thumb">
                                    <a href="{{ route('frontend.services.show', [$service->id, $service->slug]) }}">
                                        <img src="{{ asset('theme/rasalina/img/images/services_img01.jpg') }}"
                                                alt=""></a>
                                </div>
                                <div class="services__content">
                                    <div class="services__icon">
                                        <img class="light"
                                             src="{{ asset('theme/rasalina/img/icons/services_light_icon01.png') }}"
                                             alt="">
                                        <img class="dark"
                                             src="{{ asset('theme/rasalina/img/icons/services_icon01.png') }}"
                                             alt="">
                                    </div>
                                    <h3 class="title text-truncate" title="{!! $service->name !!}">
                                        <a href="{{ route('frontend.services.show', [$service->id, $service->slug]) }}">
                                            {{ $service->id }}. {!! $service->name !!}
                                        </a>
                                    </h3>
                                    <div>
                                        {!! \App\Supports\Utility::textTruncate($service->summary, 100) !!}
                                    </div>
{{--                                    <p>Strategy is a forward-looking plan for your brand’s behavior. Strategy is a
                                        forward-looking plan.</p>
                                    <ul class="services__list">
                                        <li>Research & Data</li>
                                        <li>Branding & Positioning</li>
                                        <li>Business Consulting</li>
                                        <li>Go To Market</li>
                                    </ul>--}}
                                    <div class="d-flex justify-content-center mt-5">
                                        <a href="{{ route('frontend.services.show', [$service->id, $service->slug]) }}" class="btn border-btn">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

{{--                <div class="col-xl-3">
                    <div class="services__item">
                        <div class="services__thumb">
                            <a href="services-details.html"><img
                                        src="{{ asset('theme/rasalina/img/images/services_img02.jpg') }}"
                                        alt=""></a>
                        </div>
                        <div class="services__content">
                            <div class="services__icon">
                                <img class="light"
                                     src="{{ asset('theme/rasalina/img/icons/services_light_icon02.png') }}" alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/services_icon02.png') }}"
                                     alt="">
                            </div>
                            <h3 class="title"><a href="services-details.html">Brand Strategy</a></h3>
                            <p>Strategy is a forward-looking plan for your brand’s behavior. Strategy is a
                                forward-looking plan.</p>
                            <ul class="services__list">
                                <li>User Research & Testing</li>
                                <li>UX Design</li>
                                <li>Visual Design</li>
                                <li>Information Architecture</li>
                            </ul>
                            <a href="services-details.html" class="btn border-btn">Read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="services__item">
                        <div class="services__thumb">
                            <a href="services-details.html"><img
                                        src="{{ asset('theme/rasalina/img/images/services_img03.jpg') }}"
                                        alt=""></a>
                        </div>
                        <div class="services__content">
                            <div class="services__icon">
                                <img class="light"
                                     src="{{ asset('theme/rasalina/img/icons/services_light_icon03.png') }}" alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/services_icon03.png') }}"
                                     alt="">
                            </div>
                            <h3 class="title"><a href="services-details.html">Product Design</a></h3>
                            <p>Strategy is a forward-looking plan for your brand’s behavior. Strategy is a
                                forward-looking plan.</p>
                            <ul class="services__list">
                                <li>User Research & Testing</li>
                                <li>UX Design</li>
                                <li>Visual Design</li>
                                <li>Information Architecture</li>
                            </ul>
                            <a href="services-details.html" class="btn border-btn">Read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="services__item">
                        <div class="services__thumb">
                            <a href="services-details.html"><img
                                        src="{{ asset('theme/rasalina/img/images/services_img04.jpg') }}"
                                        alt=""></a>
                        </div>
                        <div class="services__content">
                            <div class="services__icon">
                                <img class="light"
                                     src="{{ asset('theme/rasalina/img/icons/services_light_icon04.png') }}" alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/services_icon04.png') }}"
                                     alt="">
                            </div>
                            <h3 class="title"><a href="services-details.html">Visual Design</a></h3>
                            <p>Strategy is a forward-looking plan for your brand’s behavior. Strategy is a
                                forward-looking plan.</p>
                            <ul class="services__list">
                                <li>User Research & Testing</li>
                                <li>UX Design</li>
                                <li>Visual Design</li>
                                <li>Information Architecture</li>
                            </ul>
                            <a href="services-details.html" class="btn border-btn">Read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="services__item">
                        <div class="services__thumb">
                            <a href="services-details.html"><img
                                        src="{{ asset('theme/rasalina/img/images/services_img03.jpg') }}"
                                        alt=""></a>
                        </div>
                        <div class="services__content">
                            <div class="services__icon">
                                <img class="light"
                                     src="{{ asset('theme/rasalina/img/icons/services_light_icon02.png') }}" alt="">
                                <img class="dark" src="{{ asset('theme/rasalina/img/icons/services_icon02.png') }}"
                                     alt="">
                            </div>
                            <h3 class="title"><a href="services-details.html">Web Development</a></h3>
                            <p>Strategy is a forward-looking plan for your brand’s behavior. Strategy is a
                                forward-looking plan.</p>
                            <ul class="services__list">
                                <li>User Research & Testing</li>
                                <li>UX Design</li>
                                <li>Visual Design</li>
                                <li>Information Architecture</li>
                            </ul>
                            <a href="services-details.html" class="btn border-btn">Read more</a>
                        </div>
                    </div>
                </div>--}}
            </div>
        </div>
    </section>
@endif