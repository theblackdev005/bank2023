@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">

                <!-- MODAL UPDATE SMS API -->
                <div class="modal fade text-left" id="my-modalBox__cpanelapi" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header text-center">
                                <h3 class="modal-title pm-0" id="myModalLabel">Configuration de l'api cpanel</h3>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form class="p-4" action="{{ routeWithLocale('admin.manage_cpanelapi.post') }}" method="post">
                                    @csrf

                                    @foreach (['username', 'apikey', 'domain_name'] as $key)
                                        <div class="form-group mb-4">
                                            <div class="well">
                                                <label class="form-label m-0">{{ keyToName($key) }}</label>
                                                <input class="form-control" autocomplete="nope" name="{{ $key }}" value="{{ $cpanel_config ? $cpanel_config->$key : null }}">
                                            </div>
                                        </div>
                                    @endforeach

                                    <x-admin-custom-switch checked="{{ $cpanel_config && $cpanel_config->isEnabled() }}" />

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn font-weight-bold btn-xs btn-success">
                                            <i class="fa fa-check-circle"></i> 
                                            <span>Maj</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermé</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL UPDATE SMS API -->

                <!-- MODAL -->
                <div class="modal fade text-left" id="my-modalBox__create" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header text-center">
                                <h3 class="modal-title pm-0" id="myModalLabel">Créer un mail</h3>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form class="p-4" action="{{ routeWithLocale('admin.mail_pro.post') }}" method="POST" role="form">
                                    @csrf

                                    <div class="form-group">
                                        <label for="" class="form-label">Nom d'utilisateur du mail pro:</label>
                                        <p class="text-muted m-0 mb-2">Pour créer un mail <span class="badge badge-info">root@mondomaine.com</span>, mettez juste <span class="badge badge-success">root</span></p>
                                        <input type="text" autocomplete="nope" class="form-control" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Mot de passe du mail pro :</label>
                                        <input type="text" autocomplete="nope" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success font-weight-bold">
                                            <i class="fa fa-check-circle"></i>
                                            <span>Créer le mail</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermé</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL -->

                <div class="col-md-12 bg-white p-4 table-responsive">

                    <div class="alert alert-warning">
                        <p class="m-0">Pour mettre à jour vos configurations cpanel, veuillez cliquer ici : <a href="javascript:;" class="btn btn-sm btn-primary m-0" data-toggle="modal" data-target="#my-modalBox__cpanelapi">Mettre à jour sa config</a></p>
                    </div>

                    <h1 class="mb-5 d-flex flex-wrap justify-content-between">
                        <span>Liste des mails professionnels</span>
                        <span>
                            <a href="javascript:;" class="btn m-0 d-inline-block btn-success font-weight-bold" data-toggle="modal" data-target="#my-modalBox__create">
                                <i class="fa fa-envelope"></i>
                                <span>Créer un mail</span>
                            </a>
                        </span>
                    </h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Liens</th>
                                <th>Nom d'utilisateur</th>
                                <th>Mot de passe</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mails as $mail)
                                
                                <tr>
                                    <td>
                                        <span class="font-weight-bold">
                                            <a target="_blank" href="{{ $mail->webmail_url }}">{{ $mail->webmail_url }}</a>
                                        </span>
                                    </td>
                                    <td>
                                        <span>{{ $mail->username }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $mail->password }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ dateFormat($mail->created_at) }}</strong><br>
                                        <span>{{ dateFormat($mail->created_at,2) }}</span>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4">
                                        <x-show-empty-data-message />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>
@endsection