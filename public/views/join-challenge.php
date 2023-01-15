<!DOCTYPE html>

<head>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="/public/css/join-challenge.css">
    <script type="text/javascript" src="/public/js/join-challenge.js" defer></script>
    <title>JOIN CHALLENGE</title>
</head>

<body>
<div class="container">
    <?php require_once 'header.php'; ?>
    <main>
        <div class="content-container">
            <h1>Join challenge</h1>
            <div class="tab-menu">
                <a id="tab-daily">Daily</a>
                <a id="tab-weekly">Weekly</a>
            </div>
            <div>
                <h2 class="challenge-topic">"Cat"</h2>
                <h3 class="counter">Time left: 10</h3>
                <h3>YOUR ENTRY</h3>
                <form action="uploadEntry" method="POST" ENCTYPE="multipart/form-data">
                    <?php include 'message-display.php'; ?>
                    <input type="file" name="file"/><br/>
                    <button class="submit-btn" type="submit">UPLOAD</button>
                </form>
            </div>
        </div>
    </main>
</div>
</body>