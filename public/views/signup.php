<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aleo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <title>SIGNUP</title>
</head>

<body>
<div class="container">
    <?php include 'header.php'; ?>
    <main class="form-page">
        <div>
            <h2>Sign up</h2>
            <form action="signup" method="POST">
                <div class="messages">
                    <?php
                    if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <h3>Username</h3>
                <input name="username" type="text">
                <h3>Email</h3>
                <input name="email" type="text">
                <h3>Password</h3>
                <input name="password" type="password">
                <h3>Repeat password</h3>
                <input name="passwordRepeated" type="password">
                <button>SIGN UP</button>
                <div class="row-a">
                    <p>Already have an account?&nbsp</p>
                    <a href="login">Sign in</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>