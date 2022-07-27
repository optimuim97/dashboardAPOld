<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Repositories\PostRepository;
use Laracasts\Flash\Flash;

class PostController extends Controller
{

     /** @var  PostRepository */
     private $postRepository;

     public function __construct(PostRepository $postRepo)
     {
         $this->postRepository = $postRepo;
     }

     /**
      * Display a listing of the Entity.
      *
      * @param Request $request
      *
      * @return Response
      */
     public function index(Request $request)
     {
         $posts = $this->postRepository->all();

        //  dd($posts);

         return view('posts.index')
             ->with('posts', $posts);
     }

     /**
      * Show the form for creating a new Entity.
      *
      * @return Response
      */
     public function create()
     {
         return view('posts.create');
     }

     /**
      * Store a newly created Entity in storage.
      *
      * @param CreatePostRequest $request
      *
      * @return Response
      */
     public function store(CreatePostRequest $request)
     {
         $input = $request->all();

         $entity = $this->postRepository->create($input);

         Flash::success('Entity saved successfully.');

         return redirect(route('posts.index'));
     }

     /**
      * Display the specified Entity.
      *
      * @param int $id
      *
      * @return Response
      */
     public function show($id)
     {
         $entity = $this->postRepository->find($id);

         if (empty($entity)) {
             Flash::error('Entity not found');

             return redirect(route('posts.index'));
         }

         return view('posts.show')->with('entity', $entity);
     }

     /**
      * Show the form for editing the specified Entity.
      *
      * @param int $id
      *
      * @return Response
      */
     public function edit($id)
     {
         $entity = $this->postRepository->find($id);

         if (empty($entity)) {
             Flash::error('Entity not found');

             return redirect(route('posts.index'));
         }

         return view('posts.edit')->with('entity', $entity);
     }

     /**
      * Update the specified Entity in storage.
      *
      * @param int $id
      * @param UpdatePostRequest $request
      *
      * @return Response
      */
     public function update($id, UpdatePostRequest $request)
     {
         $entity = $this->postRepository->find($id);

         if (empty($entity)) {
             Flash::error('Entity not found');

             return redirect(route('posts.index'));
         }

         $entity = $this->postRepository->update($request->all(), $id);

         Flash::success('Entity updated successfully.');

         return redirect(route('posts.index'));
     }

     /**
      * Remove the specified Entity from storage.
      *
      * @param int $id
      *
      * @throws \Exception
      *
      * @return Response
      */
     public function destroy($id)
     {
         $entity = $this->postRepository->find($id);

         if (empty($entity)) {
             Flash::error('Entity not found');

             return redirect(route('posts.index'));
         }

         $this->postRepository->delete($id);

         Flash::success('Entity deleted successfully.');

         return redirect(route('posts.index'));
     }
}
