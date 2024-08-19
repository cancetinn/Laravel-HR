@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Expense</h1>
    <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="expense_type">Expense Type</label>
            <select name="expense_type" id="expense_type" class="form-control" required>
                <option value="Taşıt">Taşıt</option>
                <option value="Gıda">Gıda</option>
                <option value="Dijital Üyelik">Dijital Üyelik</option>
                <!-- Diğer seçenekler -->
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="attachment">Attachment (PDF or Image)</label>
            <input type="file" name="attachment" id="attachment" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="expense_date">Expense Date</label>
            <input type="date" name="expense_date" id="expense_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Expense</button>
    </form>
</div>
@endsection
