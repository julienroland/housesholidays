@if($validation)
@if(isset($user))
<p>Merci {{$user->prenom .' ' . $user->nom}}, {{trans('validation.custom.valid')}}</p>


@else
<p>{{trans('validation.custom.valid')}}</p>
@endif
@else
@if(isset($message))
<p>{{$message}}</p>
@else
<p>{{trans('validation.custom.invalid')}}</p>
@endif
@endif
{{link_to(Lang::get('routes.index'),'Revenir à l\'accueil')}}