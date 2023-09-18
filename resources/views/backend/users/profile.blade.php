@extends('layouts.backend.main')

@section('title', 'Profile Page')
{{-- @include('partials.backend.logout') --}}
@section('styles')
    <style>
        .edit-profile-img-button {
            position: absolute;
            bottom: 31%;
            left: 51%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            display: none;
            cursor: pointer;
            /* Initially hidden */
        }

        .position-relative:hover .edit-profile-img-button {
            display: block;
            /* Show on hover */
        }

        .edit-profile-img-button input {
            position: absolute;
            height: 50px;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
    </style>
@endsection
@section('admin-content')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <div class="position-relative">
                        @if($user->picture)
                        <img class="rounded-circle mt-5" id="profile_picture_show" width="150px"
                        src="{{ asset($user->picture) }}">
                        @else

                        <img class="rounded-circle mt-5" id="profile_picture_show" width="150px"
                            src="{{ asset('user_icon.jpg') }}">
                        @endif
                        <button href="#" id="" class="edit-profile-img-button"><i class="far fa-edit"></i>
                            <input type="file" name="picture" id="picture">
                        </button>
                    </div>
                    <span class="font-weight-bold">{{ $user->name }}</span>
                    <span>
                        <form action="{{ route('admin.user.upload.picture', $user) }}" id="picture_upload_form">@csrf <input
                                type="file" class="d-none" name="new_profile_picture" id="new_profile_picture"> </form>
                    </span>
                    <span class="text-black-50">{{ $user->email }}</span>
                </div>
            </div>
            <div class="col ">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    {{-- @include('partials.backend.messages') --}}
                    @include('partials.backend.messages')
                    <form action="{{ route('admin.user.update', $user) }}" method="POST">
                        @csrf
                        <div class="row mt-2">
                            <div class="col">
                                <label class="labels">Full Name</label><input type="text"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="first name"
                                    value="{{ $user->name }}" name="name">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label class="labels">Email ID</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="enter email id " value="{{ $user->email }}" name="email">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">New Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter password " value="">
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control  @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Enter password ">
                                @error('password_confirmation')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-5 text-center"><button type="submit" class="btn btn-primary profile-button">Save
                                Profile</button></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#picture').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profile_picture_show').attr('src', '{{ asset('loading_picture.jpg') }}');

                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('picture', file);
                        formData.append('user_id', '{{ $user->id }}');

                        fetch('{{ route('admin.user.upload.picture') }}', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    $('#profile_picture_show').attr('src', e.target.result);
                                } else {
                                    // Handle error case
                                }
                            })
                            .catch(error => {
                                console.error('Error uploading picture:', error);
                                // Handle error case
                            });
                    };
                    reader.readAsDataURL(file);
                }
            });

        });
    </script>
@endsection
