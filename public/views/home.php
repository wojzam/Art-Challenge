<!DOCTYPE html>

<head>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="/public/css/home.css">
    <title>HOME</title>
</head>

<body>
<div class="container">
    <?php require_once 'header.php'; ?>
    <main class="home-page">
        <div>
            <h1 class="welcome-text">Welcome to Art Challenge</h1>
            <h2>no matter if you are a professional or beginner,<br>
                joins us today and improve your art</h2>
            <form action="login">
                <button class="big-btn" type="submit">GET STARTED</button>
            </form>
            <section id="small-screen-view">
                <div id="login-signup">
                    <a class="login-btn" href="login"> Login </a>
                    <a class="signup-btn" href="signup"> Sign up </a>
                </div>
            </section>
        </div>
    </main>
</div>
</body>