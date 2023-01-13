<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/public/css/image-collection.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aleo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <title>MY COLLECTION</title>
</head>

<body>
<div class="container">
    <?php include 'header.php'; ?>
    <main>
        <div class="content-container">
            <h1>My Collection</h1>
            <div class="big grid-gallery">

                <?php foreach ($entries as $entry): ?>
                    <div class="image-overlay-container">
                        <img src="public/img/uploads/<?= $entry->getImage(); ?>" class="collection-image"
                             alt="user image">
                        <div class="overlay">
                            <p><?= $entry->getTitle(); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="image-overlay-container">
                    <img src="public/img/examples/cat_1.png" class="collection-image">
                    <div class="overlay">
                        <p>Cat</p>
                    </div>
                </div>

                <div class="image-overlay-container">
                    <img src="public/img/examples/cat_2.png" class="collection-image">
                    <div class="overlay">
                        <p>Cat</p>
                    </div>
                </div>

                <div class="image-overlay-container">
                    <img src="public/img/examples/cat_1.png" class="collection-image">
                    <div class="overlay">
                        <p>Cat</p>
                    </div>
                </div>

                <div class="image-overlay-container">
                    <img src="public/img/examples/cat_1.png" class="collection-image">
                    <div class="overlay">
                        <p>Cat</p>
                    </div>
                </div>

                <div class="image-overlay-container">
                    <img src="public/img/examples/cat_2.png" class="collection-image">
                    <div class="overlay">
                        <p>Cat</p>
                    </div>
                </div>

                <div class="image-overlay-container">
                    <img src="public/img/examples/cat_1.png" class="collection-image">
                    <div class="overlay">
                        <p>Cat</p>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
</body>