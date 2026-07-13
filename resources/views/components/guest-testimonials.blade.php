<section class="py-5 bg-light shadow-none"> 
    <div class="container">
        <div class="row bg-light">
            <div class="col-xs-12 col-md-12">
                <div class="mb-5">
                    <h2 class="font-weight-bold">{{ translate(202) }}</h2>
                    <p class="text-muted">{{ translate(310) }}</p>
                </div>
                <div class="row" data-masonry='{"percentPosition": true }'>
                    @php
                        $ctts='';
                    @endphp

                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-6 col-lg-4">
                            <div class="bg-white p-4 mb-4 rounded">
                                <div class="testimonial-inner">
                                    <div>

                                        @for ($i = 0; $i < 5; $i++)
                                            @php
                                                $c = ( intval($testimonial->note) > $i) ? "text-warning" : "text-theme-light";
                                            @endphp
                                            <span class="fa fa-star {{ $c }}"></span>
                                        @endfor

                                    </div>
                                    <p class="text-muted my-2">{{ $testimonial->message }}</p>
                                </div>
                                <div class="d-flex align-items-center pt-3">
                                    <div class="avatar">
                                        <x-customer-avatar size="50" src="{{ asset_avatar($testimonial->image, 'uploads/testimonials/') }}" />
                                    </div>
                                    <div class="pl-2" style="line-height: 20px;">
                                        <span class="text-theme d-block">{{ $testimonial->name }}</span>
                                        <span class="text-muted font-weight-normal font-italic d-block">{{ $testimonial->country->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            @if ( $show_pagination == 'true' )
                <div class="pt-3 col-12 col-md-12">
                    <x-paginator :items=$testimonials />
                </div>
            @endif
            
        </div>
    </div>
</section>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
@endsection