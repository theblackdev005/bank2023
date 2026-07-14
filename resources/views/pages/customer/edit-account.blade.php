@extends('layouts.customer')

@section('content')
    <div class="col-lg-9">
        <div class="profile-content">
            <h3 class="admin-heading">{{ translate(330) }}</h3>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    
                    <form action="" method="post" enctype="multipart/form-data" autocomplete="nope" class="form py-3 bg-offwhite">
                        @csrf

                        <div class="form-group">
                            <label>{{ translate(655) }}</label>
                            <div class="custom-file mb-5">
                                <label class="custom-file-label">{{ translate(656) }}</label>
                                <input type="file" name="image" class="custom-file-input">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{ translate(331) }}</label>
                                    <input type="email" value="{{ $customer->email }}" autocapitalize="none" autocomplete="nope" autocorrect="off" name="email" class="form-control input-lg">
                                </div>
                                <div class="col-md-6 ">
                                    <label>{{ translate(332) }}</label>
                                    <select class="form-control input-lg" name="gender" required>
                                        @foreach (genders() as $gender)
                                            <option value="{{ $gender }}"{{ ($customer->gender == $gender) ? ' selected="selected"' : '' }}>{{ translate($gender) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{ translate(333) }}</label>
                                    <input type="date" value="{{ dateFormat($customer->birthday, 1, "Y-m-d", null, false) }}" autocapitalize="none" autocomplete="nope" autocorrect="off" name="birthday" class="form-control input-lg">
                                </div>
                                <div class="col-md-6">
                                    <label>{{ translate(321) }}</label>
                                    <select name="currency_id" class="form-control input-lg">
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ ($currency->id == $customer->currency->id) ? " selected='selected'" : '' }}>{{ $currency->name }} {{ $currency->symbol ? "(". $currency->symbol .")" : null }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ translate(831) }}</label>
                            <p class="text-muted mb-2">{{ translate(833) }}</p>
                            <select name="language_id" class="form-control input-lg">
                                <option value=""></option>
                                @foreach ($languages as $lang)
                                    <option value="{{ $lang->id }}" {{ ($lang->id == optional($customer->language)->id) ? " selected='selected'" : '' }}>{{ $lang->name }} ( {{ $lang->iso }} )</option>
                                @endforeach
                            </select>
                        </div>

                        <x-form-phone-input label="{{ translate(334) }}" name="phone_number" value="{{ $customer->phone_number }}" />

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{ translate(320) }}</label>
                                    <select name="country_id" class="form-control input-lg">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ ($country->id == $customer->country->id) ? " selected='selected'" : '' }}>{{ $country->name }} ({{ $country->iso }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>{{ translate(335) }}</label>
                                    <input type="text" value="{{ $customer->city }}" autocapitalize="none" autocomplete="nope" autocorrect="off" name="city" class="form-control input-lg">
                                </div>
                                <div class="col-md-4">
                                    <label>{{ translate(336) }}</label>
                                    <input type="text" value="{{ $customer->address }}" autocapitalize="none" autocomplete="nope" autocorrect="off" name="address" class="form-control input-lg">
                                </div>
                            </div>
                        </div>

                        <div class="form-group pt-5">
                            <label class="required-field">{{ translate(337) }}</label>
                            <input type="password" autocapitalize="none" autocomplete="nope" autocorrect="off" name="password" class="form-control input-lg required" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg full-m">{{ translate(338) }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
