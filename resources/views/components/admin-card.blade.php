<a class="card shadow-md text-decoration-none" href="{{ $url }}">
    <div class="row justify-content-center">
        <div class="col-4 col-lg-3 d-flex">
            <div class="card-stat bg-{{ $alert_class }} w-100 h-100 d-flex justify-content-center align-items-center py-4 px-2">
                <strong class="fa fa-{{ $icon }} fa-2x text-white"></strong>
            </div>
        </div>
        <div class="col-8 col-lg-9 d-flex align-items-center">
            <div class="pr-1 py-2">
                <div>
                    @if ($count <> "false")
                        <span class="badge bg-light">
                            <h4 class="m-0 d-inline-block">{{ $count }}</h4>
                        </span>
                    @endif
                    <h4 class="card-title text-underline text-secondary d-inline-block m-0">{{ $title }}</h4>
                </div>

                @if ( !empty($description) )
                    <p class="text-muted pt-3 font-weight-bold">{{ $description }}</p>
                @endif

            </div>
        </div>
    </div>
</a>