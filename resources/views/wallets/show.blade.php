@extends('layouts.layout')
@php
$i = 0;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>محفظة</title>
</head>

<body style="font-family: Cairo; direction: rtl;">
    <br>
    <div class="container">
        <div class="row">
            <h3>بيانات المحفظة <span class="badge bg-secondary">اسم</span></h3>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="btn btn-primary" href="{{ route('wallets.index') }}">المحافظ</a>
            </div>
        </nav>
        <br>

        <div class="row">
            <div class="card" style="width: 50%">
                <div class="card-body">
                    <h5 class="card-title">بيانات أساسية</h5>
                    <div class="row">
                        <div class="col">
                            <p class="card-text">الأسم: <span class="fw-bolder">{{ $wallet->name }} </span></p>
                            <p class="card-text">مبلغ الأساسي: <span
                                    class="fw-bolder">{{ $wallet->principal_amount }}$</span></p>
                            <p class="card-text">مبلغ الإجمالي: <span
                                    class="fw-bolder">{{ $wallet->total_amount }}$</span></p>
                            <p class="card-text">قيود السحب: <span
                                    class="fw-bolder">{{ $wallet->restrictions }}$</span>
                            </p>
                            <p class="card-text">اسم البنك: <span class="fw-bolder">{{ $wallet->bank_name }}</span>
                            </p>
                        </div>
                        <div class="col">
                            <p class="card-text">الحالة: <span
                                    class="fw-bolder {{ $wallet->status == 'مغلقة' ? 'text-danger' : 'text-success' }}">{{ $wallet->status }}</span>
                            </p>
                            <p class="card-text">سبب الإغلاق: <span
                                    class="fw-bolder">{{ $wallet->shutdown_reason }}</span></p>
                            <p class="card-text">تاريخ الإغلاق: <span
                                    class="fw-bolder">{{ $wallet->shutdown_date }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="card" style="width: full">
                <div class="card-body">
                    <h5 class="card-title">معاملات</h5>


                    <div class="row">
                        @if ($wallet->operations->isEmpty())
                            لا يوجد معاملات
                        @else
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">نوع العملية</th>
                                        <th scope="col">مبلغ </th>
                                        <th scope="col">تاريخ </th>
                                        <th scope="col">سبب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wallet->operations->sortByDesc('operation_date') as $operation)
                                        <tr>
                                            <th scope="row">{{ ++$i }}</th>
                                            <td>{{ $operation->type }}</td>
                                            <td>{{ $operation->amount }}$</td>
                                            <td>{{ $operation->operation_date }}</td>
                                            <td>{{ $operation->reason }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif


                    </div>
                </div>
            </div>
        </div>

        <br>
</body>

</html>
