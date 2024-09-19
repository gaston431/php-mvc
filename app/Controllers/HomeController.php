<?php

namespace App\Controllers;

use App\Models\Post;

class HomeController extends Controller
{

    public function index()
    {
        //$post = new Post();

        // $posts = $post->query("SELECT * FROM posts")->get();
        // $posts = $post->all();
        // $posts = $post->find(1);
        // $posts = $post->where('id', '>', '1')->get();

        //return $posts;

        return $this->view('home', [
            'title' => 'Home',
            'description' => 'Esta es la página home'
        ]);
        
    }

}