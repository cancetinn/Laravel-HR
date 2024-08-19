@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Expenses Management</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Expenses</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->expenses_count > 0)
                        <span class="badge badge-primary">{{ $user->expenses_count }}</span>
                    @else
                        No Expenses
                    @endif
                </td>
                <td>
                    @if($user->expenses_count > 0)
                        <a href="{{ route('admin.expenses.review', $user->id) }}" class="btn btn-info">Review</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
