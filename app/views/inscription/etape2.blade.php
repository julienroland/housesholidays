@if(Session::has('success'))
<div class="success">
	<ul>
		<li>{{Session::get('success')}}</li>
	</ul>
</div>
@endif
{{Form::open(array('url'=>'inscription'))}}

{{Form::label('property_name',trans('form.enter_batiment_name'))}}
{{Form::text('property_name','',array('placeholder'=>'Avana Mostra'))}}
<br/>
{{Form::label('titre',trans('form.enter_annonce_name'))}}
{{Form::text('titre','',array('placeholder'=>trans('form.enter_annonce_placeholder')))}}
<br/>

{{Form::label('property_type',trans('form.enter_batiement_type'))}}
{{Form::select('property_type',$typeBatimentList)}}

<br/>
{{Form::label('many_people',trans('form.enter_nb_personne'))}}
{{Form::select('many_people',$nombreList)}}
<br/>
{{Form::label('room_number',trans('form.enter_nb_chambre'))}}
{{Form::select('room_number',$nombreList)}}
<br/>
{{Form::label('number_bathroom',trans('form.enter_nb_sdb'))}}
{{Form::select('number_bathroom',$nombreList2)}}
<br/>
{{Form::label('floor',trans('form.enter_etage'))}}
{{Form::select('floor',$nombreList2)}}

<br/>
{{Form::label('interior_size',trans('form.enter_int_size'))}}
{{Form::text('interior_size','',array('placeholder'=>'2'))}}
<span>m²</span>
<br/>
{{Form::label('taille_exterieur',trans('form.enter_ext_size'))}}
{{Form::text('taille_exterieur','',array('placeholder'=>'2'))}}
<span>m²</span>
<br/>
{{Form::label('description',trans('form.enter_description'))}}
{{Form::textarea('description','')}}
<h2 aria-level="2" role="heading">{{trans('form.title_lit')}}</h2>

{{Form::label('nb_chambre',trans('form.nb_chambre'))}}
{{Form::text('nb_chambre','')}}
<br/>
{{Form::label('nb_dbl_lit',trans('form.nb_dbl_lit'))}}
{{Form::text('nb_dbl_lit','')}}
<br/>
{{Form::label('nb_kid_lit',trans('form.nb_kid_lit'))}}
{{Form::text('nb_kid_lit','')}}
<br/>
{{Form::label('nb_couchage',trans('form.nb_couchage'))}}
{{Form::text('nb_couchage','')}}
<br/>
{{Form::label('nb_lit_simple',trans('form.nb_lit_simple'))}}
{{Form::text('nb_lit_simple','')}}
<br/>
{{Form::label('nb_canape_lit',trans('form.nb_canape_lit'))}}
{{Form::text('nb_canape_lit','')}}
<br/>

<h2 aria-level="2" role="heading">{{trans('form.title_interieur')}}</h2>

{{Form::label('cuisine_inde',trans('form.cuisine_inde'))}}
{{Form::checkbox('cuisine_inde',true)}}
<br/>

{{Form::label('cuisine_americaine',trans('form.cuisine_americaine'))}}
{{Form::checkbox('cuisine_americaine',true)}}
<br/>

{{Form::label('kitchenette',trans('form.kitchenette'))}}
{{Form::checkbox('kitchenette',true)}}
<br/>

{{Form::label('s_a_m',trans('form.s_a_m'))}}
{{Form::checkbox('s_a_m',true)}}
<br/>

{{Form::label('salon',trans('form.salon'))}}
{{Form::checkbox('salon',true)}}
<br/>

{{Form::label('mezzanine',trans('form.mezzanine'))}}
{{Form::checkbox('mezzanine',true)}}
<br/>

{{Form::label('lodge',trans('form.lodge'))}}
{{Form::checkbox('lodge',true)}}
<br/>

{{Form::label('debarras',trans('form.debarras'))}}
{{Form::checkbox('debarras',true)}}
<br/>
<br/>
<br/>


<h2 aria-level="2" role="heading">{{trans('form.title_exterieur')}}</h2>
{{Form::submit('valider')}}
{{Form::close()}}