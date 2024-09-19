<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar post</title>
</head>
<body>
    
    <h1>Actualizar post</h1>

    <form action="/posts" method="post">

        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="<?= $post['id'] ?>">

        <div>
            <label for="title">
                Title
            </label>
            <input type="text" name="title" id="title" value="<?= $post['title'] ?>">
        </div>

        <!-- <div>
            <label for="email">
                Email
            </label>
            <input type="email" name="email" id="email" value="<?= $post['email'] ?>">
        </div> -->

        <div>
            <label for="content">
                Content
            </label>
            <textarea name="content" id="content" rows="5" cols="20"><?= $post['content'] ?></textarea>
        </div>

        <button type="submit">
            Actualizar
        </button>

    </form>

</body>
</html>