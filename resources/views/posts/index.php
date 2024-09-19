<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-2"> Listado de Posts </h1>

        <a href="/posts/create" class="text-blue-600">Crear Post</a>
        <ul class="list-disc list-inside">
            <?php foreach ($posts as $key => $post) : ?>
                <li> 
                    <a href="/posts/<?= $post['id'] ?>">
                        <?= $post['title'] ?>  <?= $post['content'] ?> 
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</body>
</html>