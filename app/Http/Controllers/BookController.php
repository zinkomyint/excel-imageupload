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
      

        $request->validate([
            'name' => 'required',
            'author' => 'required',
            'image' => 'required',
            'gender' => 'required',
            'model' => 'required',
        ]);

        if($request->hasFile('image'))
        {
            $extension = $request->image->getClientOriginalExtension();
            $image = date("Y-m-d").time().'.'.$extension;
            $request->image->move(public_path('images'), $image);
        }else
        {
            $image = "";
        }

        
        
        
        $book = new Book([
            'name' => $request->input('name'),
            'author' => $request->input('author'),
            'gender' => $request->input('gender'),
            'model' => $request->input('model'),
            'image' => $image

        ]);
        $book->save();
        return response()->json(['success'=>'Done!']);
    

        // return response()->json('The book successfully added');
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
        $request->validate([
            'name' => 'required',
            'author' => 'required',
            'image' => 'required',
            'gender' => 'required',
            'model' => 'required',
        ]);
        
        if($request->hiddenImage == "")
        {
            if($request->hasFile('image'))
            {
                $extension = $request->image->getClientOriginalExtension();
                $image = date("Y-m-d").time().'.'.$extension;
                $request->image->move(public_path('images'), $image);
            }else
            {
                $image = "";
            }
        }
        
    else
    {
        if($request->hasFile('image'))
        {
            $extension = $request->image->getClientOriginalExtension();
            $image = date("Y-m-d").time().'.'.$extension;
            $request->image->move(public_path('images'), $image);
        }
        else
        {
            $image = $request->hiddenImage;
        }
    }

        $book = Book::find($id);
        $book->name   = $request->input('name');
        $book->author = $request->input('author');
        $book->gender = $request->input('gender');
        $book->model = $request->input('model');
        $book->image  = $image;

        $book->save();

        // $book = Book::find($id);
        // $book->update($request->all());

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