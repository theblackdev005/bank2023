@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-white p-5">
					<h1 class="mb-5">Ajouter une demande de prêt</h1>
					<div class="row">
						<div class="col-md-5">
							<form action="" method="post">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="required-field">Début du prêt</label>
											<input type="date" class="form-control" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="start_at" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
										</div>
										<div class="form-group">
											<label class="required-field">Total des intérêts</label>
											<input type="text" pattern="[0-9\.]{1,}" class="form-control" name="total_interest" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
										</div>
										<div class="form-group">
											<label class="required-field">Total des mensualités</label>
											<input type="text" pattern="[0-9\.]{1,}" class="form-control" name="total_mpayment" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="required-field">Montant du prêt</label>
											<input type="text" pattern="[0-9]{1,}" name="amount" class="form-control" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
										</div>
										<div class="form-group">
											<label class="required-field">Durée (Nombre de mois)</label>
											<input type="text" pattern="[0-9]{1,}" name="duration" class="form-control" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
										</div>
										<div class="form-group">
											<label class="required-field">Taux</label>
											<input type="text" pattern="[0-9\.]{1,}" name="teag" class="form-control" value="<?= trim(TEAG, '%') ?>" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
										</div>
										<div class="form-group">
											<label class="required-field">Mensualité</label>
											<input type="text" pattern="[0-9\.]{1,}" name="m_payment" class="form-control" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
										</div>
										<div class="form-group">
											<label class="required-field">Objectif <span class="text-orange">(à Traduire)</span></label>
											<textarea type="text" name="goal" class="form-control" placeholder="Ce que le client veut faire avec le prêt" required></textarea>
										</div>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-lg">Ajouter un prêt</button>
								</div>
							</form>
						</div>
						<div class="col-md-7">
							<table class="table">
								<thead>
									<tr>
										<th colspan="3">Details sur le prêt en cours...</th>
									</tr>
									<tr>
										<th>#</th>
										<th>Valeur</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
								<?php $toggle = false; if($loans) : ?>
								<?php $toggle = true; foreach($loans as $k=>$loan) : ?>
									<?php $cds = ($loan['status'] > 0) ? 'connecte' : 'deconnecte' ?>
									<tr>
										<td>Début du prêt</td>
										<td><?= dateFormat($loan['start_at'], 1) ?></td>
									</tr>
									<tr>
										<td>Montant</td>
										<td>
											<strong class="<?= $cds ?>" colspan="2"><?= setCurrency($customer->currency, $loan['amount']) ?></strong>
										</td>
									</tr>
									<tr>
										<td>Durée</td>
										<td><?= $loan['duration'] ?> Mois</td>
									</tr>
									<tr>
										<td>Taux</td>
										<td><?= $loan['teag'] ?> %</td>
										<td class="bold"><?= setCurrency($customer->currency, $loan['total_interest']) ?></td>
									</tr>
									<tr>
										<td>Mensualité</td>
										<td><?= setCurrency($customer->currency, $loan['m_payment']) ?></td>
										<td class="bold"><?= setCurrency($customer->currency, $loan['total_mpayment']) ?></td>
									</tr>
									<tr>
										<td>Objectif</td>
										<td><span class="text-justify" colspan="2"><?= $loan['goal'] ?></span></td>
									</tr>
									<tr>
										<td colspan="3">
											<a href="<?= url("admin/delete/l/{$loan['id']}") ?>" class="btn btn-danger breakTag" data-message="Êtes-vous certains de vouloir supprimer cette demande de prêt ?">Supprimer le prêt.</a>
										</td>
									</tr>
								<?php endforeach ?>
								<?php else : ?>
								<tr>
									<td class="row">
										<blockquote>
											<p class="text-success">Aucune demande de prêt trouvée. <br>Vous pouvez en ajouter une ci-contre.</p>
										</blockquote>
										<?php endif ?>
									</td>
								</tr>
								</tbody> 
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection