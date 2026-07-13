@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white p-5 table-responsive">
                    <h1 class="mb-5">Utilisateurs actuellement connectés</h1>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <i class="fa fa-paperclip"></i>
                                </th>
                                <th>Identité</th>
                                <th>Vue le:</th>
                                <th>Navigateurs:</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sessions as $session)
                                
                                @php
                                    $customer = $session->customer
                                @endphp

                                <tr>
                                    <td class="text-center">
                                        <x-customer-avatar size="50" src="{{ asset_avatar($customer->image) }}" />
                                    </td>
                                    <td>
                                        <span class="d-block">{{ $customer->fullname() }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block font-weight-bold text-success">{{ dateFormat($session->last_seen_at) }}</span>
                                        <span class="d-block font-weight-bold" style="font-size: 14px;">{{ dateFormat($session->last_seen_at, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">
                                            <span class="badge bg-info text-white">{{ $session->ip_address }}</span>
                                        </span>
                                        <span class="d-block">{{ $session->user_agent }}</span>
                                    </td>
                                    <td>
                                        <form class="confirm-action" data-message="Êtes-vous certains de vouloir déconnecté ce client ?" action="{{ routeWithLocale('admin.delete_sessions.post') }}" method="post">
                                            @csrf
                                            
                                            <input type="hidden" name="customer_id" value="{{ $session->customer->id }}">
                                            <input type="hidden" name="session_id" value="{{ $session->id }}">
                                            <button type="submit" class="btn font-weight-bold btn-dark btn-xs">
                                                <i class="fa fa-power-off mr-1"></i>
                                                <span>Déconnecté</span>
                                            </button>
                                        </form>
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
                    <x-paginator :items=$sessions />
                </div>
            </div>
        </div>
    </section>
@endsection