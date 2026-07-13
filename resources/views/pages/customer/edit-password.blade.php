@extends('layouts.customer')

@section('content')
    <div class="col-lg-9">
        <div class="profile-content">
            <h3 class="admin-heading">{{ translate(383) }}</h3>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    
                    <form action="" method="post" class="form pt-4 bg-offwhite">
                        @csrf
                        
                        <div class="form-group">
                            <label>{{ translate(384) }}</label>
                            <input type="password" autocapitalize="none" autocomplete="nope" autocorrect="off" name="new_password" class="form-control input-lg" required>
                        </div>
                        <div class="form-group">
                            <label>{{ translate(385) }}</label>
                            <input type="password" autocapitalize="none" autocomplete="nope" autocorrect="off" name="new_password_confirmation" class="form-control input-lg" required>
                        </div>
                        <div class="form-group mt-5">
                            <label>{{ translate(386) }}</label>
                            <input type="password" autocapitalize="none" autocomplete="nope" autocorrect="off" name="old_password" class="form-control input-lg" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg full-m">{{ translate(387) }}</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection