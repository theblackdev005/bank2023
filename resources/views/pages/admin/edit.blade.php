@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">        
            <div class="row">
                <div class="col-md-12 bg-white p-5">
                    <h1 class="mb-5">Modifier vos données personnelles:</h1>
                    <form action="" method="post" class="row" data-message="Êtes-vous certains de vouloir modifier vos données ?">
                        @csrf
                        
                        <div class="col-12 col-lg-7 pb-5">
                            <x-form-input label="Nom de banquier" name="name" value="{{ $admin->name }}" />
                            <div class="form-group pt-3">
                                <label class="form-label m-0 required-field">Email de contact : </label>
                                <p class="text-muted m-0 mb-2">Cette adresse email est utilisée pour vous envoyer les notifications de vos clients en temps réels.</p>
                                <input type="email" class="form-control" name="email" value="{{ $admin->email }}" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-md-12">
                            <button type="submit" class="btn font-weight-bold btn-success">
                                <i class="fa fa-check-circle"></i> 
                                <span>Soumettre vos changements</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection