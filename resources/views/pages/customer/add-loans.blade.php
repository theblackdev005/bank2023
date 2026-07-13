@extends('layouts.customer')

@section('content')
    <div class="col-lg-9">
        <div class="profile-content">
            <h3 class="admin-heading">{{ translate(339) }}</h3>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    @livewire('customer-request-loan-form', compact('customer'))
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <h3>{{ translate(631) }}</h3>
                                <p class="text-muted">{{ translate(352) }}</p>
                            </div>

                            <div class="form-group pt- mb-2">
                                <h5>1. {{ translate(357) }}</h5>
                                <p>{{ translate(358) }}</p>
                            </div>
                            <div class="form-group mb-2 pt-1 pb-1 text-muted">
                                <h5>2. {{ translate(359) }}</h5>
                                <p>{{ translate(360) }}</p>
                            </div>
                            <div class="form-group pt-1 pb-1 text-muted">
                                <h5>3. {{ translate(361) }}</h5>
                                <p>{{ translate(362) }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection