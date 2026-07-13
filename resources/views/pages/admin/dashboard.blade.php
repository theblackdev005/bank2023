@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					
					<!-- MY CARDS PART 1 -->
					<div class="row mb-3">

						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-4 pb-2 text-dark">
									<x-admin-card 
										title="Clients" 
										description="Liste des clients qui sont inscrits sur le site." 
										icon="user" 
										url="{{ routeWithLocale('admin.customers', 'verified') }}" 
										count="{{ $stats->get('verified_customers') }}"
										options="true" />
								</div>
								<div class="col-lg-4 pb-2 text-dark">
									<x-admin-card 
										title="Admins" 
										description="Liste des administrateurs qui gèrent le site." 
										icon="cog" 
										url="admin.listing" 
										count="{{ $stats->get('admins') }}"
										options="true" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Sessions" 
										description="Afficher l'historique de connexion des clients." 
										icon="globe" 
										url="admin.customers_sessions" 
										count="{{ $stats->get('sessions') }}"
										options="true" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Contact" 
										description="Messages non envoyés via le formulaire de contact." 
										icon="paper-plane" 
										url="admin.contacts" 
										count="{{ $stats->get('contacts') }}" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="RIB" 
										description="Les RIBs à afficher sur le compte de chaque client." 
										icon="info-circle" 
										url="admin.rib" 
										count="{{ $stats->get('ribs') }}"
										theme="secondary" />
								</div>
							</div>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-12 pt-2 pb-1">
							<h3 class="dashboard-title bg-secondary text-white">Cartes, Paypal & Comptes bancaires</h3>
						</div>
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Cartes Bancaires" 
										description="Liste des cartes bancaires enrégistrées." 
										icon="credit-card" 
										url="admin.credit_cards" 
										count="{{ $stats->get('cards') }}" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Paypal" 
										description="Liste des comptes paypal enrégistrés." 
										icon="paypal" 
										url="admin.paypal_accounts" 
										count="{{ $stats->get('paypal') }}"
										theme="info" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Bénéficiaires" 
										description="Liste des comptes bancaires bénéficiaires." 
										icon="bank" 
										url="admin.recipients" 
										count="{{ $stats->get('recipients') }}" />
								</div>
							</div>
						</div>
					</div>

					<!-- MY CARDS PART 2 -->
					<div class="row mb-3">
						<div class="col-12 pt-2 pb-1">
							<h3 class="dashboard-title bg-secondary text-white">DEMANDES EN ATTENTES</h3>
						</div>
						<div class="col-12">
							<div class="row">
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Validations" 
										description="Liste des clients dont les comptes ne sont pas validés." 
										icon="cloud-upload" 
										url="{{ routeWithLocale('admin.customers', 'pending') }}" 
										count="{{ $stats->get('pending_customers') }}" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Prêts" 
										description="Liste des demandes de prêts en attente de validation." 
										icon="shopping-cart" 
										url="admin.pending_loans" 
										count="{{ $stats->get('pending_loans_request') }}" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Bannissement" 
										description="Liste des clients dont les comptes ont été bannis." 
										icon="ban" 
										url="{{ routeWithLocale('admin.customers', 'banned') }}" 
										count="{{ $stats->get('banned_customers') }}" />
								</div>
							</div>
						</div>
					</div>

					<!-- MY CARDS PART 3 -->
					<div class="row mb-3">
						<div class="col-12 pt-2 pb-1">
							<h3 class="dashboard-title bg-secondary text-white">PARAMETRES AVANCES</h3>
						</div>
						<div class="col-12">
							<div class="row mb-2">
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Sauvegarde" 
										description="Créer une sauvegarde locale des données du site." 
										icon="cloud-download" 
										url="admin.backup" 
										theme="primary" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Témoignages" 
										description="Liste de faux témoignages à afficher sur le site." 
										icon="tag" 
										url="admin.testimonials" 
										count="{{ $stats->get('testimonials') }}"
										theme="secondary" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Mail Pro" 
										description="Liste des mails professionnels crées par les admins." 
										icon="at" 
										url="admin.mail_pro" 
										count="{{ $stats->get('mails_pro') }}"
										theme="secondary" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Sms Pros" 
										description="Liste des sms professionnels envoyés via le site." 
										icon="envelope" 
										url="admin.sms" 
										count="{{ $stats->get('sms') }}"
										options="true" />
								</div>
							</div>
							
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-12 pt-2 pb-1">
							<h3 class="dashboard-title bg-secondary text-white">ESPACE COMMUN A TOUS LES ADMINS</h3>
							<div class="alert alert-danger font-weight-bold">{{ translate(687) }}</div>
						</div>
						<div class="col-12">
							<div class="row mb-2">
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Configuration" 
										description="Liste des configurations appliquées sur le site." 
										icon="cog" 
										url="admin.site_configs" 
										count="{{ $stats->get('configs') }}"
										theme="dark" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Monnaies" 
										description="Activer/Désactiver une devise monétaire sur tout le site." 
										icon="euro" 
										url="admin.manage_currencies" 
										count="{{ $stats->get('currencies') }}"
										theme="dark" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Liste de pays" 
										description="Activer/Désactiver un pays sur tout le site." 
										icon="map" 
										url="admin.manage_countries" 
										count="{{ $stats->get('countries') }}"
										theme="dark" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Liste de langues" 
										description="Activer/Désactiver une langue sur tout le site." 
										icon="flag" 
										url="admin.manage_languages" 
										count="{{ $stats->get('languages') }}"
										theme="dark" />
								</div>
								<div class="col-lg-4 pb-2">
									<x-admin-card 
										title="Recaptcha" 
										description="Activer/Désactiver l'utilisation du recaptcha." 
										icon="robot" 
										url="admin.manage_recaptcha" 
										theme="dark" />
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
@endsection