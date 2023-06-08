<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Catalog;
use App\Models\Author;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlah_member = Member::count();
        $jumlah_book = Book::count();
        $jumlah_publisher = Publisher::count();
        $jumlah_transaction = Transaction::count();

        // donut chart

        $dataset_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))->groupBy('publisher_id')->orderBy('publisher_id', 'asc')->pluck('total');
        $label_donut = Publisher::orderBy('publishers.id', 'asc')->join('books', 'books.publisher_id', '=', 'publishers.id')->groupBy('name')->pluck('name');

        
        // bar chart

        $label_chart = ['Transaksi Peminjaman', 'Transaksi Pengembalian'];
        $dataset_chart = [];

        foreach($label_chart as $key => $value){
            $dataset_chart[$key]['label'] = $label_chart[$key];
            $dataset_chart[$key]['backgroundColor'] = $key == 0 ? 'rgba(60, 141, 188, 0.9)' : 'rgba(210, 214, 222, 1)';
            $data_month = [];

            foreach(range(1,12) as $month){
                if($key == 0){
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', $month)->first()->total;
                } else {
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_end', $month)->first()->total;
                }
            }

            $dataset_chart[$key]['data'] = $data_month;
        }

        return view('home', compact('jumlah_member', 'jumlah_book', 'jumlah_publisher', 'jumlah_transaction', 'dataset_donut', 'label_donut', 'dataset_chart'));
    }
}
