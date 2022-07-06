@extends('layouts.layout')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wallets</title>
</head>

<body style="font-family: Cairo; direction: rtl;">
    <br>
    <div class="container">

        <div class="row">
            <h3>صفحة الرئيسية <span class=" text-info">للمحافظ</span></h3>
        </div>

        <br>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="btn btn-primary" href="#">محافظ</a>
                <a class="btn btn-success" href="{{ route('wallets.create') }}">اضافة محفظة</a>
            </div>
        </nav>

        <br>

        @if ($message = Session::get('fail'))
            <div class="alert alert-danger" id="alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success" id="alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        <br>
        <div class="row">
            @if ($wallets->isEmpty())
                <div>
                    لا يوجد محافظ
                </div>
            @else
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">اسم المحفظة</th>
                            <th scope="col">مبلغ الأساسي</th>
                            <th scope="col">مبلغ الإجمالي</th>
                            <th scope="col">قيود</th>
                            <th scope="col">اسم البنك</th>
                            <th scope="col">حالة</th>
                            <th scope="col">عرض</th>
                            <th scope="col">اغلاق</th>
                            <th scope="col">معاملة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($wallets as $wallet)
                            <tr>
                                <th scope="row">{{ ++$i }}</th>
                                <td>{{ $wallet->name }}</td>
                                <td>{{ $wallet->principal_amount }} $</td>
                                <td>{{ $wallet->total_amount }}
                                    {{ $wallet->total_amount == 0 ? '' : '$' }}</td>
                                <td>{{ $wallet->restrictions }} $</td>
                                <td>{{ $wallet->bank_name }}</td>
                                <td class="{{ $wallet->status == 'مغلقة' ? 'text-danger' : 'text-success' }}">
                                    {{ $wallet->status }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('wallets.show', $wallet->id) }}"
                                        role="button">عرض</a>
                                </td>
                                <td>
                                    @if ($wallet->status == 'مغلقة')
                                    @else
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#demoModal{{ $wallet->id }}">اغلاق
                                    @endif

                                </td>
                                <td>
                                    @if ($wallet->status == 'مغلقة')
                                    @else
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#demoModal2{{ $wallet->id }}">المعاملة
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @foreach ($wallets as $wallet)
            <div class="modal fade" id="demoModal{{ $wallet->id }}" tabindex="-1" role="dialog" aria-
                labelledby="demoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="demoModalLabel">{{ $wallet->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria- label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('wallets.update', $wallet->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <label class="form-label">سبب إغلاق المحفظة؟</label>
                                <input name="shutdown_reason" type="text" class="form-control">
                                <input name="shutdown_date" type="hidden" class="form-control"
                                    value="{{ now()->toDateTimeString() }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">اعتماد</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="demoModal2{{ $wallet->id }}" tabindex="-1" role="dialog" aria-
                labelledby="demoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="demoModalLabel">محفظة <span
                                    class="text-primary">{{ $wallet->name }}</span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('operetion.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div class="col-md-6">
                                    <input name="wallet_id" type="hidden" class="form-control"
                                        value="{{ $wallet->id }}">
                                </div>

                                <div class="col-md-6">
                                    <input name="limitation" type="hidden" class="form-control"
                                        value="{{ $wallet->restrictions }}">
                                </div>

                                <div class="col-auto">
                                    <label class="form-label">نوع العملية</label>
                                    <select name="type" class="form-select">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="ايداع">ايداع</option>
                                        <option value="سحب">سحب</option>
                                    </select>
                                </div>

                                <br>

                                <div class="col-auto">
                                    <label class="form-label">مبلغ </label>
                                    <input name="amount" type="text" class="form-control">
                                </div>

                                <br>

                                <div class="col-auto">
                                    <label class="form-label">سبب </label>
                                    <input name="reason" type="text" class="form-control">
                                </div>

                                <br>

                                <div class="col-auto">
                                    <label class="form-label">ملف</label>
                                    <input name="file" type="file"
                                        class="form-control @error('file') is-invalid @enderror"
                                        accept="application/pdf" />
                                    @error('file')
                                        <div class="alert alert-danger">{{ $message }} </div>
                                    @enderror
                                </div>



                                <input name="operation_date" type="hidden" class="form-control"
                                    value="{{ now()->toDateTimeString() }}">

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">اعتماد</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {!! $wallets->links() !!}

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(() => {
                $("div.alert").remove();
            }, 6000);
        });
    </script>

</body>

</html>
