<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books page</title>
    <link rel="stylesheet" href="/css/styles.css?v=1">
</head>

<body>
    <?php include __DIR__ . '/partials/header.php'; ?>


    <main class="container_padding">
        <h2>BOOKS</h2>
        <div class="table_wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year</th>
                        <th>Genre</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author_name'] . ' ' . $book['author_surname']) ?></td>
                            <td><?= htmlspecialchars($book['year']) ?></td>
                            <td><?= htmlspecialchars($book['genre']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                </tfoot>

            </table>
        </div>

    </main>

    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>

</html>