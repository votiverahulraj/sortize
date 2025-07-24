<div class="row align-items-center mb-3">
    <div class="col-sm-6">
        <h3 class="font-weight-bold m-0 ">{{ $title ?? 'Page Title' }}</h3>
    </div>
    <div class="col-sm-6 text-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end m-0">

                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                {{-- Loop other breadcrumbs --}}
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item {{ empty($breadcrumb['url']) ? 'active' : '' }}">
                        @if (!empty($breadcrumb['url']))
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                        @else
                            {{ $breadcrumb['label'] }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>
</div>
