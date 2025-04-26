<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Admin Start Page</title>
    <link rel="stylesheet" href="/css/styles.css?v=1">
</head>

<body>
    <?php include __DIR__ . '/partials/header.php'; ?>

    <main class="flex_container center_flex container_padding">
        <a href="/index.php?page=books" class="flex_container dashboard_image_div center_flex">
            <img src="/images/books.png" alt="Books" class="dashboard_image">
            <p>Books</p>
        </a>

        <div class="dashboard_image dashboard_image_separation_div"></div>

        <a href="/index.php?page=authors" class="flex_container dashboard_image_div center_flex">
            <img src="/images/authors.png" alt="Authors" class="dashboard_image">
            <p>Authors</p>
        </a>
    </main>

    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>

</html>