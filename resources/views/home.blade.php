<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sortiz</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/png" href="{{ url('/public') }}/assets/images/logo-sortiz.png" />

        <!-- Bootstrap 5.3.3 CSS -->
        <link href="{{ url('/public') }}/assets/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Google Fonts -->
        <link  href="{{ url('/public') }}/assets/css/css2.css" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

        <!-- Custom CSS -->
        <link rel="stylesheet"  href="{{ url('/public') }}/assets/css/style.css" />
        <link rel="stylesheet" href="{{ url('/public') }}/assets/css/home.css" />

        <!-- Bootstrap JS Bundle -->
        <script  src="{{ url('/public') }}/assets/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <!-- first-section-end -->

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    <img class="logo-sortiz-add" src="{{ url('/public') }}/assets/images/logo-sortiz.png" alt="Sportiz Logo" width="100" />
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">How It Works</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                    </ul>

                    <button class="btn custom-btn d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus"></i>
                        <span class="divider"></span>
                        <span>Register / Login</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section d-flex align-items-center text-center text-white">
            <div class="container">
                <h1 class="mb-3">Your Smart Way To Go Out!</h1>
                <p class="mb-4">We specialize in crafting events that wow - from intimate gatherings to large-scale productions. Stress-free planning starts here.</p>
                <a href="#" class="btn btn-light px-4 py-2 contact-us-btn">Contact Us <i class="bi bi-arrow-right"></i></a>
            </div>
        </section>

        <!-- first-section-start -->
        <div class="about-sortiz">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Image with border and badge -->
                    <div class="col-md-6 about-sortiz-left">
                        <img src="{{ url('/public') }}/assets/images/about-img.png" alt="Event Image" class="img-fluid custom-image" />
                    </div>

                    <!-- Text Content -->
                    <div class="col-md-6 about-sortiz-right">
                        <small class="text-uppercase">About Sortiz <img src="{{ url('/public') }}/assets/images/object-layer-icon.png" /></small>
                        <h2 class="mt-2">Every Activity Has a Story, Let’s Tell Yours</h2>

                        <div class="mt-4">
                            <p class="mb-1"><i class="bi bi-check-circle-fill check-icon me-2"></i> <strong>Reliable Execution</strong></p>
                            <p class="text-muted small">Et purus duis sollicitudin dignissim habitant. Egestas nulla quis venenatis cras sed eu massa lorem ipsum</p>

                            <p class="mb-1"><i class="bi bi-check-circle-fill check-icon me-2"></i> <strong>Trusted by Many</strong></p>
                            <p class="text-muted small">Et purus duis sollicitudin dignissim habitant. Egestas nulla quis venenatis cras sed eu massa lorem ipsum</p>
                        </div>

                        <a href="#">
                            <button class="btn contact-btn mt-3">Contact Us <i class="bi bi-arrow-right"></i></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- second-section-start -->

        <div class="how-it-works">
            <h2 class="mb-3 text-center">How It Works</h2>
            <p class="text-center">Et purus duis sollicitudin dignissim habitant. Egestas nulla quis venenatis cras sed eu.</p>
        </div>

        <!-- third-section-start -->

        <div class="create-your-event">
            <div class="container my-5">
                <div class="row align-items-center">
                    <div class="col-md-6 create-your-event-left">
                        <div class="step-number">1</div>
                        <h5>Login or Register</h5>
                        <p>
                            Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis viverra laoreet augue mattis fmentum ullamco rper viverra laoreet Aliquam eros justo,
                            posuere loborti viverra laoreet matti ullamc orper posuere viverra .Aliquam eros justo, posu Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobo
                            rtis viverra laoreet augue mattis fmentum ullamcorper viverra laoreet Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere
                        </p>
                    </div>
                    <div class="col-md-6 text-center create-your-event-right">
                        <div class="image-stack">
                            <div class="bg-shape"></div>
                            <img src="{{ url('/public') }}/assets/images/login-img.png" alt="Event Image" class="img-fluid login-image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- forth-section-start -->
        <div class="create-your-event two new-evenet-add">
            <div class="container my-5">
                <div class="row align-items-center">
                    <div class="col-md-6 text-left create-your-event-right">
                        <div class="image-stack">
                            <img src="{{ url('/public') }}/assets/images/event-img.png" alt="Event Image" class="img-fluid login-image" />
                        </div>
                    </div>
                    <div class="col-md-6 create-your-event-left text-right">
                        <div class="step-number">2</div>
                        <h5>Create Your Event</h5>
                        <p>
                            Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis viverra laoreet augue mattis fmentum ullamco rper viverra laoreet Aliquam eros justo,
                            posuere loborti viverra laoreet matti ullamc orper posuere viverra .Aliquam eros justo, posu Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobo
                            rtis viverra laoreet augue mattis fmentum ullamcorper viverra laoreet Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere
                        </p>
                    </div>
                </div>
            </div>

            <!-- five-section-start -->

            <div class="create-your-event three">
                <div class="container my-5">
                    <div class="row align-items-center">
                        <div class="col-md-6 create-your-event-left">
                            <div class="step-number">3</div>
                            <h5>Publish & Manage Your Event</h5>
                            <p>
                                Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis viverra laoreet augue mattis fmentum ullamco rper viverra laoreet Aliquam eros
                                justo, posuere loborti viverra laoreet matti ullamc orper posuere viverra .Aliquam eros justo, posu Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo,
                                posuere lobo rtis viverra laoreet augue mattis fmentum ullamcorper viverra laoreet Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere
                            </p>
                        </div>
                        <div class="col-md-6 text-center create-your-event-right">
                            <div class="image-stack">
                                <div class="bg-shape"></div>
                                <img src="{{ url('/public') }}/assets/images/manage- event-img.png" alt="Event Image" class="img-fluid login-image" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- six-section-start -->

            <div class="talk-about-your-event">
                <div class="container my-5">
                    <div class="row g-5 align-items-center">
                        <div class="col-md-6 talk-about-left">
                            <div class="form-container">
                                <form>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label">Your Email</label>
                                            <input type="email" class="form-control" placeholder="Your Email" />
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Your Phone</label>
                                            <input type="tel" class="form-control" placeholder="Your Phone" />
                                        </div>
                                    </div>
                                    <div class="mb-3 input-msg-add">
                                        <label class="form-label">Your Address</label>
                                        <input type="text" class="form-control" placeholder="Your Address" />
                                    </div>
                                    <div class="mb-3 input-msg-add">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" rows="4" placeholder="Write Message."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-custom">Send Message</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 info-section talk-about-right">
                            <h5>Message Us <img src="{{ url('/public') }}/assets/images/object-layer-two.png" /></h5>
                            <h2>Let’s Talk About Your Event!</h2>
                            <p>Whether you're just starting to plan or need expert support, we're just a message away. Tell us what you need — we'll handle the rest.</p>
                            <div class="time-setting-add">
                                <i class="bi bi-clock"></i>
                                <div>
                            <p class="time-text-add"><strong>Open Hours:</strong> <br><span class="clock-time-add">9 am - 8 pm</span></p>
                        </div>
                        </div>
                            <p><i class="bi bi-geo-alt"></i> <strong>Location:</strong> Address will goes here, France</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- footer-section-satrt -->
            <div class="meet-world-around">
                <div class="container">
                    <div class="sortix-footer">
                        <div class="container">
                            <div class="row align-items-start">
                                <div class="col-md-5 mb-4 sortix-footer-first">
                                    <img src="{{ url('/public') }}/assets/images/logo-sortiz.png" />
                                    <p class="text-white">Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis viverra laoreet augue mattis fmentum ullamco rper.</p>
                                    <div class="d-flex gap-1">
                                        <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                                        <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                                        <a href="#" class="text-white me-2"><i class="bi bi-linkedin"></i></a>
                                        <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                                        <a href="#" class="text-white"><i class="bi bi-tiktok"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-4 sortix-footer-second">
                                    <h6 class="text-white">Quick Links</h6>
                                    <ul class="list-unstyled">
                                        <li><a href="#" class="text-white text-decoration-none text-white">Privacy Policy</a></li>
                                        <li><a href="#" class="text-white text-decoration-none text-white">Terms & Conditions</a></li>
                                        <li><a href="#" class="text-white text-decoration-none text-white">Legal Notice</a></li>
                                    </ul>
                                </div>

                                <div class="col-md-4 mb-4 sortix-footer-third">
                                    <h6 class="text-white">Download The App</h6>

                                    <div class="apple-btns-add">
                                        <a href="#"><img src="{{ url('/public') }}/assets/images/google-play-icon.png" alt="App Store" class="img-fluid" /></a>
                                        <a href="#"><img src="{{ url('/public') }}/assets/images/apple-icon.png" class="img-fluid mb-2" /></a>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-secondary" />

                            <p class="text-center mb-0 all-reserved-text">© 2025 Sortiz. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
