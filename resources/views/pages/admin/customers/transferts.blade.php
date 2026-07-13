@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-white p-5 table-responsive">
					<h1 class="mb-5">
					    <span>Transferts de fonds - </span>
					    <span class="badge bg-success text-white">{{ $customer->fullname() }}</span>
					</h1>

					<div class="table-responsive">
						@forelse ($transferts as $transfert)
						
							<table class="table table-sm table-striped mb-5">
								<thead>
									<tr>
										<th>Bénéficiaire</th>
										<th>Montant</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

								    <tr>
										<td class="p-1 align-middle">
											<table class="table-sm table-bordered">
												<tr>
													@foreach (dyn_recipient_data($transfert) as $translation_key => $value)
												        <td class="py-1 bg-light">
												        	<small class="font-weight-bold text-muted">{{ translate($translation_key) }}</small><br>
												        	<span class="badge badge-info">{{ $value }}</span>
												        </td>
													@endforeach
												</tr>
											</table>
										</td>
										<td class="align-middle">
											<h2 class="d-block text-info m-0">{{ setCurrency($transfert->currency, $transfert->amount) }}</h2>
											<span class="d-block font-weight-bold">Référence: {{ $transfert->reference }}</span>
										</td>
										<td class="align-middle">
											<a class="btn btn-danger btn-sm font-weight-bold" data-message="Êtes-vous certains de vouloir arrêter ce transfert de fonds ?" href="{{ routeWithLocale('admin.delete_transfert', [
												'username' => $transfert->customer->username,
												'id' => $transfert->id
											]) }}">
												<span>Suppr.</span>
											</a>
										</td>
								    </tr>

									<!-- Si le transfert à été facturé -->
									@if ( $transfert->fees()->count() )
										
										<tr>
											<td colspan="2" class="shadow-md px-0">
												<h4 class="pt-2 text-muted text-center font-weight-bold">Liste de frais</h4>
												<table class="w-100 table-sm table-borered">
													<tbody>
														@foreach ($transfert->fees()->get() as $fee)
															<tr>
																<td class="text-center align-middle">

																	@if ( $fee->isPayed() )
																		<button type="button" disabled class="btn font-weight-bold btn-sm btn-light">
																			<i class="fa fa-remove"></i>
																			<span>suppr.</span>
																		</button>
																	@else
																		<a class="btn font-weight-bold btn-sm btn-danger" data-message="Êtes-vous certains de vouloir supprimer ce frais ?" href="{{ routeWithLocale('admin.transfert_fee.delete', $fee->id) }}">
																			<i class="fa fa-remove"></i>
																			<span>suppr.</span>
																		</a>
																	@endif
																	
																</td>
																<td class="text-center align-middle">
																	<i class="fa fa-check-circle fa-2x text-{{ $fee->isPayed() ? "success" : "dark" }}"></i>
																</td>
																<td class="align-middle">
																	<strong class="d-block">
																		<span class="badge badge-success">{{ setCurrency($fee->currency, $fee->cost) }}</span>
																		<strong>{{ $fee->name }}</strong>
																		<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $fee->instructions }}"></i>
																	</strong>
																	<small class="text-muted font-weight-bold">Temps d'attente après validation: <span class="badge badge-warning">{{ $fee->load_delay }}s</span>.</small><br>
																	@if ( $fee->load_at )
																		@if ( $fee->isExpired() )
																			<small class="text-muted font-weight-bold">
																				<span class="badge badge-danger">EXP. - {{ $fee->load_at }}</span>
																			</small>
																		@else
																			<small class="text-muted font-weight-bold">
																				<span>Prochaine étape : </span>
																				<span class="badge badge-success">{{ $fee->load_at }}</span>
																			</small>
																		@endif
																	@else
																		<small class="text-muted font-weight-bold">
																			<span class="badge badge-warning">PENDING</span>
																		</small>
																	@endif
																</td>
																<td class="text-center align-middle">

																	@if ( $fee->isPayed() )
																		<button type="button" disabled class="btn font-weight-bold btn-sm btn-info">
																			<i class="fa fa-paper-plane"></i>
																			<span>mail</span>
																		</button>
																	@else
																		<a class="btn font-weight-bold btn-sm confirm-action btn-success" data-toggle="tooltip" data-placement="top" title="Envoyer le code par mail" data-message="Êtes-vous certains de vouloir envoyer ce code au client ?" href="{{ routeWithLocale('admin.transfert_fee.send_code', $fee->id) }}">
																			<i class="fa fa-paper-plane"></i>
																			<span>mail</span>
																		</a>
																	@endif

																</td>
																<td class="text-center align-middle">
																	<a href="javascript:;" data-toggle="tooltip" data-placement="top" title="Code: {{ $fee->code }}" class="btn copy btn-sm btn-secondary font-weight-bold" data-copy="{{ $fee->code }}">
																		<i class="fa fa-copy" title="{{ $fee->code }}"></i> copier
																	</a>
																</td>
																<td class="text-center align-middle">

																	@if ( $fee->isPayed() )
																		<button type="button" disabled class="btn font-weight-bold btn-sm btn-light">
																			<i class="fa fa-check-circle"></i>
																			<span>valider</span>
																		</button>
																	@else
																		<a data-toggle="tooltip" data-placement="top" title="Marquer ce frais comme payé." class="btn font-weight-bold btn-sm confirm-action btn-success" data-message="Êtes-vous certains de vouloir valider ce frais ?" href="{{ routeWithLocale('admin.transfert_fee.validate', $fee->id) }}">
																			<i class="fa fa-check-circle"></i>
																			<span>valider</span>
																		</a>
																	@endif

																</td>
																<td class="align-middle font-weight-bold">
																	<span class="badge badge-info">{{ $fee->percentage }}%</span>
																</td>
															</tr>
														@endforeach
													</tbody>
												</table>
											</td>
											<td class="text-center align-middle">
												<i class="fa fa-check-circle fa-5x text-{{ $transfert->isCompleted() ? 'success' : 'secondary' }}"></i>
											</td>
										</tr>

									@endif

									@if ( ! $transfert->isCompleted() )
										<tr>
											<td colspan="3">
												<a class="btn btn-success text-white font-weight-bold" data-toggle="modal" data-target="#my-modalBox{{ $transfert->id }}">
													<i class="fa fa-plus mr-1"></i>
													<span>Facturer</span>
												</a>
												<!-- MODAL -->
												<div class="modal fade text-left" id="my-modalBox{{ $transfert->id }}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												    <div class="modal-dialog">
												        <div class="modal-content">
												            
												            <!-- Modal Header -->
												            <div class="modal-header py-2 text-center">
												                <h3 class="modal-title pm-0" id="myModalLabel">#{{ $transfert->reference }}</h3>
												            </div>
												            
												            <!-- Modal Body -->
												            <div class="modal-body pad-lg-h pt-2 pb-1">
												                <form action="{{ routeWithLocale('admin.transfert_fee.post', $transfert->id) }}" method="POST" role="form">
												                	@csrf
												                	
												                    <div class="form-group">
												                    	<label class="form-label required-field">Nom <span class="text-danger">(à Traduire)</span> :</label>
												                    	<input type="text" name="name" placeholder="Frais d'assurance" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
												                    </div>
												                    <div class="form-group">
												                    	<div class="row">
												                    		<div class="col-12 col-md-6">
												                    			<label class="form-label required-field">Coût ( en <span class="badge badge-info">{{ $transfert->currency->name }}</span> ) :</label>
												                    			<input type="number" name="cost" pattern="[0-9\.]{1,}" placeholder="1200" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
												                    		</div>
												                    		<div class="col-12 col-md-6">
												                    			<label class="form-label required-field">Progression (%) :</label>
												                    			<input type="number" name="percentage" pattern="[0-9]{2,3}" placeholder="75" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
												                    		</div>
												                    	</div>
												                    </div>
												                    <div class="form-group">
												                    	<label class="form-label required-field">Instructions <span class="text-danger">(à Traduire)</span> :</label>
												                    	<textarea name="instructions" class="form-control" required></textarea>
												                    </div>
												                    <div class="form-group">
												                    	<div class="row">
												                    		<div class="col-md-12 col-md-offset-2">
												                    			<label class="form-label m-0 required-field">Délai d'attente avant d'afficher le frais suivant :</label>
												                    			<p class="text-muted small">Ce délai représente le temps pendant lequel on doit attendre avant d'afficher le frais suivant.</p>
												                    			<div class="row">
												                    				<div class="col-md-6">
												                    					<select class="form-control" name="delay_interval" required>
												                    						<option value="">-</option>
												                    						<option value="1">Minute</option>
												                    						<option value="2">Heure</option>
												                    						<option value="3">Jour</option>
												                    					</select>
												                    				</div>
												                    				<div class="col-md-6">
												                    					<select class="form-control" name="delay_frequence" required>
												                    						<option value="">-</option>
												                    						<option value="1">01</option>
												                    						<option value="2">02</option>
												                    						<option value="3">03</option>
												                    						<option value="4">04</option>
												                    						<option value="5">05</option>
												                    						<option value="6">06</option>
												                    						<option value="12">12</option>
												                    						<option value="24">24</option>
												                    						<option value="48">48</option>
												                    						<option value="72">72</option>
												                    					</select>
												                    				</div>
												                    			</div>
												                    		</div>
												                    	</div>
												                    </div>
												                    <div class="form-group">
												                        <button type="submit" class="btn btn-success font-weight-bold">
												                        	<i class="fa fa-check-circle"></i>
												                        	<span>Facturer ce transfert</span>
												                        </button>
												                    </div>
												                </form>
												            </div>
												            <!-- Modal Footer -->
												            <div class="modal-footer">
												                <button type="button" class="btn btn-dark" data-dismiss="modal">Fermé</button>
												            </div>
												        </div>
												    </div>
												</div>
												<!-- MODAL -->
											</td>
										</tr>
									@endif

								</tbody>
							</table>

						@empty
							<table class="table table-sm table-striped">
								<tr>
									<td>
										<x-show-empty-data-message />
									</td>
								</tr>
							</table>
						@endforelse
					</div>

				</div>
			</div>
		</div>
	</section>
@endsection