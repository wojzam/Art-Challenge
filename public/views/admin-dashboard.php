<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/public/css/image-collection.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aleo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <title>ADMIN DASHBOARD</title>
</head>

<body>
<div class="container">
    <?php include 'header.php'; ?>
    <main>
        <div class="content-container">
            <h1>Admin Dashboard</h1>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->getUsername(); ?></td>
                        <td><?= $user->getEmail(); ?></td>
                        <td><?= $user->getRole(); ?></td>
                        <td>
                            <button>Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</div>
</body>