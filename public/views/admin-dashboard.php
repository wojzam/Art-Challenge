<!DOCTYPE html>

<head>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="/public/css/admin-dashboard.css">
    <script type="text/javascript" src="/public/js/admin-dashboard.js" defer></script>
    <title>ADMIN DASHBOARD</title>
</head>

<body>
<div class="container">
    <?php require_once 'header.php'; ?>
    <main>
        <div class="content-container">
            <h1>Admin Dashboard</h1>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Delete</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->getUsername(); ?></td>
                        <td><?= $user->getEmail(); ?></td>
                        <td><?= $user->getRole(); ?></td>
                        <td>
                            <i id="<?= $user->getId(); ?>" class="fa-solid fa-xmark"></i>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</div>
</body>