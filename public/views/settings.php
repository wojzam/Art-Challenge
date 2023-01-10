<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/css/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aleo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <title>SETTINGS</title>
</head>

<body>
<div class="container">
    <?php include 'header.php'; ?>
    <main class="form-page">
        <div>
            <h2>Account settings</h2>
            <?php include 'message-display.php'; ?>
            <form action="changeUsername" method="POST">
                <h3>New username</h3>
                <input name="newUsername" type="text">
                <button class="submit-btn dark-version" type="submit">CHANGE USERNAME</button>
            </form>
            <form action="changePassword" method="POST">
                <h3>Old password</h3>
                <input name="oldPassword" type="password">
                <h3>New password</h3>
                <input name="newPassword" type="password">
                <h3>Repeat new password</h3>
                <input name="newPasswordRepeated" type="password">
                <button class="submit-btn dark-version" type="submit">CHANGE PASSWORD</button>
            </form>
            <form action="deleteUser" method="POST">
                <button class="submit-btn dark-version" type="submit">DELETE ACCOUNT</button>
            </form>
        </div>
    </main>
</div>
</body>