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

			{{Form::open(array('method'=>'get','class'=>'form-inline'))}}
			<div class="form-group">
				<div class="input-group ">
					{{Form::input('search','q', Input::has('q') ? Input::get('q') : null , array('class'=>'form-control'))}}
					{{Form::hidden('filtre', Input::has('filtre') ? Input::get('filtre'): null)}}
					{{Form::hidden('ordre', Input::has('ordre') ? Input::get('ordre') :null)}}
					{{Form::submit('Chercher', array('class'=>'btn-info'))}}
				</div>
			</div>

			{{Form::close()}}

			{{$proprietes->appends(Input::except('page'))->links()}}

			@if(Helpers::isOk($proprietes))
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							<a href="?{{Input::has('q') ? http_build_query(Input::all()).'&' :''}}filtre=id&ordre={{Helpers::isNotOk(Input::all()) ?  'asc' : (Input::get('ordre') == 'asc' ? 'desc': 'asc')}}">
								Référence (id)
							</a>
						</th>
						<th>
							<a href="?{{Input::has('q') ? http_build_query(Input::all()).'&' :''}}filtre=nom&ordre={{Helpers::isNotOk(Input::all()) ?  'asc' : (Input::get('ordre') == 'asc' ? 'desc': 'asc')}}">
								Nom
							</a>
						</th>
						<th>
							<a href="?{{Input::has('q') ? http_build_query(Input::all()).'&' :''}}filtre=slug&ordre={{Helpers::isNotOk(Input::all()) ?  'asc' : (Input::get('ordre') == 'asc' ? 'desc': 'asc')}}">
								Slug/lien
							</a>
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
							<a href="?{{Input::has('q') ? http_build_query(Input::all()).'&' :''}}filtre=created_at&ordre={{Helpers::isNotOk(Input::all()) ?  'asc' : (Input::get('ordre') == 'asc' ? 'desc': 'asc')}}">
								Posté le
							</a>
						</th>
						<th>
							<a href="?{{Input::has('q') ? http_build_query(Input::all()).'&' :''}}filtre=statut&ordre={{Helpers::isNotOk(Input::all()) ?  'asc' : (Input::get('ordre') == 'asc' ? 'desc': 'asc')}}">
								Statut
							</a>
						</th>
						<th>
							<a href="?{{Input::has('q') ? http_build_query(Input::all()).'&' :''}}filtre=verifier&ordre={{Helpers::isNotOk(Input::all()) ?  'asc' : (Input::get('ordre') == 'asc' ? 'desc': 'asc')}}">
								Verification
							</a>
						</th>
						<th>
							<a href="?{{Input::has('q') ? http_build_query(Input::all()).'&' :''}}filtre=etape&ordre={{Helpers::isNotOk(Input::all()) ?  'asc' : (Input::get('ordre') == 'asc' ? 'desc': 'asc')}}">
								Etapes
							</a>
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
							{{$propriete->nom}}
						</td>
						<td>
							<a href="{{route('showPropriete', $propriete->id)}}">{{$propriete->slug}}</a>
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

							@if( $propriete->statut )
							Active
							@else
							Inactive
							@endif
						</td>
						<td>
							@if( $propriete->verifier == 0 )
							Non vérifié
							@elseif($propriete->verifier == 1)
							Verifié
							@endif
						</td>
						<td {{$propriete->etape == 7 ? 'class="success"':''}}>
							{{$propriete->etape}}
						</td>
						<td>
							@if($propriete->statut)
							<a href="{{route('desactiver_propriete', $propriete->id )}}" data-id="{{$propriete->id}}" class="desactiverPropriete">Desactiver</a>
							@else
							<a href="{{route('activer_propriete', $propriete->id )}}" data-id="{{$propriete->id}}" class="activerPropriete">Activer</a>
							@endif
							@if($propriete->verifier)
							<a href="{{route('deverifier_propriete', $propriete->id)}}" data-id="{{$propriete->id}}" class="deverifierPropriete">Annuler la vérification</a>
							@else
							<a href="{{route('verifier_propriete', $propriete->id)}}" data-id="{{$propriete->id}}" class="verifierPropriete">Activer la vérification</a>
							@endif
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
	{{$proprietes->appends(Input::except('page'))->links()}}
</div>
@stop