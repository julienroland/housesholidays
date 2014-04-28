@extends('admin.layout.layout')

@section('container')
@if(Session::has('success'))
<div class="alert alert-success">
	{{Session::get('success')}}
</div>
@endif
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<p>Il y a x demande d'ajout a la base de donnée</p>
			<p>Il y a x messages</p>
			<p>Il y a x annonces active</p>
			<p>Il y a x annonces en attente de validation</p>
			<p>Il y a x annonces inactive</p>
			<p>Il y a x annonces prenium</p>
			<p>Il y a x utilisateurs enregistré.</p>
			<p>Il y a x utilisateurs en attente de validation</p>
			<p>Il y a x pages/contenu de type cms</p>
			<p>Il y a x traductions statics et x dynamique</p>
		</div>
	</div>
</div>
@stop