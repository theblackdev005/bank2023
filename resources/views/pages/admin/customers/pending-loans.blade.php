@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white p-4 table-responsive">
                    
                    <h1 class="mb-5 d-flex flex-wrap justify-content-between">
                        <span>Demandes de prêts en attente</span>
                        <span>
                            <a href="javascript:;" class="btn m-0 btn-success font-weight-bold" data-toggle="modal" data-target="#my-modalBox__create">
                                <i class="fa fa-plus"></i>
                                <span>Ajouter</span>
                            </a>
                        </span>
                    </h1>

                    <!-- MODAL -->
                    <div class="modal fade text-left" id="my-modalBox__create" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header text-center">
                                    <h3 class="modal-title pm-0" id="myModalLabel">Demande de prêt</h3>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <form class="p-4" action="{{ routeWithLocale('admin.add_loan.post') }}" method="POST" role="form">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <label class="form-label required-field">{{ translate(182) }} :</label>
                                            <select class="form-control" name="customer_id" required>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" @selected_if(old('customer_id') == $customer->id)>{{ $customer->fullname() }} ( {{ $customer->currency->name }} )</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-form-input type="number" step="0.01" name="amount" label="{{ translate(353) }}"/>
                                        <x-form-input type="number" name="duration" label="{{ translate(354) }}"/>
                                        <x-form-textarea name="goal" label="{{ translate(355) }}"/>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success font-weight-bold">{{ translate(356) }}</button>
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
                    
                    <table class="table">
                        <thead>
                            <th>Clients</th>
                            <th>Montant</th>
                            <th>Objectif du prêt</th>
                            <th>Heure</th>
                            <th class="text-center">
                                <i class="fa fa-check-circle"></i>
                            </th>
                            <th class="text-center">
                                <i class="fa fa-remove"></i>
                            </th>
                        </thead>
                        <tbody>
                            @forelse ($loans as $loan)  

                                @php
                                    extract(loanCalculator([
                                        'amount'    => $loan->amount,
                                        'duration'  => $loan->duration,
                                    ]))
                                @endphp
                                
                                <tr>
                                    <td>{{ $loan->customer->fullname() }}</td>
                                    <td>{{ setCurrency($loan->currency, $loan->amount) }}</td>
                                    <td>
                                        <span class="d-block text-muted">{{ text_wrap($loan->goal, 50) }}</span>
                                    </td>
                                    <td>
                                        <span>{{ dateFormat($loan->created_at) }}</span><br>
                                        <span>{{ dateFormat($loan->created_at,2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-success font-weight-bold text-center mr-1" data-toggle="modal" data-target="#my-modalBox__{{ $loan->id }}">
                                            <i class="fa fa-check-circle"></i>
                                            <span>Approuver</span>
                                        </a>
                                        <!-- MODAL -->
                                        <div class="modal fade text-left" id="my-modalBox__{{ $loan->id }}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header text-center">
                                                        <h3 class="modal-title pm-0" id="myModalLabel">{{ $loan->customer->fullname() }}</h3>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <div class="modal-body pad-lg-h pt-2 pb-1">
                                                        <form action="{{ routeWithLocale('admin.approve_loan.post') }}" method="POST" role="form">
                                                            @csrf

                                                            <div class="bg-light mb-3 p-2 rounded">
                                                                <table class="table m-0 table-sm">
                                                                    <tr>
                                                                        <td class="bg-light">{{ translate(353) }}</td>
                                                                        <td class="font-weight-bold">{{ setCurrency($loan->currency, $loan->amount) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="bg-light">{{ translate(341) }}</td>
                                                                        <td class="font-weight-bold">{{ $loan->duration }} {{ translate(344) }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            
                                                            <div class="d-none">
                                                                <input class="hidden" name="accept_loan_id" type="hidden" value="{{ $loan->id }}">
                                                                <input class="hidden" name="customer_id" type="hidden" value="{{ $loan->customer->id }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label class="required-field">{{ translate(342) }}</label>
                                                                        <input type="number" step="0.01" class="form-control" value="{{ trim(TEAG, '%') }}" name="teag" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="required-field">{{ translate(860) }}</label>
                                                                        <input type="date" class="form-control" name="start_at" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="required-field">{{ translate(727) }} ( <span class="badge badge-info">{{ $loan->currency->name }}</span> )</label>
                                                                <input type="text" class="form-control" value="{{ $totalInterest }}" name="total_interest" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <label class="required-field">{{ translate(343) }} ( <span class="badge badge-info">{{ $loan->currency->name }}</span> )</label>
                                                                        <input type="text" name="monthly_payment" value="{{ $monthlyPayment }}" class="form-control" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <label class="required-field">{{ translate(859) }} ( <span class="badge badge-info">{{ $loan->currency->name }}</span> )</label>
                                                                        <input type="text" class="form-control" value="{{ $totalPayment }}" name="total_mpayment" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-success">Accorder le prêt</button>
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
                                    </td>
                                    <td class="text-center">
                                        <form class="confirm-action" data-message="Êtes-vous certain de vouloir supprimer cette demande de prêt ?" action="{{ routeWithLocale('admin.delete_loan.post') }}" method="post">
                                            @csrf
                                            
                                            <input type="hidden" name="customer_id" value="{{ $loan->customer_id }}">
                                            <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                                            <button type="submit" class="btn font-weight-bold btn-outline-danger">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                
                                <tr>
                                    <td colspan="6">
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