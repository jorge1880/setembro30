<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Curso;
use App\Models\Professor;

class SiteController extends Controller
{
    
    public function index(){

        $posts = Post::paginate(3);
        $totalAlunos = User::where('nivel', 'aluno')->count();
        $totalCursos = Curso::count();
        $totalProfessores = Professor::count();

        return view('site.home', compact('posts', 'totalAlunos', 'totalCursos', 'totalProfessores'));
    }

    public function sobre(){
        return view('site.sobre');
    }


    public function show($id){
        $post = Post::findOrFail($id);
        return view('site.single-post', compact('post'));

    }
    
}
