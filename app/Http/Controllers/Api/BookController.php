<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //create method -post
    public function createBook(Request $request)
    {
        //validation
        $request->validate([
            "title" => "required",
            "book_cost" => "required"
        ]);

        //create book data
        $book = new Book();

        $book->author_id = auth()->user()->id;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->book_cost = $request->book_cost;

        //save
        $book->save();

        // send response
        return response()->json([
            "status" => 1,
            "book_cost" => "Book created successfully"
        ]);
    }

    //List Method -Get
    public function listBook()
    {
        //
        $books = Book::get();

        // send response
        return response()->json([
            "status" => 1,
            "book_cost" => "Listing Books",
            "data" => $books
        ]);
    }

    //Author book Method -Get
    public function authorBook()
    {
        //
        $author_id = auth()->user()->id;
        $books = Author::find($author_id)->books;

        // send response
        return response()->json([
            "status" => 1,
            "book_cost" => "Author  Books",
            "data" => $books
        ]);
    }
    //
    public function singleBook($book_id)
    {
        //

        $author_id = auth()->user()->id;
        if (Book::where([
            "author_id" => $author_id,
            "id" => $book_id
        ])->exists()) {
            $book = Book::find($book_id);

            return response()->json([
                "status" => true,
                "message" => "Author book found",
                "data" => $book

            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Author book does not access"
            ]);
        }
    }

    // Update method -get
    public function updateBook(Request $request, $book_id)
    {
        $author_id = auth()->user()->id;

        if (Book::where([
            "author_id" => $author_id,
            "id" => $book_id
        ])->exists()) {
            $book = Book::find($book_id);
            $book->title = isset($request->title) ? $request->title : $book->title;
            $book->description = isset($request->description) ? $request->description : $book->description;
            $book->book_cost = isset($request->book_cost) ? $request->book_cost : $book->book_cost;

            $book->save();

            return response()->json([
                "status" => true,
                "message" => "Book info has been updated",
                "data" => $book
            ]);
        } else {

            return response()->json([
                "status" => false,
                "message" => "Author book does not exists"
            ]);
        }
    }

    // DELEte method -Get
    public function deleteBook($book_id)
    {
        //
        $author_id = auth()->user()->id;

        if (Book::where([
            "author_id" => $author_id,
            "id" => $book_id
        ])->exists()) {
            $book = Book::find($book_id);
            $book->delete();

            return response()->json([
                "status" => true,
                "message" => "Book deleted by Author",
                "data"=>$book
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Author book does not exists"
              
            ]);
        }
    }
}
