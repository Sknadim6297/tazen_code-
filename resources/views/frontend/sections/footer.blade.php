<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <h3 data-bs-target="#collapse_1">Quick Links</h3>
                <div class="collapse dont-collapse-sm links" id="collapse_1">
                    <ul>
                        <li><a href="{{ route('professional.login') }}">Join Us</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ url('/contact') }}">Contacts</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ route('event.list') }}">Events</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- <h3 data-bs-target="#collapse_2">Categories</h3>
                <div class="collapse dont-collapse-sm links" id="collapse_2">
                    <ul>
                        <li><a href="grid-listing-1.html">Top Categories</a></li>
                        <li><a href="grid-listing-2.html">Best Rated</a></li>
                        <li><a href="grid-listing-3.html">Best Price</a></li>
                        <li><a href="grid-listing-1.html">Latest Submissions</a></li>
                    </ul>
                </div> -->
            </div>
            <div class="col-lg-3 offset-lg-3 col-md-6">
                <h3 data-bs-target="#collapse_4">Keep in touch</h3>
                <div class="collapse dont-collapse-sm" id="collapse_4">
                    <div id="newsletter">
                        <div id="message-newsletter"></div>
                        <form method="post" action="http://www.ansonika.com/prozim/assets/newsletter.php"
                            name="newsletter_form" id="newsletter_form">
                            <div class="form-group">
                                <input type="email" name="email_newsletter" id="email_newsletter"
                                    class="form-control" placeholder="Your email">
                                <button type="submit" id="submit-newsletter"><i
                                        class="arrow_carrot-right"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="follow_us">
                        <h5>Follow Us</h5>
                        <ul>
                            <li><a href="https://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="https://twitter.com" target="_blank"><i class="bi bi-twitter-x"></i></a></li>
                            <li><a href="https://www.instagram.com" target="_blank"><i class="bi bi-instagram"></i></a></li>
                            <li><a href="https://www.tiktok.com" target="_blank"><i class="bi bi-tiktok"></i></a></li>
                            <li><a href="https://wa.me/your_whatsapp_number" target="_blank"><i class="bi bi-whatsapp"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /row-->
        <hr>
        <div class="row add_bottom_25">
            <div class="col-lg-6">
                <ul class="footer-selector clearfix">
                    <li>
                        <div class="styled-select lang-selector">
                            <select>
                                <option value="English" selected>English</option>
                                <option value="French">French</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Russian">Russian</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="styled-select currency-selector">
                            <select>
                                <option value="INR" selected>INR</option>
                                <option value="Euro">Euro</option>
                            </select>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="col-lg-6">
                <ul class="additional_links">
                    <li><a href="#">Terms and conditions</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><span>© Tazen</span></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!--/footer-->

<div id="toTop"></div><!-- Back to top button -->

<div class="layer"></div><!-- Opacity Mask Menu Mobile -->