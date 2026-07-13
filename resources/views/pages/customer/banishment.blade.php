@extends('pages.customer.identity-verify.layout')

@section('content')
    <div class="col-lg-9">
        <div class="bg-white p-4">
            <h2 class="admin-heading shadow-none bg-white">{{ translate(707) }}</h2>

            <div class="p-4">
                <div>
                    <p>{{ translate('709v1') }}</p>
                    <p>{!! translate('709v2', false, $customer->admin->email) !!}</p>
                    <p>{{ translate('709v3') }}</p>
                    <p>{{ translate('709v4') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection