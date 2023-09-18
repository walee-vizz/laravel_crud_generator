@extends('layouts.backend.main')
@section('title', 'Create-Activity log')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@section('admin-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-center">
                            <h1 class="card-title">Create Activity log</h1>
                        </div>
                        <div class="col " style="text-align:end;"><a href="{{ route('activity_log.index') }}"
                                class="btn btn-outline-dark">Back</a></div>
                    </div>
                </div>
                <div class="card-body">
                    @include('partials.backend.messages')
                    <form action="{{ route('activity_log.store') }}" method="POST">
                        @csrf
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" @error('user_id') is-invalid @enderror
                            class="form-control select2">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror
                        <label for="activity_type">
                            Activity type</label>
                        <input type="text" class="form-control @error('activity_type') is-invalid @enderror "
                            name="activity_type" id="activity_type" value="{{ old('activity_type') }}">
                        @error('activity_type')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror
                        <label for="description">Description</label>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror " name="description"
                            id="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror
                        <button type="submit" class="btn btn-outline-primary ">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        })
    </script>
@endsection
