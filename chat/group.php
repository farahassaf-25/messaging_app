<!DOCTYPE html>
<html>

<head>
    <title>Group chat</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <link rel="stylesheet" href="../common/styles/global.css" />
    <link rel="stylesheet" href="../common/styles/sidebar.css" />
    <link rel="stylesheet" href="../common/styles/screen.css" />

    <link rel="stylesheet" href="./styles/group.css" />
    <link rel="stylesheet" href="./styles/message.css" />
    <link rel="stylesheet" href="./styles/groupCard.css" />
</head>

<body>
    <nav class="col-md-2 sidebar d-flex flex-column justify-content-between">
        <div class="logo text-center py-4">
            <img src="../assets/logo.svg" alt="logo" width="64px" height="64px" class="logo-img" />
        </div>
        <ul class="nav flex-column flex-grow-1">
            <li class="nav-item mb-3">
                <a class="nav-link active" href="../users/users.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link" href="../user/profile.php"><i class="fas fa-cog"></i></a>
            </li>
            <li class="nav-item mb-3">
                <a href="" class="nav-link"><i class="fas fa-solid fa-comments"></i></a>
            </li>
        </ul>
        <div class="text-center mb-3">
            <a class="nav-link" href="#">
                <img src="../assets/defaultProfile.webp" class="rounded-circle pfp" width="40" alt="Admin">
            </a>
            <a class="nav-link" href="#"><i class="fas fa-arrow-right"></i></a>
        </div>
    </nav>
    <div class="screens">
        <div class="side">
            <input class="search" placeholder="Search" />
            <div class="screen chatList">
                <p class="title">Chats</p>
                <div class="groupCard clickable">
                    <img src="https://cataas.com/cat?b=09089213" class="pfp" alt="group image" class="pfp" />
                    <div class="info">
                        <div class="row">
                            <div class="name"> John Doe </div>
                            <div class="date"> 9m </div>
                        </div>
                        <div class="row">
                            <div class="message"> Photo </div>
                            <div class="count"> 1 </div>
                        </div>
                    </div>
                </div>

                <div class="groupCard clickable">
                    <img src="https://cataas.com/cat?b=090892" class="pfp" alt="group image" class="pfp" />
                    <div class="info">
                        <div class="row">
                            <div class="name"> David Mark </div>
                            <div class="date"> 15m </div>
                        </div>
                        <div class="row">
                            <div class="message"> Have you heard of this article... </div>
                            <div class="count"> 2 </div>
                        </div>
                    </div>
                </div>

                <div class="groupCard clickable">
                    <img src="https://cataas.com/cat?b=09089" class="pfp" alt="group image" class="pfp" />
                    <div class="info">
                        <div class="row">
                            <div class="name"> Kevin Garcia </div>
                            <div class="date"> 1h </div>
                        </div>
                        <div class="row">
                            <div class="message"> You: Interesting, I will look into it... </div>
                            <div class="count" style="display: none"> 0 </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="screen groupList">
                <p class="title">Groups</p>
                <div class="groupCard clickable">
                    <img src="https://cataas.com/cat" class="pfp" alt="group image" class="pfp" />
                    <div class="info">
                        <div class="row">
                            <div class="name"> Planet of code </div>
                            <div class="date"> Now </div>
                        </div>
                        <div class="row">
                            <div class="message"> David: Are you ready to express... </div>
                            <div class="count"> 5 </div>
                        </div>
                    </div>
                </div>

                <div class="groupCard clickable selected">
                    <img src="https://cataas.com/cat/Xw3yOJ2ZkLohXYRX" class="pfp" alt="group image" class="pfp" />
                    <div class="info">
                        <div class="row">
                            <div class="name"> Friends and Family </div>
                            <div class="date"> 5m </div>
                        </div>
                        <div class="row">
                            <div class="message"> Emily: Hey hey hey, what's ... </div>
                            <div class="count" style="display: none;"> 5 </div>
                        </div>
                    </div>
                </div>

                <div class="groupCard clickable">
                    <img src="https://cataas.com/cat?b=09" class="pfp" alt="group image" class="pfp" />
                    <div class="info">
                        <div class="row">
                            <div class="name"> ChitChat </div>
                            <div class="date"> 12:00 </div>
                        </div>
                        <div class="row">
                            <div class="message"> Proton: Photo </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="chat screen">
            <div class="header clickable">
                <div class="groupInfo">
                    <img src="../assets/defaultProfile.webp" alt="group image" class="pfp big" />
                    <div class="name"> Group name </div>
                </div>
            </div>
            <hr />

            <div class="body">

                <div class="messageRow me">
                    <div class="messageWrapper">
                        <div class="message">
                            <div class="messageContent">
                                <div class="content">Hello everyone! I hope you are doing great today</div>
                            </div>
                        </div>
                        <div class="date">3:51 PM • 04/07/2024</div>
                    </div>
                </div>
                <div class="messageRow">
                    <div class="messageWrapper">
                        <div class="message"><img class="pfp" src="https://cataas.com/cat?bust=963.2623511955723&amp;width=64&amp;height=64">
                            <div class="messageContent">
                                <p class="name">John Doe</p>
                                <div class="content">Hi, I'm great! How are you today?</div>
                            </div>
                        </div>
                        <div class="date">3:51 PM • 04/07/2024</div>
                    </div>
                </div>
                <div class="messageRow me">
                    <div class="messageWrapper">
                        <div class="message">
                            <div class="messageContent">
                                <div class="content">Amazing! What are you up to?</div>
                            </div>
                        </div>
                        <div class="date">3:51 PM • 04/07/2024</div>
                    </div>
                </div>
                <div class="messageRow">
                    <div class="messageWrapper">
                        <div class="message"><img class="pfp" src="https://cataas.com/cat?bust=963.2623511955723&amp;width=64&amp;height=64">
                            <div class="messageContent">
                                <p class="name">John Doe</p>
                                <div class="content">Hey hey hey, what's up?</div>
                            </div>
                        </div>
                        <div class="date">3:51 PM • 04/07/2024</div>
                    </div>
                </div>
                <div class="messageRow">
                    <div class="messageWrapper">
                        <div class="message"><img class="pfp" src="https://cataas.com/cat?bust=856.3535901311353&amp;width=64&amp;height=64">
                            <div class="messageContent">
                                <p class="name">Bob Johnson</p>
                                <div class="content">Hi, I'm great! How are you today?</div>
                            </div>
                        </div>
                        <div class="date">3:51 PM • 04/07/2024</div>
                    </div>
                </div>
                <div class="messageRow me">
                    <div class="messageWrapper">
                        <div class="message">
                            <div class="messageContent">
                                <div class="content">Amazing!</div>
                            </div>
                        </div>
                        <div class="date">3:51 PM • 04/07/2024</div>
                    </div>
                </div>
                <div class="messageRow">
                    <div class="messageWrapper">
                        <div class="message"><img class="pfp" src="https://cataas.com/cat?bust=234.08361359879711&amp;width=64&amp;height=64">
                            <div class="messageContent">
                                <p class="name">Emily Davis</p>
                                <div class="content">Hey hey hey, what's up?</div>
                            </div>
                        </div>
                        <div class="date">3:51 PM • 04/07/2024</div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <input class="messageInput" placeholder="Type a message…" />
                <!-- Using clicable instead of a normal button for styling -->
                <div class="attachButton clickable"> <i class="fas fa-paperclip"></i></div>
                <button class="sendButton"> <i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script src="../common/scripts/models/Message.js"></script>

    <script src="../common/scripts/appendAlert.js"></script>
    <script src="../common/scripts/showModal.js"></script>
    <script src="../common/scripts/fetchSafe.js"></script>

    <script src="./scripts/messageFactory.js"></script>
    <script src="./scripts/group.js"></script>

</body>

</html>