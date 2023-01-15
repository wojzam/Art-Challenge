<header>
    <div class="navbar">
        <div class="page-title-container">
            <a class="page-title" href="/"> Art Challenge </a>
        </div>
        <a href="explore"> Explore </a>
        <a href="joinChallenge"> Join </a>
        <a href="userCollection"> My collection </a>
        <a href="adminDashboard"> Admin Dashboard </a>
    </div>
    <div id="login-signup">
        <a class="login-btn" href="login"> Login </a>
        <a class="signup-btn" href="signup"> Sign up </a>
    </div>

    <div id="user-settings">
        <div class="drop-btn">
            <i class="fa-solid fa-circle-user"></i>
            <p><?php echo $_COOKIE['username']; ?></p>
        </div>
        <div class="dropdown-content">
            <a href="settings">Settings</a>
            <a href="logout">Log out</a>
        </div>
    </div>
</header>

<script>
    <?php
    $loggedIn = false;

    if (isset($_COOKIE['session_token'])) {
        $loggedIn = true;
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