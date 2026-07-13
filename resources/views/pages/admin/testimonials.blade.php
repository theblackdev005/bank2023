@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white p-5">

                    <h2 class="mb-5 d-flex flex-wrap justify-content-between">
                        <span>Liste des témoignages</span>
                        <span>
                            <a class="btn btn-success text-white btn-xs font-weight-bold" data-toggle="modal" data-target="#my-modalBox__testimonial">
                                <i class="fa fa-plus"></i>
                                <span>Ajouter</span>
                            </a>
                        </span>
                    </h2>

                    <!-- MODAL -->
                    <div class="modal fade text-left" id="my-modalBox__testimonial" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {{-- Modal Header --}}
                                <div class="modal-header text-center">
                                    <h4 class="modal-title pm-0" id="myModalLabel">Ajouter un témoignage</h4>
                                </div>
                                {{-- Modal Header --}}
                                
                                {{-- Modal Body --}}
                                <div class="modal-body px-4 pt-2 pb-1">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-xs-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-form-input name="name" label="Nom"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <x-form-select 
                                                        name="country_id" 
                                                        :options=$countries 
                                                        selectLabel="{{ translate(188) }}" 
                                                        optionLabelKey="name" 
                                                        optionValueKey="id" />
                                                </div>
                                            </div>
                                        </div>

                                        <x-form-input name="title" label="Titre"/>
                                        <x-form-textarea name="message" label="Contenu du témoignage"/>
                                        
                                        <div class="form-group">
                                            <label class="form-label required-field">Note (sur 5) :</label>
                                            <select class="form-control" name="note" required>
                                                <option value="">Note ( exemple 5.1 )</option>

                                                @php
                                                    $k=0;
                                                @endphp

                                                @while ($k <= 5)
                                                    <option value="{{ $k }}">{{ $k }}</option>
                                                    
                                                    @php
                                                        $k = $k+0.1
                                                    @endphp
                                                @endwhile
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label required-field">Photo de profile :</label>
                                            <input type="file" name="image" class="form-control-file">
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn font-weight-bold btn-success">
                                                <i class="fa fa-check-circle"></i>
                                                <span>Ajouter le témoignage</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                {{-- Modal Body --}}

                                {{-- Modal Footer --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-xs font-weight-bold" data-dismiss="modal">Annuler</button>
                                </div>
                                {{-- Modal Footer --}}
                            </div>
                        </div>
                    </div>
                    <!-- MODAL -->

                    <div class="row d-flex">
                        @forelse ($testimonials as $testimonial)
                            
                            <div class="col-12 col-md-4">
                                <div class="card shadow-md bg-light mb-4">
                                    <div class="card-body">
                                        <blockquote>
                                            <h5 class="d-flex m-0 mb-2 align-items-center">
                                                <x-customer-avatar size="50" src="{{ asset_avatar($testimonial->image, 'uploads/testimonials/') }}" />
                                                <div class="ml-2">
                                                    <span class="text-small">{{ $testimonial->title }}</span><br>
                                                    <span class="small">
                                                        <a href="{{ routeWithLocale('admin.delete_testimonials', $testimonial->id) }}" class="badge confirm-action badge-danger font-weight-bold" data-message="Êtes-vous certain de vouloir supprimer ce témoignage ?">
                                                            <i class="fa fa-remove"></i>
                                                            <span>Suppr.</span>
                                                        </a>
                                                        <cite data-toggle="tooltip" data-placement="top" title="{{ $testimonial->country->name }}" class="badge badge-secondary font-weight-bold">{{ $testimonial->country->iso }}</cite>
                                                    </span>
                                                </div>
                                            </h5>
                                            <p class="m-0 text-muted">{{ text_wrap($testimonial->message, 100) }}</p>
                                            <footer class="blockquote-footer font-weight-bold p-1">
                                                <span>{{ $testimonial->name }}</span>
                                            </footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <x-show-empty-data-message />
                        @endforelse

                    </div>
                </div>

                <div class="col-12 bg-light p-3 mt-2">
                    <x-paginator :items=$testimonials />
                </div>
            </div>
        </div>
    </section>
@endsection