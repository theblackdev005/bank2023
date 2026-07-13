@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white p-4 table-responsive">
                    <h1 class="mb-5">
                        <span>Demandes d'ouverture - </span>
                        <span class="badge bg-secondary text-white">clients en attente</span>
                    </h1>
                    <table class="table">

                        <thead>
                            <tr>
                                <th class="col-lg-2 text-center">Modifier</th>
                                <th class="col-lg-1 text-center">
                                    <i class="fa fa-paperclip"></i>
                                </th>
                                <th class="col-lg-5">Nom et prénom(s)</th>
                                <th class="col-lg-1">Transactions</th>
                                <th class="col-lg-2 text-center">Transferts</th>
                                <th class="col-lg-1">Bannir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                
                                <x-admin-customer-listing-row 
                                    :customer=$customer 
                                    :languages=$languages 
                                    type="pending"/>

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

                <div class="col-12 bg-light p-3 mt-2">
                    <x-paginator :items=$customers />
                </div>
            </div>
        </div>
    </section>
@endsection