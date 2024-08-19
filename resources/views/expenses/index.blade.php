@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Expenses</h1>
    @if($expenses && count($expenses) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Expense Type</th>
                    <th>Description</th>
                    <th>Attachment</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_type }}</td>
                    <td>{{ $expense->description }}</td>
                    <td><a href="{{ Storage::url($expense->attachment) }}" target="_blank">View</a></td>
                    <td>{{ $expense->expense_date }}</td>
                    <td>{{ $expense->status }}</td>
                    <td>{{ $expense->payment_status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No expenses found.</p>
    @endif
</div>
@endsection
