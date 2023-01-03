@extends('layouts.app')

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/user.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('js/select2topics.js') }}"> </script>
@endsection

@section('title', "- Create Article")

{{-- ------------------------------------------------------ --}}
@section('content')

    <div class="article-container container-fluid">

        <div class="d-flex flex-row my-2 h-100">

            <div class="articleInfoContainer d-flex flex-column mb-0 p-3 pe-5 h-100">

                <form name="article-form" method="POST" action="{{ route('createArticle') }}" class="flex-row h-100" enctype="multipart/form-data">
                    @csrf

                    <div class="flex-row">
                        <label for="title">{{ "Article Title" }}</label>
                        <h3 class="m-0"> 
                            <input type="text" required minlength="3" maxlength="100" class="h-100"
                                id="title" name="title" placeholder="Insert Title" value="{{ old('title') }}">
                        </h3>
                        @if ($errors->has('title'))
                            <div class="alert alert-danger mt-2 mb-0 p-0 w-50 text-center" role="alert">
                                <p class="mb-0">{{ $errors->first('title') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="flex-row mt-3 mb-5 pe-3"> 
                        <label for="topics">{{ "Article Topics" }}</label>

                        <select required id="topics" name="topics[]" multiple>
                            @foreach($topics as $topic)
                                <option value="{{$topic['id']}}"
                                    @if (old('topics') && in_array($topic['id'], old('topics')))
                                        selected
                                    @endif
                                >
                                    {{ $topic['id'] }} -> {{ $topic['subject'] }}
                                </option>
                            @endforeach
                        </select>

                        @if ($errors->has('topics'))
                            <div class="alert alert-danger mt-2 mb-0 p-0 w-50 text-center" role="alert">
                                <p class="mb-0">{{ $errors->first('topics') }}</p>
                            </div>
                        @endif
                    </div>
      
                    <div class="flex-row h-100">
                        <label for="body">{{ "Article Body" }}</label>
                        <textarea id="body" name="body" minlength="10" rows="15" class="h-100"
                            placeholder="Insert Body">{{ old('body') }}</textarea>

                        @if ($errors->has('body'))
                            <div class="alert alert-danger mt-2 mb-0 p-0 w-50 text-center" role="alert">
                                <p class="mb-0">{{ $errors->first('body') }}</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary px-4">Create Article</button>
                        <button type="button" class="btn btn-secondary px-4 ms-4" onclick="goBack()" >Go Back</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection
