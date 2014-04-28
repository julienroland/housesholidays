@extends('admin.layout.layout')

@section('container')
<div class="container">
	<div class="row">
		<div class="col-lg-12 main">

			@if($listPages->count())

			<h2 aria-level="2" role="heading" class="sub-header">Liste des contenus de type CMS</h2>
			<div class="alert alert-info">Il y a un total de <strong>{{$listPages->count()}} pages/contenu</strong> de type CMS</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Url</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($listPages as $page)
						<tr>
							<td>{{$page->id}}</td>
							<td>{{$page->nom}}</td>
							@if(isset( $page->pageTraduction[0]->url ) && Helpers::isOk( $page->pageTraduction[0]->url ))

							<td>{{$page->pageTraduction[0]->url}}</td>

							@else

							<td class="warning empty">Vide</td>

							@endif
							<td>{{link_to_route('admin.pages.edit','Modifier',$page->id)}} / supprimer</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>


			@endif
		</div>
	</div>
</div>

@stop