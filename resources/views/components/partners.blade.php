<div class="container">
    <div class="row d-flex">
        <div class="col-12">
            <div class="row d-flex py-5 px-2">
                <div class="col-lg-5 d-flex justify-content-between align-items-start bg-white py-4">
                    <div class="row bg-white px-4 flex-wrap rounded">
                        @foreach (partners() as $partner)
                            <div class="col-6 col-md-6 d-block py-2">
                                <img src="{{ asset_img( 'partners/' . $partner ) }}" alt="" style="height: 50px;">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-7 d-flex">
                    <div class="partners-section-horizontal-title-block px-4">
                        <h4 class="title pm-0 font-weight-bold">{{ translate(172) }}</h4>
                        <p class="text-wite">{{ translate(762) }}</p>
                        <a href="{{ routeWithLocale('guest.register') }}" class="btn btn-theme">{{ translate(281) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>