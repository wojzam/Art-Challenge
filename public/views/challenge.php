<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/css/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aleo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <title>CHALLENGE</title>
</head>

<body>
<div class="container">
    <?php include 'header.php'; ?>
    <main class="form-page">
        <h1>Draw cat</h1>
        <h2>UPLOAD YOUR ENTRY</h2>
        <form action="uploadEntry" method="POST" ENCTYPE="multipart/form-data">
            <div class="messages">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <input class="file-input" type="file" name="file"/><br/>
            <button type="submit">UPLOAD</button>
        </form>
    </main>
</div>
</body>