@extends('layouts.backend.main')
@section('title', 'View-Activity log')
@section('styles')

@endsection
@section('admin-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-center">
                            <h1 class="card-title">Activity log List</h1>
                        </div>
                        <div class="col " style="text-align:end;"><a href="{{ route('activity_log.create') }}"
                                class="btn btn-outline-primary">Add New</a></div>
                    </div>
                </div>
                <div class="card-body">
                    @include('partials.backend.messages')
                    <table class="table table-bordered " id="datatable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User Name</th>
                                <th>Activity Type</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->user->name }}</td>
                                    <td>{{ $log->activity_type }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td><a href="{{ route('activity_log.edit', $log) }}" class="btn btn-primary btn-sm">Edit
                                        </a>
                                        <a href="{{ route('activity_log.destroy', $log) }} "
                                            class="btn btn-danger btn-sm">Delete </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {


            $('#datatable').DataTable();




        });
    </script>

@endsection
