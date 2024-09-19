<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $model = new Post;

        /* return $model
           ->select('id', 'name', 'email')
           ->where('id', '>', 4)
           ->get();

        if (isset($_GET['search'])) {
            $posts = $model->where('name', 'LIKE', '%' . $_GET['search'] . '%')->paginate(2);
        }else{
            $posts = $model->paginate(2);
        } */

        $posts = $model->all();

        return $this->view('posts.index', compact('posts'));
 
    }

    public function create()
    {
        return $this->view('posts.create');
    }

    public function store()
    {
        $data = $_POST;

        $model = new Post;

        $model->create($data);

        $this->redirect('/posts');
    }

    public function show($id)
    {
        $model = new Post;

        $post = $model->find($id);

        return $this->view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $model = new Post;
        $post = $model->find($id);

        return $this->view('posts.edit', compact('post'));
    
    }

    public function update(/* $id */)
    {
        //$data = $_POST;
        $data = [
            'title' => $_POST['title'], 
            'content' => $_POST['content'],
            'id' => $_POST['id']
        ];

        $model = new Post;
        
        $model->update($_POST['id'], $data);

        $this->redirect("/posts/{$_POST['id']}");
    }

    public function destroy(/* $id */)
    {
        $model = new Post;
        $model->delete($_POST['id']);

        $this->redirect('/posts');
    }

}