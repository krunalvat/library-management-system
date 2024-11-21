<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Borrower;
use App\Models\BookBorrow;
use App\Http\Requests\BookRequest;
use Carbon\Carbon;
use App\Http\Requests\BorrowRequest;
use Yajra\DataTables\Facades\DataTables;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('book.index');
    }

    /**
     * Get all user for listing
     *
     * @param Request $request
     */
    public function getData(Request $request)
    {
        $query = Book::query();
        
        $books = $query->select('*');

        $books = $books->get();

        return Datatables::of($books)
            ->addIndexColumn()
            ->editColumn('author_id', function ($data) {
                return !empty($data->author) ? $data->author->name : '-';
            })
            ->editColumn('status', function ($data) {
                switch ($data->status) {
                    case 'available':
                        return '<div class="badge bg-success text-white actions">Available</div>';
                    case 'borrowed':
                        return '<div class="badge bg-warning text-white actions">Borrowed</div>';
                    default:
                        return '<div class="badge bg-secondary text-white actions">Unknown</div>';
                } 
            })
            ->addColumn('action', function ($data) {
                $actions = '';
                $actions .= '<a href="javascript:;" data-url="' . route('books.show', $data->id) . '" class="btn btn-link btn-success modal-popup-view" data-modal-title="Employee Details"><i class="fa fa-eye"></i></a>';
                $actions .= '<a href="' . route('books.edit', $data->id) . '" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></a>';
                $actions .= '<a href="javascript:;" data-url="' . route('books.destroy', $data->id) . '" class="btn btn-link btn-danger modal-popup-delete" data-modal-delete-text="Are you sure you want to delete this user?"><i class="fa fa-times"></i></a>';
                return $actions;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::pluck('name','id');
        return view('book.create_update',compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = $request->all();

        Book::create($data);

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $data  = [
            'Title'          =>  $book->title,
            'ISBN'           =>  $book->isbn,
            'Status'         =>  $book->status == 'available' ? 'Available'  : 'Borrowed',
        ];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::pluck('name','id');
        return view('book.create_update',compact('authors','book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $data = $request->all();

        $book->update($data);

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
    }

    public function borrowingBook()
    {
        $books = Book::where('status','available')->pluck('title','id');
        return view('book.borrow-book',compact('books'));
    }

    public function storeBorrowBookData(BorrowRequest $request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone_number'] = $request->phone_number;

        $updateBookStatus = Book::find($data['book_id']);

        if(empty($updateBookStatus)){
            return redirect()->back('borrowing.book');
        }

        $borrower = Borrower::create($data);

        $borrowedAt = Carbon::parse($data['borrowed_at']);
        $dueDate = $borrowedAt->addDays(7);

        $bookBorrowData =[
            'book_id' => $data['book_id'],
            'borrower_id' => $borrower->id,
            'borrowed_at' => $data['borrowed_at'],
            'due_date' => $dueDate,
        ];

        BookBorrow::create($bookBorrowData);

        $updateBookStatus->update(['status' => 'borrowed']);

        return redirect()->route('books.index')->with('success', 'Book borrowed successfully');
    }
}
