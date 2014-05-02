<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => "Le champ :attribute doit être accepté.",
    "active_url"       => "Le champ :attribute n'est pas une URL valide.",
    "after"            => "Le champ :attribute doit être une date postérieure au :date.",
    "alpha"            => "Le champ :attribute doit seulement contenir des lettres.",
    "alpha_dash"       => "Le champ :attribute doit seulement contenir des lettres, des chiffres et des tirets.",
    "alpha_num"        => "Le champ :attribute doit seulement contenir des chiffres et des lettres.",
    "array"            => "Le champ :attribute doit être un tableau.",
    "before"           => "Le champ :attribute doit être une date antérieure au :date.",
    "between"          => array(
        "numeric" => "La valeur de :attribute doit être comprise entre :min et :max.",
        "file"    => "Le fichier :attribute doit avoir une taille entre :min et :max kilobytes.",
        "string"  => "Le texte :attribute doit avoir entre :min et :max caractères.",
        "array"   => "Le champ :attribute doit avoir entre :min - :max éléments."
    ),
    "confirmed"        => "Le champ de confirmation :attribute ne correspond pas.",
    "date"             => "Le champ :attribute n'est pas une date valide.",
    "date_format"      => "Le champ :attribute ne correspond pas au format :format.",
    "different"        => "Les champs :attribute et :other doivent être différents.",
    "digits"           => "Le champ :attribute doit avoir :digits chiffres.",
    "digits_between"   => "Le champ :attribute doit avoir entre :min and :max chiffres.",
    "email"            => "Le format du champ :attribute est invalide.",
    "exists"           => "Le champ :attribute sélectionné n'existe pas.",
    "image"            => "Le champ :attribute doit être une image.",
    "in"               => "Le champ :attribute est invalide.",
    "integer"          => "Le champ :attribute doit être un entier.",
    "ip"               => "Le champ :attribute doit être une adresse IP valide.",
    "max"              => array(
        "numeric" => "La valeur de :attribute ne peut être supérieure à :max.",
        "file"    => "Le fichier :attribute ne peut être plus gros que :max kilobytes.",
        "string"  => "Le texte de :attribute ne peut contenir plus de :max caractères.",
        "array"   => "Le champ :attribute ne peut avoir plus de :max éléments.",
    ),
    "mimes"            => "Le champ :attribute doit être un fichier de type : :values.",
    "min"              => array(
        "numeric" => "La valeur de :attribute doit être supérieur à :min.",
        "file"    => "Le fichier :attribute doit être plus que gros que :min kilobytes.",
        "string"  => "Le texte :attribute doit contenir au moins :min caractères.",
        "array"   => "Le champ :attribute doit avoir au moins :min éléments."
    ),
    "not_in"           => "Le champ :attribute sélectionné n'est pas valide.",
    "numeric"          => "Le champ :attribute doit contenir un nombre.",
    "regex"            => "Le format du champ :attribute est invalide.",
    "required"         => "Le champ :attribute est obligatoire.",
    "required_if"      => "Le champ :attribute est obligatoire quand la valeur de :other est :value.",
    "required_with"    => "Le champ :attribute est obligatoire quand :values est présent.",
    "required_without" => "Le champ :attribute est obligatoire quand :values n'est pas présent.",
    "same"             => "Les champs :other doivent être identiques.",
    "size"             => array(
        "numeric" => "La taille de la valeur de :attribute doit être :size.",
        "file"    => "La taille du fichier de :attribute doit être de :size kilobytes.",
        "string"  => "Le texte de :attribute doit contenir :size caractères.",
        "array"   => "Le champ :attribute doit contenir :size éléments."
    ),
    "unique"           => "La valeur du champ :attribute est déjà utilisée.",
    "url"              => "Le format de l'URL de :attribute n'est pas valide.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => array(
        'valid'=> 'Votre compte est bien validé et activé.',
        'connect'=> 'Vous êtes maintenant connecté',
        'disconnect'=> 'Vous êtes maintenant déconnecté',
        'already_disonnect'=> 'Vous êtes déjà déconnecté',
        'invalid'=> 'La clé ne correspond pas',
        'account_already_active'=> 'Compte déjà activé',
        'send_message_to_you'=>'Vous ne pouvez vous envoyer un message à vous même',
        'key_invalid'=> 'Format de la clé invalide',
        'tropImage'=> 'Vous ne pouvez ajouter plus de :number images',
        'step1'=> 'Vos informations de l\'étape précédente ont bien été enregistrées',
        'step2'=> 'Vos informations sur votre batiment de l\'étape précédente ont bien été enregistrées',
        'step3'=> 'Vos informations sur la localisation de votre batiment de l\'étape précédente ont bien été enregistrées',
        'step4'=> 'Vos photos et videos de l\'étape précédente ont bien été enregistrées',
        'step5'=> 'Vos informations sur les tarifs de votre batiment de l\'étape précédente ont bien été enregistrées',
        'step6'=> 'Vos informations sur les disponibilites de votre batiment de l\'étape précédente ont bien été enregistrées',
        'step7'=> 'Vos coordonnées de l\'étape précédente ont bien été enregistrées',
        'favoris_add'=>'Favoris ajouté !',
        'favoris_delete'=>'Favoris supprimé !',
        'favoris_not_delete'=>'Erreur, favoris non supprimé !',
        'favoris_exist_deja'=>'Ce favoris existe déjà !'
        ),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(
        "name" => "Nom",
        "username" => "Pseudo",
        "email" => "E-mail",
        "first_name" => "Prénom",
        "last_name" => "Nom",
        "password" => "Mot de passe",
        "check_password" => "Vérification Mot de passe",
        "city" => "Ville",
        "country" => "Pays",
        "postal" => "Code Postal",
        "address" => "Adresse",
        "locality" => "Localité",
        "region" => "Région",
        "sous_region" => "Département/Province",
        "phone" => "Téléphone",
        "cgv" => "Conditions Générales de Vente",
        "mobile" => "Portable",
        "age" => "Age",
        "sex" => "Sexe",
        "gender" => "Genre",
        "day" => "Jour",
        "month" => "Mois",
        "year" => "Année",
        "hour" => "Heure",
        "minute" => "Minute",
        "second" => "Seconde",
        "title" => "Titre",
        "content" => "Contenu",
        "description" => "Description",
        "excerpt" => "Extrait",
        "date" => "Date",
        "time" => "Heure",
        "available" => "Disponible",
        "size" => "Taille",
        "mother_tongue" => "Langue maternelle",
        "spoken_language" => "Langue maternelle",
        "nom_propriete" => "Nom du bien",
        "type_propriete" => "Type de bien",
        "titre_propriete" => "Titre",
        "nb_personne" => "Nombre de personne(s)",
        "nb_chambre" => "Nombre chambre(s)",
        "nb_sdb" => "Nombre de salle de bains",
        "etage" => "etage",
        "taille_interieur" => "Surface intérieur",
        "taille_exterieur" => "Surface extérieur",
    ),

);
