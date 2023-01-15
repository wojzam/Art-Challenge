<!DOCTYPE html>

<head>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="/public/css/image-collection.css">
    <script type="text/javascript" src="/public/js/image-collection.js" defer></script>
    <script type="text/javascript" src="/public/js/search.js" defer></script>
    <script type="text/javascript" src="/public/js/statistics.js" defer></script>

    <title>EXPLORE</title>
</head>

<body>
<div class="container">
    <?php require_once 'header.php'; ?>
    <main>
        <div class="content-container">
            <h1>Explore</h1>
            <!--            <div class="search-bar">-->
            <!--                <input placeholder="search challenge">-->
            <!--            </div>-->
            <section class="challenges">
                <?php foreach ($challenges as $challenge): ?>
                    <h2 class="challenge-topic"><?= $challenge->getTopic(); ?></h2>
                    <div class="small grid-gallery">
                        <?php foreach ($challenge->getEntries() as $entry): ?>
                            <div class="image-overlay-container">
                                <img src="public/img/<?= $entry->getImage(); ?>" class="collection-image"
                                     alt="user image">
                                <div class="overlay">
                                    <div class="vote-btn">
                                        <p>Vote</p>
                                        <i class="fa-regular fa-thumbs-up"></i>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    </main>
</div>
</body>

<template id="challenge-template">
    <h2 class="challenge-topic">topic</h2>
    <div class="small grid-gallery">
        <div class="image-overlay-container">
            <img src="" class="collection-image"
                 alt="user image">
            <div class="overlay">
                <div class="vote-btn">
                    <p>Vote</p>
                    <i class="fa-regular fa-thumbs-up"></i>
                </div>
            </div>
        </div>
    </div>
</template>