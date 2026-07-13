@section('style')
    <style type="text/css">
        form {
            position: relative;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
    
@endsection

@extends('layouts.customer')

@section('content')
    <div class="col-lg-9" ng-controller="addRecipientsCtrl">
        <div class="profile-content">
            <h3 class="admin-heading">{{ translate(315) }} <a class="fa fa-info-circle" data-toggle="tooltip" data-html="true" data-placement="top" title='
                    <div class="p-2">
                        <div class="">
                            <h5 class="pm-0 text-white mb-2">{{ translate(326) }}</h5>
                            <p class="text-muted">{{ translate(327) }}</p>
                            <h5 class="pm-0 text-white mb-2">{{ translate(328) }}</h5>
                            <p class="text-muted"> {{ translate(329) }}</p>
                        </div>
                    </div>
                '></a>
            </h3>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    @livewire('add-recipient', ['countries' => $countries, 'currencies' => $currencies])
                    
                    <?php
                        $data = [];
                        // foreach (scandir(RECIPIENTS_FORMS_DIR) as $key => $value) {
                        //     $value = trim($value, ".");
                        //     if (empty($value) || is_dir(RECIPIENTS_FORMS_DIR . $value)) {
                        //         continue;
                        //     }
                        //     $data[] = $value;
                        // }

                        // foreach ($data as $file) {
                        //     require_once RECIPIENTS_FORMS_DIR . $file;
                        // }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    
@endsection