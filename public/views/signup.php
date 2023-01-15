<!DOCTYPE html>

<head>
    <?php require_once 'head.php'; ?>
    <script type="text/javascript" src="/public/js/validate-signup.js" defer></script>
    <title>SIGNUP</title>
</head>

<body>
<div class="container">
    <?php require_once 'header.php'; ?>
    <main class="form-page">
        <div>
            <h2>Sign up</h2>
            <form action="signup" method="POST">
                <?php include 'message-display.php'; ?>
                <h3>Username</h3>
                <input name="username" type="text" required>
                <h3>Email</h3>
                <input name="email" type="text" required>
                <h3>Password</h3>
                <input name="password" type="password" required>
                <h3>Repeat password</h3>
                <input name="passwordRepeated" type="password" required>
                <button class="submit-btn" type="submit">SIGN UP</button>
                <div class="row-a">
                    <p>Already have an account?&nbsp</p>
                    <a href="login">Log in</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>