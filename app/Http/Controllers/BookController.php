<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use Illuminate\Http\Request;
use App\Http\Resources\BookCollection;
use App\Book;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    // all books
    public function index()
    {
        // $books = Book::all()->toArray();
        // return array_reverse($books);
        $books = Book::all();
        return response()->json($books);
    }

    // add book
    public function add(Request $request)
    {
        $extension = $request->image->getClientOriginalExtension();
        $image = date("Y-m-d").time().'.'.$extension;
        $request->image->move(public_path('images'), $image);

        $book = new Book([
            'name' => $request->input('name'),
            'author' => $request->input('author'),
            'image' => $image
        ]);
        $book->save();

        return response()->json('The book successfully added');
    }

    // edit book
    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    // update book
    public function update($id, Request $request)
    {
        
        $book = Book::find($id);
        $book->update($request->all());

        return response()->json('The book successfully updated');
    }

    // delete book
    public function delete($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json('The book successfully deleted');
    }

    // search book
    public function search($search)
    {
        $book = Book::Where('name','like','%'.$search.'%')
                ->orWhere('author','like','%'.$search.'%')
                ->get();

        return response()->json($book);
    }

    // export excel
    public function exportExcel()
    {
        $books = Book::all();
        return response()->json($books);
    }
}