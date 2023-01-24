<!DOCTYPE html>

<head>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="/public/css/image-collection.css">
    <script type="text/javascript" src="/public/js/image-collection.js" defer></script>
    <title>MY COLLECTION</title>
</head>

<body>
<div class="container">
    <?php require_once 'header.php'; ?>
    <main>
        <div class="content-container">
            <h1>My Collection</h1>
            <div class="big grid-gallery">
                <?php foreach ($entries as $entry): ?>
                    <div class="image-overlay-container">
                        <img src="public/img/<?= $entry->getImage(); ?>" class="collection-image"
                             alt="user image">
                        <div class="overlay">
                            <p class="title"><?= $entry->getTitle(); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php require_once 'popup-image.php'; ?>
</div>
</body>