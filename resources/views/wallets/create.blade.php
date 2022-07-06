@extends('layouts.layout')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>إضافة محفظة</title>
</head>
<style>
    body {
        direction: rtl;
    }
</style>

<body style="font-family: Cairo;">

    <div class="container">
        <br>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="btn btn-primary" href="{{ route('wallets.index') }}">المحافظ</a>
            </div>
        </nav>

        <br>

        <div class="row">
            <h1>إضافة محفظة</h1>
        </div>
        <br>
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">البيانات الأساسية</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <form class="row g-3 input-group" action="{{ route('wallets.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">الاسم المحفظة</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">مبلغ الأساسي</label>
                    <input name="principal_amount" type="text"
                        class="form-control @error('principal_amount') is-invalid @enderror"
                        value="{{ old('principal_amount') }}">
                    @error('principal_amount')
                        <div class="alert alert-danger">{{ $message }} </div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="form-label">مبلغ الإجمالي</label>
                    <input name="total_amount" type="text"
                        class="form-control @error('total_amount') is-invalid @enderror"
                        value="{{ old('total_amount') }}">
                    @error('total_amount')
                        <div class="alert alert-danger">{{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">قيود السحب</label>
                    <input name="restrictions" type="text"
                        class="form-control @error('restrictions') is-invalid @enderror"
                        value="{{ old('restrictions') }}">
                    @error('restrictions')
                        <div class="alert alert-danger">{{ $message }} </div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="form-label">اسم البنك</label>
                    <input name="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror"
                        value="{{ old('bank_name') }}">
                    @error('bank_name')
                        <div class="alert alert-danger">{{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">ملفات إضافية</label>
                    <input name="file" type="file" class="form-control @error('file') is-invalid @enderror"
                        accept="application/pdf" />
                    @error('file')
                        <div class="alert alert-danger">{{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <input name="status" type="hidden" class="form-control" value="متاحة">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">حفظ بيانات</button>
                </div>
            </form>

        </div>
        <br>
    </div>
</body>


</html>
