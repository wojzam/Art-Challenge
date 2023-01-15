<!DOCTYPE html>

<head>
    <?php require_once 'head.php'; ?>
    <title>LOGIN</title>
</head>

<body>
<div class="container">
    <?php require_once 'header.php'; ?>
    <main class="form-page">
        <div>
            <h2>Login</h2>
            <form action="login" method="POST">
                <?php include 'message-display.php'; ?>
                <h3>Email</h3>
                <input name="email" type="text" required>
                <h3>Password</h3>
                <input name="password" type="password" required>
                <button class="submit-btn" type="submit">LOGIN</button>
                <div class="row-a">
                    <p>Don't have an account? Sign up for&nbsp</p>
                    <a href="signup">ArtChallenge</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>