<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear posts</title>
</head>
<body>
    
    <h1>Crear post</h1>

    <form action="/posts" method="post">

        <div>
            <label for="title">
                Title
            </label>
            <input type="string" name="title" id="title">
        </div>

        <!-- <div>
            <label for="email">
                Email
            </label>
            <input type="email" name="email" id="email">
        </div> -->

        <div>
            <label for="content">
                Content
            </label>
            <textarea name="content" id="content" rows="5"> </textarea>
        </div>

        <button type="submit">
            Crear
        </button>

    </form>

</body>
</html>