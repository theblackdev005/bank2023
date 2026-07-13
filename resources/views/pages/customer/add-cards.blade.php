@extends('layouts.customer')

@section('content')
    <div class="col-lg-9">
        <div class="profile-content">
            <h3 class="admin-heading">{{ translate(608) }}</h3>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    
                    <form action="{{ routeWithLocale('customer.add_cards.post') }}" method="post" class="pt-4 form bg-offwhite">
                        @csrf

                        <div class="form-group">
                            <label for="" class="form__label">{{ translate(614) }}</label>
                            <input type="text" name="card_owner" class="form-control" placeholder="Alan Smith" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="form__label">{{ translate(611) }}</label>
                            <div class="input-group mb-2">
                                <input type="tel" id="cc_number" name="number" class="form-control" placeholder="0000 0000 0000 0000" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-white" data-root-img-uri="{{ asset_img('../banking/images/card_brand') }}/" id="card_brand__img"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <div class="form-group">
                                    <label for="card-expiry-date" class="form__label">{{ translate(612) }}</label>
                                    <input id="card-expiry-date" maxlength="7" minlength="7" type="tel" name="expire" class="form-control" placeholder="MM/YYYY" required>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form__label">{{ translate(613) }}</label>
                                    <input type="tel" name="cvv" class="form-control" placeholder="CVV" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" value="unknow-card-brand" name="brand_name" id="card_brand_name" class="hidden">
                            <button type="submit" class="btn btn-success btn-lg full-m">{{ translate(609) }}</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection