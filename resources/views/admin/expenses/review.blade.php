@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Expenses for {{ $user->name }}</h1>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>Expense Type</th>
                <th>Description</th>
                <th>Attachment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Status Actions</th>
                <th>Payment Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->expenses as $expense)
            <tr>
                <td>{{ $expense->expense_type }}</td>
                <td>{{ $expense->description }}</td>
                <td><a href="{{ Storage::url($expense->attachment) }}" target="_blank">View</a></td>
                <td>{{ \Carbon\Carbon::parse($expense->expense_date)->translatedFormat('d F Y') }}</td>
                <td>
                    @if($expense->status == 'approved')
                        <span class="badge bg-success">Onaylandı</span>
                    @elseif($expense->status == 'rejected')
                        <span class="badge bg-danger">Reddedildi</span>
                    @else
                        <span class="badge bg-warning">Beklemede</span>
                    @endif
                </td>
                <td>
                    @if($expense->payment_status == 'paid')
                        <span class="badge bg-success">Ödendi</span>
                    @elseif($expense->payment_status == 'unpaid')
                        <span class="badge bg-danger">Ödenmedi</span>
                    @else
                        <span class="badge bg-warning">Beklemede</span>
                    @endif
                </td>
                <td>
                    @if($expense->status == 'pending')
                    <div class="d-flex justify-content-between">
                        <form action="{{ route('admin.expenses.updateStatus', $expense) }}" method="POST" class="me-2">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success btn-sm">Onayla</button>
                        </form>
                        <form action="{{ route('admin.expenses.updateStatus', $expense) }}" method="POST" class="me-2">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger btn-sm">Reddet</button>
                        </form>
                    </div>
                    @endif
                </td>
                <td>
                    @if($expense->payment_status == 'pending')
                    <div class="d-flex justify-content-between">
                        <form action="{{ route('admin.expenses.updatePaymentStatus', $expense) }}" method="POST" class="me-2">
                            @csrf
                            <input type="hidden" name="payment_status" value="paid">
                            <button type="submit" class="btn btn-primary btn-sm">Ödeme Yap</button>
                        </form>
                        <form action="{{ route('admin.expenses.updatePaymentStatus', $expense) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_status" value="unpaid">
                            <button type="submit" class="btn btn-danger btn-sm">Ödeme İptal</button>
                        </form>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
