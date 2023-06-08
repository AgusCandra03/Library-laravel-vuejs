<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaction;

class NotificationController extends Controller
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
        $transactions = Transaction::all();

        $count_notif = Notification::where('is_read', 0)->count();
        $notifs = Notification::where('is_read', 0)->get();
        $datas = [
            // 'count' => $count_notif,
            // 'data' => $notifs
            $myDate = '09/06/2021',
            $result = Carbon::createFromFormat('m/d/Y', $myDate)->diffForHumans(),
            dd($result)
        ];

        return json_encode($datas);
    }

    public function api()
    {
        // $notifications = Notification::with('members')
        // ->join('transactions', 'transactions.id', 'notifications.transaction_id')
        // ->selectRaw('datediff(now(), date_end) as lama_telat, transactions.*, notifications.*')
        // ->get();
        // // $members = Member::all();
        // // $transactions = Transaction::all();

        // $datatables = datatables()->of($notifications)->addIndexColumn();

        // return $datatables->make(true);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
