@extends('layouts.hometemplate')

@section('content')
    <div class="container">
        <form action="/profile/{{$user->id}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')
            <div class="row card p-5">
                <div class="col-8 offset-2">
                    <div class="row">
                        <h1>Edit Profile</h1>
                    </div>
                    <div class="form-group row">
                        <label for="artistname" class="col-md-4 col-form-label">Artist Name</label>

                        <input id="artistname" type="text"
                               class="form-control @error('artistname') is-invalid @enderror"
                               name="artistname"
                               value="{{ $user->profile->artistname ?? '' }}"
                               required autocomplete="artistname" autofocus>

                        @error('artistname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">Title</label>

                        <input id="title" type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               name="title"
                               value="{{ $user->profile->title ?? '' }}"
                               required autocomplete="title" autofocus>

                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label">Description</label>

                        <input id="description" type="text"
                               class="form-control @error('description') is-invalid @enderror"
                               name="description"
                               value="{{ $user->profile->description ?? ''}}"
                               required autocomplete="description" autofocus>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="url" class="col-md-4 col-form-label">URL</label>

                        <input id="url" type="text"
                               class="form-control @error('url') is-invalid @enderror"
                               name="url"
                               value="{{ $user->profile->url ?? '' }}"
                               required autocomplete="url" autofocus>

                        @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row">
                        <label for="image" class="col-md-4 col-form-label">Profile picture</label>
                    </div>
                    <input type="file" , class="file-control-file" id="image" name="image">
                    @error('image')
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="row">
                        <label for="banner" class="col-md-4 col-form-label">Banner picture</label>
                    </div>
                    <input type="file" , class="file-control-file" id="banner" name="banner">
                    @error('banner')
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="row pt-4">
                        <button class="btn btn-primary">Update profile</button>
                    </div>
                </div>

            </div>

        </form>
    </div>

@endsection
