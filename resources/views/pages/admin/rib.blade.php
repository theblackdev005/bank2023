@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white p-4 table-responsive">
                    <h2 class="mb-5 d-flex flex-wrap justify-content-between">
                        <span>
                            <span class="badge badge-info">{{ $ribs->count() }}</span>
                            <span>Configuration des RIBs</span>
                        </span>
                        <span>
                            <a href="javascript:;" class="btn btn-success font-weight-bold" data-toggle="modal" data-target="#my-modalBox__add_admin">
                                <i class="fa fa-plus"></i>
                                <span>Ajouter un RIB</span>
                            </a>
                        </span>
                    </h2>

                    <div class="modal fade text-left" id="my-modalBox__add_admin" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header text-center">
                                    <h4 class="modal-title pm-0" id="myModalLabel">Ajouter un RIB.</h4>
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Fermé</button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    @livewire('add-rib-modal-form', compact('customers'))
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                            	<th>Client</th>
                            	@foreach (rib_keys() as $key => $name)
                                	<th>{{ translate($name) }}</th>
                            	@endforeach
                            	<th>Maj.</th>
                            	<th>Identité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ribs as $rib)
                                
                                <tr>

                                	<td>
                                        <strong>{{ $rib->customer->fullname() }}</strong><br>
                                        <span>{{ $rib->customer->email }}</span>   
                                    </td>
                                    
                                	@foreach (rib_keys() as $key => $name)
                                    	<td>{{ $rib->$key }}</td>
                                	@endforeach

                                    <td>
                                        
                                        {{-- MODAL BOX --}}
                                        <a href="javascript:;" class="btn btn-dark font-weight-bold" data-toggle="modal" data-target="#my-modalBox__{{ $rib->id }}">
                                            <i class="fa fa-edit"></i>
                                            <span>Maj</span>
                                        </a>
                                        <div class="modal fade text-left" id="my-modalBox__{{ $rib->id }}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header text-center">
                                                        <h3 class="modal-title pm-0" id="myModalLabel">RIB de <span class="badge badge-info">{{ $rib->customer->fullname() }}</span>.</h3>
                                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Fermé</button>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <form action="{{ routeWithLocale('admin.edit_rib.post', ['rib_id' => $rib->id]) }}" method="post">
                                                        	@csrf

                                                        	<div class="form-group d-none">
                                                        	    <input class="form-control d-none" type="hidden" name="update[{{ $rib->id }}][customer_id]" value="{{ $rib->customer->id }}">
                                                        	</div>

                                                        	<div class="row">
                                                        		@foreach (rib_keys() as $key => $name)
                                                        			<div class="col-md-6 mb-2">
                                                        				<div class="form-group">
                                                        				    <div class="well">
                                                        				        <label class="form-label m-0">{{ translate($name) }}</label>
                                                        				        <input class="form-control" autocomplete="nope" name="update[{{ $rib->id }}][{{ $key }}]" value="{{ $rib->$key }}">
                                                        				    </div>
                                                        				</div>
                                                        			</div>
                                                        		@endforeach
                                                        	</div>

                                                        	@if ( $rib->amount > 0 )
                                                        		<div class="form-group">
                                                        		    <label class="form-label m-0">Frais à payer:</label>
                                                        		    <p class="text-muted m-0">Frais que le client doit payer sur le compte bancaire ci-dessus, afin que son identité soit vérifiée:</p>
                                                        		    <h2 class="m-0 font-weight-bold text-info">{{ setCurrency($rib->currency, $rib->amount) }}</h2>
                                                        		</div>
                                                        	@endif

                                                        	<x-admin-custom-switch checked="{{ $rib && $rib->isEnabled() }}" name="update.{{ $rib->id }}.enable" />

                                                        	<div class="form-group d-flex justify-content-between">
                                                        		<button type="submit" name="submit" class="btn font-weight-bold btn-xs btn-success">
                                                        			<i class="fa fa-check-circle"></i> 
                                                        			<span>Maj</span>
                                                        		</button>
                                                        		<a href="{{ routeWithLocale('admin.delete_rib', ['rib_id' => $rib->id]) }}" data-message="Êtes-vous certain de vouloir supprimer ce RIB ?" class="btn btn-danger font-weight-bold">
                                                        		    <i class="fa fa-remove"></i>
                                                        		    <span>Suppr.</span>
                                                        		</a>
                                                        	</div>
                                                        </form>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        {{-- MODAL BOX --}}

                                    </td>
                                    <td>

                                    	@if ( ! $rib->customer->isVerifiedIdentity() )
                                    		<a href="{{ routeWithLocale('admin.verify_identity', ['rib_id' => $rib->id]) }}" data-message="Êtes-vous certain de vouloir vérifié l'identité de ce client ?" class="btn btn-success confirm-action font-weight-bold">
                                    		    <i class="fa fa-check-circle"></i>
                                    		    <span>Identity</span>
                                    		</a>
                                    	@else
                                    		<button type="button" disabled class="btn btn-success font-weight-bold">
                                    		    <i class="fa fa-check-circle"></i>
                                    		    <span>Identity</span>
                                    		</button>
                                    	@endif
                                    	
                                    </td>
                                </tr>

                            @empty
                                
                                <tr>
                                    <td colspan="8">
                                        <x-show-empty-data-message />
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="col-12 bg-light p-3 mt-2">
                    <x-paginator :items=$ribs />
                </div>
            </div>
        </div>
    </section>
@endsection