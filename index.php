<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="./common/styles/global.css">
    <link rel="stylesheet" href="./common/styles/index.css">
    <link rel="stylesheet" href="./common/styles/dark-mode.css">
    <title>ConvoConnect</title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar">

    <div class="container-fluid p-3">
        <div class="row">
            <nav class="navbar col-md-2 sidebar d-flex flex-column justify-content-between position-fixed">
                <div class="logo text-center py-4">
                    <svg class="logo-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4800 4800" width="60px" height="60px">
                        <g fill="none" stroke="white" stroke-width="200">
                            <path d="M1350 3937a1693 1693 0 0 0 1050 363c396.3 0 761 -135.6 1050 -363M1900 974.7C1205.1 1188.2 700 1835.1 700 2600c0 192.5 32 377.5 91 550M2900 974.7c694.9 213.5 1200 860.4 1200 1625.3 0 192.5 -32 377.5 -91 550" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4300 3600c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 4300 3600m-2800 0c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 1500 3600m1400 -2700c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 2900 900" />
                        </g>
                    </svg>
                </div>
                <ul class="nav flex-column flex-grow-1 justify-content-evenly">
                    <li class="nav-item mb-3">
                        <a class="nav-link active" href="#home"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link" href="#about"><i class="fas fa-solid fa-users"></i></a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="#contact" class="nav-link"><i class="fas fa-solid fa-envelope"></i></a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link" href=""><i class="fas fa-solid fa-arrow-right"></i></a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link modeToggleBtn" href="javascript:void(0);" id="dark-mode-toggle"><i class="fas fa-solid fa-lightbulb"></i></a>
                    </li>
                </ul>
            </nav>

            <div class="col-md-11 offset-md-1">
                <div class="content-wrapper">
                    <section id="home" class="full-height px-lg-5 main-content bg-white mb-5">
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-6">
                                    <h1 class="display-4 fw-bold mb-5">Welcome to <span class="text-brand tracking-in-contract-bck">CONVOCONNECT</span><br> your messaging app</h1>
                                    <div class="btn-container">
                                        <a class="btn-content ping" href="">
                                            <span class="btn text-white">Get Started</span>
                                            <span class="icon-arrow">
                                                <svg width="66px" height="43px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <path id="arrow-icon-one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                                        <path id="arrow-icon-two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                                        <path id="arrow-icon-three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="./assets/Chatting.gif" alt="Chatting GIF" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="about" class="px-lg-5 mb-5 full-height main-content bg-white d-flex align-items-center">
                        <div class="container">
                            <h2 class="display-4 fw-bold text-center mt-3">About<br> <span class="text-brand">CONVOCONNECT</span></h2>
                            <div class="feature-container row">
                                <div class="col-md-4">
                                    <div class="feature-box bg-light">
                                        <i class="fas fa-users feature-icon"></i>
                                        <div class="feature-title">Connect with People</div>
                                        <div class="feature-description">Easily connect with friends, family, and new acquaintances. Join groups and expand your social circle.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="feature-box bg-light">
                                        <i class="fas fa-comments feature-icon"></i>
                                        <div class="feature-title">Seamless Messaging</div>
                                        <div class="feature-description">Enjoy fast and secure messaging. Share texts, photos, and more with just a few taps.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="feature-box bg-light">
                                        <i class="fas fa-shield-alt feature-icon"></i>
                                        <div class="feature-title">Privacy & Security</div>
                                        <div class="feature-description">Your conversations are protected with top-notch security measures. Your privacy is our priority.</div>
                                    </div>
                                </div>
                                <div class="col-md-4 offset-md-2">
                                    <div class="feature-box bg-light">
                                        <i class="fas fa-cogs feature-icon"></i>
                                        <div class="feature-title">Customizable Interface</div>
                                        <div class="feature-description">Tailor your messaging experience with a fully customizable interface that suits your style.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="feature-box bg-light">
                                        <i class="fas fa-briefcase feature-icon"></i>
                                        <div class="feature-title">Employee Productivity</div>
                                        <div class="feature-description">Enhance team communication and collaboration, leading to increased productivity and efficiency.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="contact" class="full-height px-lg-5 main-content bg-white d-flex align-items-center mb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <h2 class="text-center align-items-center">Stay in touch with<br>
                                        <svg class="logo-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4800 4800" width="200px" height="200px">
                                            <g fill="none" stroke="#5015a0" stroke-width="200">
                                                <path d="M1350 3937a1693 1693 0 0 0 1050 363c396.3 0 761 -135.6 1050 -363M1900 974.7C1205.1 1188.2 700 1835.1 700 2600c0 192.5 32 377.5 91 550M2900 974.7c694.9 213.5 1200 860.4 1200 1625.3 0 192.5 -32 377.5 -91 550" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4300 3600c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 4300 3600m-2800 0c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 1500 3600m1400 -2700c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 2900 900" />
                                            </g>
                                        </svg><br><span class="align-middle"> CONVOCONNECT</span>
                                    </h2>
                                    <form id="subscription-form">
                                        <div class="mb-4">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                                    </form>
                                    <div id="response" class="mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <footer class="main-content text-white py-3 text-center rounded bg-white mb-5">
                        <div class="container">
                            <p class="mb-0 fw-bold">&copy; 2024 <span>ConvoConnect</span>. All rights reserved.</p>
                        </div>
                    </footer>


                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dark-mode-toggle').click(function() {
                $('body').toggleClass('dark-mode');
                $('.sidebar').toggleClass('dark-mode');
                $('.nav-link').toggleClass('dark-mode');
                $('.full-height').toggleClass('dark-mode');
                $('.feature-box').toggleClass('dark-mode');
                $('.feature-title').toggleClass('dark-mode');
                $('.feature-description').toggleClass('dark-mode');
                $('footer').toggleClass('dark-mode');
                $('.text-brand').toggleClass('dark-mode');
            });
        });
    </script>

</body>

</html>

<!-- [mail function]
; For Win32 only.
; https://php.net/smtp
SMTP = localhost
; https://php.net/smtp-port
smtp_port = 25 -->