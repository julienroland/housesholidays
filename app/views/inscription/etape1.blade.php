{{Form::open(array('url'=>'inscription'))}}

{{Form::label('nom_bien','Entrez le nom du bien')}}
{{Form::text('nom_bien','',array('placeholder'=>'Avana Mostra'))}}
<br/>
{{Form::label('titre','Entrez le titre de l\'annonce')}}
{{Form::text('titre','',array('placeholder'=>'Petite maison de campagne'))}}
<br/>

{{Form::label('type_de_bien','Entrez le type du bien')}}
{{Form::select('type_de_bien',array('appartement','maison'))}}
<br/>
{{Form::label('nombre_personnes','Entrez le nombre de personne(s)')}}
{{Form::text('nombre_personnes','',array('placeholder'=>'2'))}}
<br/>
{{Form::label('nombre_chambres','Entrez le nombre de chambres')}}
{{Form::text('nombre_chambres','',array('placeholder'=>'2'))}}
<br/>
{{Form::label('nombre_sdb','Entrez le nombre de salle(s) de bains')}}
{{Form::text('nombre_sdb','',array('placeholder'=>'2'))}}
<br/>
{{Form::label('etape','Entrez l\'étage')}}
{{Form::text('etage','',array('placeholder'=>'2'))}}

<br/>
{{Form::label('taille_interieur','Entrez la superficie intérieur du bien')}}
{{Form::text('taille_interieur','',array('placeholder'=>'2'))}}
<br/>
{{Form::label('taille_exterieur','Entrez la superficie extérieur du bien')}}
{{Form::text('taille_exterieur','',array('placeholder'=>'2'))}}
<br/>
{{Form::label('description','Entrez la description de votre bien')}}
{{Form::textarea('description','')}}
<h2 aria-level="2" role="heading">Literie</h2>

{{Form::close()}}