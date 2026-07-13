@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">

                <!-- MODAL UPDATE SMS API -->
                <div class="modal fade text-left" id="my-modalBox__smsconfig" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header text-center">
                                <h3 class="modal-title pm-0" id="myModalLabel">Les informations de l'api sms</h3>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form class="p-4" action="{{ routeWithLocale('admin.manage_smsapi.post') }}" method="post">
                                    @csrf

                                    @foreach (['username', 'password', 'sender'] as $key)
                                        <div class="form-group mb-4">
                                            <div class="well">
                                                <label class="form-label m-0">{{ keyToName($key) }}</label>
                                                <input class="form-control" autocomplete="nope" name="{{ $key }}" value="{{ $sms_api_config ? $sms_api_config->$key : null }}">
                                            </div>
                                        </div>
                                    @endforeach

                                    <x-admin-custom-switch checked="{{ $sms_api_config && $sms_api_config->isEnabled() }}" />

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

                <!-- MODAL SEND SMS -->
                <div class="modal fade text-left" id="my-modalBox__create" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header text-center">
                                <h3 class="modal-title pm-0" id="myModalLabel">Envoyer un sms</h3>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form class="p-4" action="{{ routeWithLocale('admin.send_sms.post') }}" method="POST" role="form">
                                    @csrf

                                    <div class="form-group">
                                        <label class="form-label required-field">Nom et prénom (s) du récepteur :</label>
                                        <select class="form-control" name="customer_id" required>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" @selected_if(old('customer_id') == $customer->id)>{{ $customer->fullname() }} - {{ sanitizePhoneNumber($customer->phone_number) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required-field">Contenu du message :</label>
                                        <textarea name="message" class="form-control" autocapitalize="none" autocomplete="nope" autocorrect="off"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn font-weight-bold btn-success">
                                            <span class="fa fa-check-circle"></span>
                                            <span>Envoyer le message</span>
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
                <!-- MODAL SEND SMS -->

                <div class="col-md-12 bg-white p-4 table-responsive">

                    <div class="alert alert-info">
                        <p class="m-0">Pour mettre à jour vos configurations sms, veuillez cliquer ici : <a href="javascript:;" class="btn btn-sm btn-primary m-0" data-toggle="modal" data-target="#my-modalBox__smsconfig">Mettre à jour sa config</a></p>
                    </div>

                    <h1 class="mb-5 d-flex flex-wrap justify-content-between">
                        <span>Historique des sms</span>
                        <span>
                            <a href="javascript:;" class="btn m-0 btn-success font-weight-bold" data-toggle="modal" data-target="#my-modalBox__create">
                                <i class="fa fa-send"></i>
                                <span>Envoyer</span>
                            </a>
                        </span>
                    </h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Expéditeur</th>
                                <th>Récepteur</th>
                                <th>statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sms as $smsOnce)
                                
                                <tr>
                                    <td>
                                        <strong>#{{ $smsOnce->external_id }}</strong>
                                    </td>
                                    <td>
                                        <span class="d-block font-weight-bold">
                                            <a href="{{ routeWithLocale('admin.edit_customer', $smsOnce->customer->username) }}">{{ $smsOnce->customer->fullname() }}</a>
                                        </span>
                                        <span class="d-block">{{ $smsOnce->customer->email }}</span>
                                        <span class="d-block">{{ $smsOnce->customer->country->name }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block font-weight-bold">{{ $smsOnce->phone_number }}</span>
                                        <span class="d-block">{{ $smsOnce->message }}</span>
                                    </td>
                                    <td>
                                        {!! messageDeliveryStatus($smsOnce->status) !!}
                                    </td>
                                    <td>
                                        <span>{{ dateFormat($smsOnce->created_at) }}</span><br>
                                        <span>{{ dateFormat($smsOnce->created_at,2) }}</span>
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