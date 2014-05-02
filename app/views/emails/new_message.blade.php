Nouveau message de {{$user->prenom}} {{$user->nom}} <{{$user->email}}>

@if(Helpers::isOk($user->telephone))

Tél:{{$user->telephone}}

@endif

@if(Helpers::isOk($user->adresse))

Adresse:{{$user->adresse}}

@endif

@if(Helpers::isOk($user->depart))

Départ:{{$user->depart}}

@endif

@if(Helpers::isOk($user->arrive))

Arrive:{{$user->arrive}}

@endif

Message: {{$user->message}}