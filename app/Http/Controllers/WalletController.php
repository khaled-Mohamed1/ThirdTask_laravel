<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\StoreOperationRequest;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::latest()->paginate(10);
        return view('wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeoperation(StoreOperationRequest $request)
    {

        $wallet = Wallet::findorFail($request->wallet_id);

        if ($request->type == 'سحب') {
            if ($wallet->total_amount <= 0) {
                return redirect()->route('wallets.index')
                    ->with('fail', 'لا يمكن اجراء المعاملة لأن الرصيد صفر');
            } else {
                if ($request->amount > $request->limitation) {
                    return redirect()->route('wallets.index')
                        ->with('fail', 'لا يمكن اجراء هذه العملية لأن مبلغ السحب اكبر من من القيد' . ' ' . $request->limitation);
                } else {
                    $file = $request->file;
                    $newfile = time() . $file->getClientOriginalName();
                    $file->move('uploads/operation', $newfile);

                    Operation::create([
                        'wallet_id' => $request->wallet_id,
                        'type' => $request->type,
                        'amount' => $request->amount,
                        'operation_date' => $request->operation_date,
                        'reason' => $request->reason,
                        'file' => 'uploads/operation/' . $newfile,
                    ]);

                    $wallet->update([
                        'total_amount' => $wallet->total_amount - $request->amount,
                    ]);

                    return redirect()->route('wallets.index')->with('success', 'تم سحب المبلغ');
                }
            }
        } else {
            $file = $request->file;
            $newfile = time() . $file->getClientOriginalName();
            $file->move('uploads/operation', $newfile);

            Operation::create([
                'wallet_id' => $request->wallet_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'operation_date' => $request->operation_date,
                'reason' => $request->reason,
                'file' => 'uploads/operation/' . $newfile,
            ]);

            $wallet->update([
                'total_amount' => $wallet->total_amount + $request->amount,
            ]);

            return redirect()->route('wallets.index')
                ->with('success', 'محفظة ' .  $wallet->name . ' تم ايداع '  . $request->amount  . '$ إلى رصيدك');
        }

    }

    public function store(StoreWalletRequest $request)
    {
        $file = $request->file;
        $newfile = time() . $file->getClientOriginalName();
        $file->move('uploads/file', $newfile);

        Wallet::create([
            'name' => $request->name,
            'principal_amount' => $request->principal_amount,
            'total_amount' => $request->total_amount,
            'restrictions' => $request->restrictions,
            'bank_name' => $request->bank_name,
            'status' => $request->status,
            'file' => 'uploads/file/' . $newfile,
        ]);

        return redirect()->route('wallets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet = Wallet::with('operations')->findorFail($id);
        return view('wallets.show', compact('wallet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $wallet = Wallet::findorFail($id);
        $wallet->update([
            'total_amount' => 0,
            'status' => 'مغلقة',
            'shutdown_reason' => $request->shutdown_reason,
            'shutdown_date' => $request->shutdown_date
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
