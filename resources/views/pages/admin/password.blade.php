@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-5 bg-white">
                    <h1 class="mb-5">Modifier votre mot de passe:</h1>
                    <form action="" method="post" class="row">
                        @csrf
                        
                        <div class="col-xs-12 col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required-field">{{ translate(384) }} : </label>
                                        <input type="password" class="form-control" name="new_password" autocapitalize="none" autocomplete="nope" autocorrect="off" minlength="8" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required-field">{{ translate(385) }} : </label>
                                        <input type="password" class="form-control" name="new_password_confirmation" autocapitalize="none" autocomplete="nope" autocorrect="off" minlength="8" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label required-field">{{ translate(386) }} : </label>
                                <input type="password" class="form-control" name="old_password" autocapitalize="none" autocomplete="nope" autocorrect="off" minlength="8" required>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-12 mt-5">
                            <button type="submit" class="btn font-weight-bold btn-primary">
                                <i class="fa fa-check-circle"></i>
                                <span>Soumettre le formulaire</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection