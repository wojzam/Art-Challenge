<header>
    <div class="navbar">
        <div class="title-container">
            <a class="title" href="/"> Art Challenge </a>
        </div>
        <a href="challenge"> Challenges </a>
        <a href="joinChallenge"> Join </a>
        <a href="browseArt"> Browse art </a>
        <a href="userCollection"> My collection </a>
        <a href="adminDashboard"> Admin Dashboard </a>
    </div>
    <div id="login-signup">
        <a class="login-btn" href="login"> Login </a>
        <a class="signup-btn" href="signup"> Sign up </a>
    </div>
    <div id="user-settings">
        <button class="drop-btn"><?php echo $_COOKIE['username']; ?></button>
        <div class="dropdown-content">
            <a href="settings">Settings</a>
            <a href="logout">Log out</a>
        </div>
    </div>
</header>

<script>
    <?php
    $loggedIn = false;

    if (isset($_COOKIE['session_id'])) {
        session_id($_COOKIE['session_id']);
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            $loggedIn = true;
        }
    }

    if ($loggedIn) {
        echo 'document.getElementById("user-settings").style.display = "block";';
        echo 'document.getElementById("login-signup").style.display = "none";';
    } else {
        echo 'document.getElementById("user-settings").style.display = "none";';
        echo 'document.getElementById("login-signup").style.display = "flex";';
    }
    ?>
</script>