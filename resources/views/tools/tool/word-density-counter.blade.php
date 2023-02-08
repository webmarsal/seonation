@section('site_title', formatTitle([__('Word density counter'), __('Tool'), config('settings.title')]))

@section('head_content')

@endsection

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('Word density counter') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Word density counter') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.word_density_counter') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-content">{{ __('Content') }}</label>
                <textarea name="content" id="i-content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}">{{ $content ?? (old('content') ?? '') }}</textarea>
                @if ($errors->has('content'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('content') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row mx-n2">
                <div class="col px-2">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Count') }}</button>
                </div>
                <div class="col-auto px-2">
                    <a href="{{ route('tools.word_density_counter') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($results))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col">
                    <div class="font-weight-medium py-1">{{ __('Results') }}</div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(empty($results))
                {{ __('No results found.') }}
            @else
                <div class="list-group list-group-flush my-n3">
                    <div class="list-group-item px-0 text-muted">
                        <div class="row">
                            <div class="col-12 col-lg-6 text-truncate">
                                {{ __('Keyword') }}
                            </div>

                            <div class="col-12 col-lg-3 text-truncate">
                                {{ __('Number') }}
                            </div>

                            <div class="col-12 col-lg-3 text-truncate">
                                {{ __('Density') }}
                            </div>
                        </div>
                    </div>

                    @foreach($results as $keyword => $count)
                        <div class="list-group-item px-0">
                            <div class="row">
                                <div class="col-12 col-lg-6 text-truncate">
                                    {{ $keyword }}
                                </div>

                                <div class="col-12 col-lg-3 text-truncate">
                                    {{ $count }}
                                </div>

                                <div class="col-12 col-lg-3 text-truncate">
                                    {{ number_format((($count / $total) * 100), 2, __('.'), __(',')) }}%
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif

@include('tools.related')
