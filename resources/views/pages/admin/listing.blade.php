@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white p-4 table-responsive">
                    <div class="alert alert-danger font-weight-bold">
                        <p class="m-0 text-center">Lorsque vous supprimer un admin qui possède des clients, ses clients deviennent automatiquement les vôtres.</p>
                    </div>
                    <h2 class="mb-5 d-flex flex-wrap justify-content-between">
                        <span>
                            <span class="badge badge-info">{{ $adminCount }}</span>
                            <span>Liste d'administrateurs</span>
                        </span>
                        <span>

                            @if ( !admin()->isSuper() )
                                <button type="button" disabled class="btn btn-light font-weight-bold">
                                    <i class="fa fa-plus"></i>
                                    <span>Créer un admin</span>
                                </button>
                            @else
                                <a href="javascript:;" class="btn btn-success font-weight-bold" data-toggle="modal" data-target="#my-modalBox__add_admin">
                                    <i class="fa fa-plus"></i>
                                    <span>Créer un admin</span>
                                </a>
                            @endif
                            
                        </span>
                    </h2>

                    <div class="modal fade text-left" id="my-modalBox__add_admin" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header text-center">
                                    <h3 class="modal-title pm-0" id="myModalLabel">Ajouter un admin</h3>
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Fermé</button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <form class="p-4" action="{{ routeWithLocale('admin.add_admin.post') }}" method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-form-input name="name" label="Nom de banquier" placeholder="John Doe" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-form-input name="username" label="Nom d'utilisateur" placeholder="admin" />
                                            </div>
                                        </div>

                                        <x-form-input type="email" name="email" label="Email" placeholder="@" />
                                        <x-form-input name="password" label="Mot de passe" />

                                        <label class="form-label mb-0" for="">Super Admin:</label>
                                        <p class="m-0 text-muted">Lorsque un admin à le rôle de <span class="badge badge-danger">super admin</span>, il a la possibilité de créer d'autres admin et d'en supprimer.</p>
                                        <x-admin-custom-switch checked="false" />

                                        <div class="form-group">
                                            <button type="submit" name="submit" class="btn font-weight-bold btn-xs btn-success">
                                                <i class="fa fa-check-circle"></i> 
                                                <span>Créer un admin</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Actuel</th>
                                <th>Informations</th>
                                <th>Clients</th>
                                <th>Inscrit le:</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admins as $key => $admin)
                                
                                <tr>
                                    <td @class([
                                        'text-success' => ($admin->id == admin()->id),
                                        'text-muted' => ($admin->id <> admin()->id)
                                    ])>
                                        <i class="fa fa-clock fa-2x"></i>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ $admin->name }}</span>
                                        <span class="d-block font-weight-bold">
                                            {{ $admin->username }}
                                            @if ( $admin->isSuper() )
                                                <span class="d-inline-block text-warning">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </span>
                                            @endif
                                        </span>
                                        <span class="d-block">{{ $admin->email }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $admin->customers()->count() }} Clients</span>
                                    </td>
                                    <td>
                                        <span>{{ dateFormat($admin->created_at) }}</span><br>
                                        <span>{{ dateFormat($admin->created_at,2) }}</span>
                                    </td>
                                    <td>
                                        @if ( $admin->isSuper() || !admin()->isSuper() )
                                            <button type="button" disabled class="btn btn-light font-weight-bold">
                                                <i class="fa fa-remove"></i>
                                                <span>supprimer</span>
                                            </button>
                                        @else
                                            <form class="confirm-action d-inline-block" action="{{ routeWithLocale('admin.delete_admin.post') }}" method="post" data-message="Êtes-vous certain de vouloir supprimer cet administrateur ?">
                                                @csrf
                                                <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                                                <button type="submit" class="btn btn-dark font-weight-bold">
                                                    <i class="fa fa-remove"></i>
                                                    <span>supprimer</span>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                
                                <tr>
                                    <td colspan="5">
                                        <x-show-empty-data-message />
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="col-12 bg-light p-3 mt-2">
                    <x-paginator :items=$admins />
                </div>
            </div>
        </div>
    </section>
@endsection