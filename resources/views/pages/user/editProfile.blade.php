@extends('layouts.app')

@php
$isOpen = $errors->has('password');
@endphp

@section('title', "- Edit Profile")

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/user.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('js/select2topics.js') }}"> </script>
@endsection

@section('content')
    <section id="editProfileContainer">
        <form name="profileForm" method="POST" enctype="multipart/form-data"
            action="{{ route('editProfile', ['id' => $user['id']]) }}" class="container-fluid py-3" id="editProfileForm">
            @method('put')
            @csrf

            <div class="row w-100 " id="editAvatarContainer">
                <label class="h2 py-0 my-0">Avatar</label>
                <div id="avatarPreviewContainer" class="d-flex align-items-center">
                </div>
            </div>

            <div class="row w-100 mt-3">
                <div class="col-12 col-lg-8">
                    <div class="row w-100">
                        <div class="col-6">
                            <label class="h2 pb-3 my-0" for="nameInput">Username</label>
                            <input type="text" required value="{{ old('username') ? old('username') : $user['username'] }}"
                                class="h3 editInputs w-75" id="nameInput" name='username' />
                            @if ($errors->has('username'))
                                <div class="w-50 py-1 text-danger ">
                                    <p class="">{{ $errors->first('username') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-6">
                            <label class="h2 pb-3 my-0" for="date_of_birth_Input">Birth Date</label>
                            <input name="date_of_birth" class="h3 editInputs py-4 px-2 px-lg-3" type="text" placeholder="Enter Date of Birth" required
                                value="{{ old('date_of_birth') ? old('date_of_birth') : $date_of_birth }}">
                            <input name="date_of_birth" type="hidden" value="{{ old('date_of_birth') }}" id="date_of_birth_Input">
                            @if ($errors->has('date_of_birth'))
                                <div class="text-danger w-100 py-1">
                                    <p class="">{{ $errors->first('date_of_birth') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row w-100 mt-2 d-flex justify-content-center">
                <button type="submit" class="w-auto text-center px-5 btn-primary">Edit Profile</button>
            </div>
        </form>

        <div class="container-fluid py-3 w-75 mt-5 pt-5 border-top border-light">
            <div class="d-flex position-relative mb-3">
                <a class="h1 w-100 text-darkPurple" href="#advancedContainer" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-contols="advancedContainer">Advanced
                    Settings</a>
                <i class="fa fa-caret-down fa-1x position-absolute pe-none caretDown"></i>
            </div>

            <div <?php if ($isOpen) { echo 'class="colapse show"'; } else { echo 'class="collapse"'; } ?> id="advancedContainer">
                <form name="passForm" method="POST" action="{{ route('editProfile', ['id' => $user['id']]) }}">
                    @method('put')
                    @csrf
                    @if ($errors->has('password'))
                        <div class="w-50 py-1 text-danger">
                            <p class="">Invalid Password</p>
                        </div>
                    @endif
                    <label for="currPassInput" class="form-label mt-4">Change Password</label>
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="me-5">
                            <div class="form-text">Current Password</div>
                            <input type="password" required class="w-auto h4 editInputs" id="currPassInput" name='password'
                                placeholder="Current Password" />
                        </div>
                        <div class="me-5">
                            <div class="form-text">New Password</div>
                            <input type="password" required class="w-auto h4 editInputs" id="newPassInput"
                                name='new_password' placeholder="New Password" onkeyup="checkPass('#newPassInput')" />
                        </div>
                        <div class="me-5">
                            <div class="form-text">Confirm Password</div>
                            <input type="password" required name="new_password_confirmation" class="w-auto h4 editInputs"
                                id="newPassInput-confirm" placeholder="Confirm Password"
                                onkeyup="checkPass('#newPassInput')">
                            <span class="ms-2" id="matchingPass"></span>
                        </div>
                        <button class="mb-4 btn btn-primary px-5" type="submit">Change</button>
                    </div>
                    @if ($errors->has('new_password'))
                        <div class="w-50 py-1 text-danger ">
                            <p class="">{{ $errors->first('new_password') }}</p>
                        </div>
                    @endif
                </form>

                <form name="emailForm" method="POST" action="{{ route('editProfile', ['id' => $user['id']]) }}"
                    class="mt-3" autocomplete="off">
                    @method('put')
                    @csrf
                    <label for="emailPassInput" class="form-label mt-4">Change Email</label>
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="me-5">
                            <div class="form-text">Current Password</div>
                            <input type="password" autocomplete="new-password" required class="w-auto h4 editInputs"
                                id="emailPassInput" name='password' placeholder="Current Password" />
                        </div>
                        <div class="me-5">
                            <div class="form-text">New Email</div>
                            <input type="email" required class="w-auto h4 editInputs" id="emailInput" name='email'
                                placeholder="New Email" value="{{ old('email') }}" />
                        </div>
                        <button class="mb-4 btn btn-primary px-5" type="submit">Change</button>
                    </div>
                    @if ($errors->has('email'))
                        <div class="w-50 py-1 text-danger ">
                            <p class="">{{ $errors->first('email') }}</p>
                        </div>
                    @endif
                </form>

                <form name="deleteForm" method="POST" action="{{ route('deleteUser', ['id' => $user['id']]) }}"
                    class="mt-3" autocomplete="off">
                    @method('delete')
                    @csrf
                    <label for="delPassInput" class="form-label mt-4">Delete Account</label>
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="me-5">
                            <div class="form-text">Current Password</div>
                            <input type="password" autocomplete="new-password" required class="w-auto h4 editInputs"
                                id="delPassInput" name='password' placeholder="Current Password" />
                        </div>
                        <div class="mt-5">
                            <button id="delAccButton" class="btn btn-danger px-5" type="button"
                                onclick="confirmAction('#delAccButton', () => document.deleteForm.submit())" 
                            >
                                Delete Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
