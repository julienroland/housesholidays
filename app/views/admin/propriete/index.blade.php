@extends('admin.layout.layout')

@section('container')

<div class="container">
	<div class="row">
		<div class="col-lg-12">

			@if(Session::has('success'))
			<div class="alert alert-success">
				{{Session::get('success')}}
			</div>
			@endif

			@if(Helpers::isOk($proprietes))
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							Référence (id)
						</th>
						<th>
							Paiement
						</th>
						<th>
							Utilisateur
						</th>
						<th>
							Payer le
						</th>
						<th>
							Posté le
						</th>
						<th>
							Statut
						</th>
						<th>
							Verification
						</th>
						<th>
							Options
						</th>
					</tr>
				</thead>

				<tbody>
					@foreach( $proprietes as $propriete )

					<tr>
						<td>
							{{$propriete->id}}
						</td>	
						<td>

						</td>
						<td>
							{{$propriete->user->prenom}} {{$propriete->user->nom}}
						</td>	
						<td>

						</td>
						<td>
							{{Helpers::dateEu($propriete->created_at->toDateString())}}
						</td>
						<td>
							@if( $propriete->statut == 0 )
							Inactive
							@elseif($propriete->statut == 1)
							Active
							@endif
						</td>
						<td>
							@if( $propriete->verifier == 0 )
							Non vérifié
							@elseif($propriete->verifier == 1)
							Verifié
							@endif
						</td>
						<td>
							<a href="{{route('desactiver_propriete', $propriete->id )}}" data-id="{{$propriete->id}}" class="desactiverPropriete">Desactiver</a>
							<a href="{{route('deverifier_propriete', $propriete->id)}}" data-id="{{$propriete->id}}" class="desactiverPropriete">Annuler la vérification</a>
							<a href="{{route('showPropriete', $propriete->id )}}">Voir</a>
							<a href="{{route('deletePropriete', $propriete->id )}}">Supprimer</a>
						</td>
					</tr>

					@endforeach
				</tbody>
			</table>
			@endif
		</div>
	</div>
</div>
@stop