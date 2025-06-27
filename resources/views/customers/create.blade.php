@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <h2>إضافة عميل جديد</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">الجنس</label>
                <select name="gender" class="form-control">
                    <option value="">اختر</option>
                    <option value="Male">ذكر</option>
                    <option value="Female">أنثى</option>
                    <option value="Other">آخر</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="date_of_birth" class="form-label">تاريخ الميلاد</label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">صورة العميل</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">إضافة</button>
        </form>
    </div>
@endsection
