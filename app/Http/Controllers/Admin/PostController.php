<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all(); //recuperiamo tutti i post
        return view('admin.posts.index', compact('posts'));
        //ritorno la view in admin/posts/index.blade.php e passo tutti i posts

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.posts.create');
        //ritorno la view in admin/posts/create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|max:250',
            'content' => 'required',
        ]);
        //prima di tutto lanciamo la validazione dei dati

        $postData = $request->all(); //prendiamo tutti i dati
        $newPost = new Post();//creiamo una nuova istanza di post
        $newPost->fill($postData);//filliamo newPost instance con i dati
        $slug = Str::slug($newPost->title);//prendo il valore di titolo che potrebbe avere caratteri particolari e lo passiamo in slug per sistemarlo
        $alternativeSlug = $slug;//ci serve valorizzarlo uguale cosi' dopo il while possiamo avere il valore univoco corretto

        $postFound = Post::where('slug', $slug)->first();
        //definiamo una variabile, usiamo post con static method where
        //se passiamo due parametri fa l'uguaglianza quindi se slug e' uguale al nostro slug
        //prendiamo solo il primo record con quello slug

        $counter = 1;
        //mettiamo un numero in coda allo slug e lo facciamo partire da 1
        while($postFound){//fintanto che postFound esiste (fintanto che un record e' uguale allo slug continuiamo a ciclare, pero' cambio lo slug da verificare)
            $alternativeSlug = $slug . '_' . $counter;//definiamo una chiave che prende lo slug e ci aggiunge il counter
            $counter++;//aumentiamo il contatore
            $postFound = Post::where('slug', $alternativeSlug)->first();
            //definiamo una variabile con all'interno il primo slug uguale al nostro slug alternativo
        }

        $newPost->slug = $alternativeSlug;

        $newPost->save();
        //salviamo il post

        return redirect()->route{'admin.posts.index'};
        //redirect alla route dove ci sono tutti i post 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
