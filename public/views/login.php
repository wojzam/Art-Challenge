<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/css/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aleo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <title>LOGIN</title>
</head>

<body>
<div class="container">
    <?php include 'header.php'; ?>
    <main class="form-page">
        <div>
            <h2>Login</h2>
            <form action="login" method="POST">
                <div class="messages">
                    <?php
                    if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <h3>Email</h3>
                <input name="email" type="text">
                <h3>Password</h3>
                <input name="password" type="password">
                <button type="submit">LOGIN</button>
                <div class="row-a">
                    <p>Don't have an account? Sign up for&nbsp</p>
                    <a href="signup">ArtChallenge</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>