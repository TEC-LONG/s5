﻿{include file="main/head.tpl"}
    <body>
      
        <!--  loader  -->
        <div id="myloader">
            <div class="loader">
                <div class="grid">
                    <div class="cube cube1"></div>
                    <div class="cube cube2"></div>
                    <div class="cube cube3"></div>
                    <div class="cube cube4"></div>
                    <div class="cube cube5"></div>
                    <div class="cube cube6"></div>
                    <div class="cube cube7"></div>
                    <div class="cube cube8"></div>
                    <div class="cube cube9"></div>
                </div>
            </div>
        </div>
        
        <!--  Header & Menu  -->
        {include file="main/menu.tpl"}
        <!--  END Header & Menu  -->
            
        <!--  Main Wrap  -->
        <div id="main-wrap">
            <!--  Page Content  -->
            <div id="page-content" class="header-static">
                <!--  Slider  -->
                <div id="flexslider-nav" class="fullpage-wrap small">
                    <ul class="slides">
                        <li style="background-image:url({$smarty.const.URL}/public/home/main/img/slider.jpg)">
                            <div class="text center">
                                <h1 class="heading center white margin-bottom-small flex-animation">The simple way to <br>create a beautiful website</h1>
                                <p class="heading white center margin-bottom flex-animation">Bussible template is here. Ease to use. Download now!</p>
                                <div class="padding-onlytop-md flex-animation">
                                    <a href="" class="btn-alt small shadow margin-xs-bottom-small">Download Now</a>
                                    <a href="" class="btn-alt small shadow">Read More</a>
                                </div>
                            </div>
                            <div class="gradient dark"></div>
                        </li>
                        <li style="background-image:url({$smarty.const.URL}/public/home/main/img/slider3.jpg)">
                            <div class="text center">
                                <h1 class="heading center white margin-bottom-small flex-animation no-opacity">Grow your business</h1>
                                <p class="heading white center margin-bottom flex-animation no-opacity">The best Corporate HTML Template. Download now!</p>
                                <div class="padding-onlytop-md flex-animation no-opacity">
                                    <a href="" class="btn-alt small shadow margin-xs-bottom-small">Download Now</a>
                                </div>
                            </div>
                            <div class="gradient dark"></div>
                        </li>
                    </ul>
                    <div class="slider-navigation">
                        <a href="#" class="flex-prev"><i class="material-icons">keyboard_arrow_left</i></a>
                        <div class="slider-controls-container"></div>
                        <a href="#" class="flex-next"><i class="material-icons">keyboard_arrow_right</i></a>
                    </div>
                    <div id="godown">
                        <a href="#home-wrap" class="btn-down">
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                </div>
                <!--  END Slider  -->
                <div id="home-wrap" class="content-section fullpage-wrap">
                    <!-- Abous us -->
                    <div class="container">
                        <!-- Section Image -->
                        <div class="row no-margin padding-onlytop-lg">
                            <div class="col-md-6 padding-leftright-null">
                                <div data-responsive="parent-height" data-responsive-id="about" class="text">
                                    <h2 class="margin-bottom-null left">About Us</h2>
                                    <div class="padding-onlytop-sm">
                                        <p class="margin-bottom grey">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis</p>
                                        <a href="#" class="btn-pro">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 padding-leftright-null">
                                <div data-responsive="child-height" data-responsive-id="about" class="section-image height-auto-sm">
                                   <picture class="section right">
                                       <img src="{$smarty.const.URL}/public/home/main/img/tablet.png"  class="img-responsive" alt="">
                                   </picture>
                               </div>
                            </div>
                        </div>
                        <!-- END Section Image -->
                    </div>
                    <!-- Services -->
                    <div class="light-background"> 
                        <div class="container padding-lg">
                            <div class="row no-margin">
                                <div class="col-md-12 padding-leftright-null text-center">
                                    <h2 class="margin-bottom-small left">Our Services</h2>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-md-6 padding-leftright-null">
                                        <div class="text padding-md-bottom-null">
                                            <i class="material-icons color service left">business</i>
                                            <div class="service-content large">
                                                <h3 class="margin-bottom-extrasmall">Business Goals</h3>
                                                <p class="margin-bottom-null">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem harum aspernatur sapiente error, voluptas fuga, laudantium ullam magni fugit. Qui!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 padding-leftright-null">
                                        <div class="text padding-md-bottom-null">
                                            <i class="material-icons color service left">people</i>
                                            <div class="service-content large">
                                                <h3 class="margin-bottom-extrasmall">Professional Team</h3>
                                                <p class="margin-bottom-null">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem harum aspernatur sapiente error, voluptas fuga, laudantium ullam magni fugit. Qui!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-md-6 padding-leftright-null">
                                        <div class="text padding-md-bottom-null">
                                            <i class="material-icons color service left">lightbulb_outline</i>
                                            <div class="service-content large">
                                                <h3 class="margin-bottom-extrasmall">Vision</h3>
                                                <p class="margin-bottom-null">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem harum aspernatur sapiente error, voluptas fuga, laudantium ullam magni fugit. Qui!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 padding-leftright-null">
                                        <div class="text padding-md-bottom-null">
                                            <i class="material-icons color service left">headset_mic</i>
                                            <div class="service-content large">
                                                <h3 class="margin-bottom-extrasmall">Support 24/24</h3>
                                                <p class="margin-bottom-null">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem harum aspernatur sapiente error, voluptas fuga, laudantium ullam magni fugit. Qui!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Services -->
                        </div>
                    </div>
                    <!-- END Services -->
                    <!-- Video Section -->
                    <div class="container">
                        <div class="row no-margin padding-lg">
                            <div class="col-md-7 padding-leftright-null">
                                <div data-responsive="child-height" data-responsive-id="video" class="text padding-md-top-null height-auto-md">
                                    <!-- Video Popup -->
                                    <a class="popup-vimeo" href="">
                                        <img src="{$smarty.const.URL}/public/home/main/img/video-business.jpg" alt="">
                                    </a>
                                    <!-- END Video Popup -->
                                </div>
                            </div>
                            <div class="col-md-5 padding-leftright-null">
                                <div data-responsive="parent-height" data-responsive-id="video" class="text padding-md-top-null padding-md-bottom-null">
                                    <h2 class="margin-bottom-null left">Benefict of working<br> 
                                        with us.</h2>
                                    <div class="padding-onlytop-sm">
                                        <p class="margin-bottom">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                        <ul class="styled">
                                            <li>Lorem ipsum dolor sit amet </li>
                                            <li>Lorem ipsum dolor sit amet
                                            </li>
                                            <li>Lorem ipsum dolor sit amet
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Video Section -->
                    <!--  Section Image Background with overlay  -->
                    <div class="row margin-leftright-null grey-background">
                        <div class="bg-img overlay responsive" style="background-image:url({$smarty.const.URL}/public/home/main/img/quote-business.jpg)">
                            <div class="container padding-sm">
                                <div class="row no-margin">
                                    <div class="text">
                                        <h3 class="big white margin-bottom-small">We provide the best services for any business</h3>
                                        <a href="#" class="btn-pro white">Contact us now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  END Section Image Background with overlay  -->
                    <!--  Section Testimonials  -->
                    <div class="container">
                        <div class="row no-margin padding-lg">
                            <div class="col-md-12 padding-leftright-null text-center">
                                <h3 class="big margin-bottom-small">Our Customer Say</h3>
                            </div>
                            <!-- Testimonials -->
                            <section class="testimonials-carousel-simple col-md-12 padding-leftright-null padding-bottom-null">
                                <div class="item padding-leftright-null">
                                    <div class="text padding-bottom-null">
                                        <div class="person">
                                            <img src="{$smarty.const.URL}/public/home/main/img/quote-girl.jpg" alt="">
                                            <div class="description">
                                                <em>Anna Brown</em>
                                                <span class="margin-null"> CEO at Index.com</span>
                                            </div>
                                        </div>
                                        <blockquote class="margin-bottom-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur voluptatum fugiat molestias, veritatis perspiciatis laborum modi beatae placeat explicabo at laudantium aliquam, nam vero ut!</blockquote>
                                    </div>
                                </div>
                                <div class="item padding-leftright-null">
                                    <div class="text padding-bottom-null">
                                        <div class="person">
                                            <img src="{$smarty.const.URL}/public/home/main/img/quote-man.jpg" alt="">
                                            <div class="description">
                                                <em>John Doe</em>
                                                <span class="margin-null">CMO at Company.com</span>
                                            </div>
                                        </div>
                                        <blockquote class="margin-bottom-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur voluptatum fugiat molestias, veritatis perspiciatis laborum modi beatae placeat explicabo at laudantium aliquam, nam vero ut!</blockquote>
                                    </div>
                                </div>
                                <div class="item padding-leftright-null">
                                    <div class="text padding-bottom-null">
                                        <div class="person">
                                            <img src="{$smarty.const.URL}/public/home/main/img/quote-girl-two.jpg" alt="">
                                            <div class="description">
                                                <em>Susan Tril</em>
                                                <span class="margin-null">Designer at Pink.com</span>
                                            </div>
                                        </div>
                                        <blockquote class="margin-bottom-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur voluptatum fugiat molestias, veritatis perspiciatis laborum modi beatae placeat explicabo at laudantium aliquam, nam vero ut!</blockquote>
                                    </div>
                                </div>
                            </section>
                            <!-- END Testimonials -->
                        </div>
                    </div>
                    <!-- END Section Testimonials  -->
                    <!-- Section News -->
                    <div class="light-background">
                        <div class="container">
                            <div class="row no-margin padding-onlytop-lg">
                                <div class="col-md-12 padding-leftright-null text-center">
                                    <h3 class="big margin-bottom-small">Our News</h3>
                                </div>
                                <div class="col-md-12 text" id="news">
                                    <!-- Single News -->
                                    <div class="col-sm-4 single-news">
                                        <article>
                                            <img src="{$smarty.const.URL}/public/home/main/img/news1.jpg" alt="">
                                            <div class="content">
                                                <h3>Meetup In Rome</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita, voluptas corporis. Maxime sapiente, adipisci laborum.</p>
                                                <span class="date">02 November 2017</span>
                                            </div>
                                            <a href="#" class="link"></a>
                                        </article>
                                    </div>
                                    <!-- END Single News -->
                                    <div class="col-sm-4 single-news">
                                        <article>
                                            <img src="{$smarty.const.URL}/public/home/main/img/news2.jpg" alt="">
                                            <div class="content">
                                                <h3>Brand Power</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita, voluptas corporis. Maxime sapiente, adipisci laborum.</p>
                                                <span class="date">12 May 2017</span>
                                            </div>
                                            <a href="#" class="link"></a>
                                        </article>
                                    </div>
                                    <div class="col-sm-4 single-news">
                                        <article>
                                            <img src="{$smarty.const.URL}/public/home/main/img/news4.jpg" alt="">
                                            <div class="content">
                                                <h3>Vision</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita, voluptas corporis. Maxime sapiente, adipisci laborum.</p>
                                                <span class="date">13 March 2017</span>
                                            </div>
                                            <a href="#" class="link"></a>
                                        </article>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-margin">
                                <div class="col-md-12 padding-leftright-null">
                                   <div class="text padding-onlytop-md padding-onlybottom-lg padding-md-top-null">
                                       <a href="#" class="btn-pro">See all your news</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Section News -->
                    <!-- Section Partners -->
                    <div class="container">
                        <div class="row no-margin">
                            <div class="col-md-12 padding-leftright-null">
                                <div class="partners">
                                    <div class="col-xs-6 col-sm-4 col-md-2 text padding-leftright-null">
                                        <h3>Our Trusted<br>Partners</h3>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-2 partner">
                                        <img class="img-responsive" src="{$smarty.const.URL}/public/home/main/img/logo-square-2-dark.png" alt="">
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-2 partner">
                                        <img class="img-responsive" src="{$smarty.const.URL}/public/home/main/img/logo-square-3-dark.png" alt="">
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-2 partner">
                                        <img class="img-responsive" src="{$smarty.const.URL}/public/home/main/img/logo-square-4-dark.png" alt="">
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-2 partner">
                                        <img class="img-responsive" src="{$smarty.const.URL}/public/home/main/img/logo-square-5-dark.png" alt="">
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-2 partner">
                                        <img class="img-responsive" src="{$smarty.const.URL}/public/home/main/img/logo-square-6-dark.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Section Partners -->
                </div>
            </div>
            <!--  END Page Content -->
        </div>
        <!--  Main Wrap  -->
        

        <!--  Footer  -->
        {include file="main/footer.tpl"}