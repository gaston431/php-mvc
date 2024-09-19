<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del post</title>
</head>
<body>

    <h1>Detalle del post</h1>

    <a href="/posts">Volver</a>
    <a href="/posts/<?= $post['id'] ?>/edit">Editar</a>

    <p>Title <?= $post['title'] ?></p>
    <p>Content <?= $post['content'] ?></p>

    <form action="/posts" method="post">

        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $post['id'] ?>">

        <button>
            Eliminar
        </button>

    </form>

</body>
</html>