<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index()
    {
        $members = Member::all();
        $books = Book::all();
        $transaction_details = TransactionDetail::all();

        return view('admin.transaction', compact('members', 'books', 'transaction_details'));
    }

    public function api(Request $request)
    {
        if($request->status){
            $transactions = Transaction::where('status', $request->status);
        }else {
            $transactions = Transaction::query();
        }

        if($request->date_start){
            $transactions = Transaction::whereDate('date_start', $request->date_start);
        }

        $transactions->with(['transaction_details.books'])
            ->join('members', 'members.id', 'transactions.member_id')
            ->selectRaw('datediff(date_end, date_start) as lama_pinjam, members.name, transactions.*')
            ->get();

        $datatables = datatables()->of($transactions)
        ->addColumn('total_buku', function ($row) {
            return $row->transaction_details->count();
        })
        ->addColumn('status_name', function ($row) {
            if ($row->status == 1) {
                return 'Belum Dikembalikan';
            } else {
                return 'Sudah Dikembalikan';
            }
        })
        ->addColumn('total_bayar', function ($row){
            $total_bayar = 0;
            foreach($row->transaction_details as $detail){
                $qty = $detail->qty;
                $harga = $detail->books->price;
                $total = $qty * $harga;
                $total_bayar += $total;
            }
            return $total_bayar;
        })
        ->addColumn('tanggal_pinjam', function ($member) {
            return format_date($member->date_start);
        })
        ->addColumn('tanggal_kembali', function ($member) {
            return format_date($member->date_end);
        })
        ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'member_id'  => 'required',
            'date_start'  => 'required',
            'date_end'  => 'required',
            'multiple_book' => 'array',
        ]);

        $transaction = Transaction::create($request->only('member_id', 'date_start', 'date_end'));
        // $transaction->status = 1;

        foreach($request->multiple_book as $multi){
            $details = new TransactionDetail();
            $details->book_id = $multi;
            $details->qty = 1;
            $books = Book::find($multi);
            $books->qty = $books->qty - 1;
            $books->save();
            $transaction->transaction_details()->save($details);
        }
        
        return redirect('transactions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->validate($request, [
            'member_id'  => 'required',
            'date_start'  => 'required',
            'date_end'  => 'required',
            'multiple_book' => 'array',
        ]);

        $transaction->update($request->all());
        if($request->status == 2){
            foreach($request->multiple_book as $multi){
                $books = Book::find($multi);
                $books->qty = $books->qty + 1;
                $books->save();
            }
        }
        
        return redirect('transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $details = TransactionDetail::find($transaction->id);
        $transaction->transaction_details()->delete($transaction, $details);
        $transaction->delete();

        return redirect('transactions');
    }
}
