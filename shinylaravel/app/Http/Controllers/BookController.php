<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $completedBooks = Book::where('completed', true)->get();
        $incompleteBooks = Book::where('completed', false)->get();
        return view('shinybooks', ['completedBooks' => $completedBooks, 'incompleteBooks' => $incompleteBooks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(('create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
        if ($request->isJson()) {
            $data = $request->json()->all();
            if (array_key_exists('book', $data)) {
                $bookData = $data['book'];
            } else {
                // Handle error - 'book' key not found
                return response()->json(['error' => 'book key not found'], 400);
            }
        } else {
            try {
                $this->validate(request(), [
                    'title' => ['required'],
                    'author'=> ['required'],
                    'series'=> ['required'],
                    'cover'=> ['required'],
                ]);
            } catch (ValidationException $e) {
            }
        }
        
        $data = request()->all();

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverPath = $cover->store('covers', 'public');  // The 'public' disk makes it publicly accessible
    
            
            $newBook = new Book;
            $newBook->title = $request->input('title');
            $newBook->author = $request->input('author');
            $newBook->series = $request->input('series');
            $newBook->cover = $coverPath;
    
            $newBook->save();
        } else {
        
            $newBook = new Book;
            $newBook->title = $data['title'];
            $newBook->author = $data['author'];
            $newBook->series = $data['series'];
            $newBook->cover = $data['cover'];

            $newBook->save();
        
        }
        session()->flash('success', 'Book added succesfully');

        return redirect('/');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existingBook = Book::find($id);
        Log::info('Debugging isChecked', ['isChecked' => $request->input('isChecked')]);

        if ($existingBook) {
            $existingBook->completed = $request->input('isChecked') ? true : false;
            $existingBook->completed_at = $request->input('isChecked') ? Carbon::now() : null;
            $existingBook->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'No book found']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // log the exception message
            Log::error('An error occurred while deleting the book: ' . $e->getMessage());
            return response()->json(['error' => 'Some error occurred'], 500);
        }

    }
}
