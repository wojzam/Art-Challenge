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
            <?php include 'message-display.php'; ?>
            <section id="challenges"></section>
        </div>
    </main>
</div>
</body>

<template id="challenge-template">
    <div>
        <h2 class="challenge-topic">topic</h2>
        <h3 class="counter">time-left</h3>
        <h3>YOUR ENTRY</h3>
        <img class="uploaded" src="">
        <form action="uploadEntry" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_challenge" id="id_challenge" value="">
            <input type="file" name="file"/><br/>
            <button class="submit-btn" type="submit">UPLOAD</button>
        </form>
    </div>
</template>