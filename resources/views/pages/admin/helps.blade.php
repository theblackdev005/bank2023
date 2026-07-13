@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					
					<!-- MY CARDS PART 1 -->
					<div class="row mb-3">
						<div class="col-12 mb-3">
							<div class="bg-white p-4">
								<h4 class="d-block mb-1 text-success">Lorsque vous voyez le mot : </h4>
								<ul>
									<li>
										<span>
											<strong class="text-danger text-underline">(A Traduire)</strong>
											<span> signifie que ce champ doit être traduit dans la langue du client.</span>
										</span>
									</li>
									<li>
										<span>Les dates doivent être écrites au format : <strong class="text-danger text-underline">DD/MM/YYYY</strong> par exemple.</span>
									</li>
									<li>
										<span>Les numéros de téléphones sont aux formats : <strong class="text-danger text-underline">+3300000000</strong></span>
									</li>
									<li>
										<span>Lorsque vous bloquez un client, <strong class="text-danger">il ne pourra plus accéder à son compte</strong></span>
									</li>
								</ul>
							</div>
							<div class="bg-light p-4">
								<h4 class="text-primary">Comment ça marche ?</h4>
								<p>Découvrez comment utiliser ce site en visionnant cette vidéo: <a target="_blank" href="{{ YOUTUBE_VIDEO_PRESENTATION_URL }}">
									<span class="fa fa-video"></span>
								</a></p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
@endsection