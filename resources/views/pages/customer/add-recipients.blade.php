@section('style')
    <style type="text/css">
        .recipient-form {
            position: relative;
            max-width: 820px;
            padding-top: 1.5rem;
        }
        .recipient-form .recipient-country-field {
            max-width: 520px;
            margin-bottom: 2rem;
        }
        .recipient-form .admin-heading {
            margin: 1.75rem 0 1rem !important;
            padding: 0;
            border: 0;
            font-size: 1.1rem;
        }
        .recipient-form .form-group {
            margin-bottom: 1rem;
        }
        .recipient-form .recipient-submit {
            padding-top: .75rem;
        }
        @media (max-width: 767px) {
            .recipient-form {
                padding-top: 1rem;
            }
            .recipient-form .pt-m {
                padding-top: 0;
            }
            .recipient-form .recipient-submit .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@extends('layouts.customer')

@section('content')
    <div class="col-lg-9" ng-controller="addRecipientsCtrl">
        <div class="profile-content">
            <h3 class="admin-heading">{{ translate(315) }}</h3>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    @livewire('add-recipient', ['countries' => $countries, 'currencies' => $currencies])
                </div>
            </div>
        </div>
    </div>
@endsection
