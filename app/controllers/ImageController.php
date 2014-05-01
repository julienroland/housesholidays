<?php

use Carbon\Carbon;

class ImageController extends BaseController {

	public function postImage( $id )
	{

    if(Helpers::isOk( $id )){

      $nb_photos = Propriete::find($id)->photoPropriete()->count();
       
      if( $nb_photos >= 15 ){

        return Response::json(trans('validation.custom.tropImage'),500);
      }

      $destinationPath = Config::get('var.upload_folder').Auth::user()->id.'/'.Config::get('var.propriete_folder').'/'.$id.'/';

      $timestamp = date('dmYhis');
    } 
  

   File::exists( $destinationPath ) or File::makeDirectory( $destinationPath , 0777, true);
   
   if(Input::hasFile('file')){

    $file = Input::file('file'); 

                // Declare the rules for the form validation.
    $rules = array('file'  => 'image|max:2000,mimes:jpg,jpeg,bmp');

    $data = array('file' => Input::file('file'));

                // Validate the inputs.
    $validation = Validator::make($data, $rules);

    if ($validation->fails())
    {	
     return Response::json('error', 400);
   }

   if(is_array($file))
   {	

     foreach($file as $part) {

      $imageType = ImageType::orderBy('width','desc')->get();

      $extension = ImageType::where('nom',Config::get('var.image_thumbnail'))->pluck('extension');

      $image = Image::make( Input::file('file')->getRealPath() );

      $filename = Helpers::toSlug(Helpers::addTimestamp( $part->getClientOriginalName(), null, $extension,  $timestamp ));

      $nb_ordre = Propriete::find($id)->photoPropriete()->max('ordre') + 1;

      $photoPropriete = new PhotoPropriete;

      $photoPropriete->url = $filename;

      $photoPropriete->ordre = $nb_ordre;

      $photoPropriete = Propriete::find( $id )->photoPropriete()->save($photoPropriete);

      $image->resize( 1200, 800, true )->save( $destinationPath.$filename );

      foreach( $imageType as $type){

        $filename = Helpers::toSlug(Helpers::addTimestamp( $part->getClientOriginalName(),'-'.$type->nom ,$type->extension , $timestamp));

        $image->resize( $type->width, $type->height, true )->save( $destinationPath.$filename );

      }
    }
  }
else //single file
{   

  $imageType = ImageType::orderBy('width','desc')->get();

  $extension = ImageType::where('nom',Config::get('var.image_thumbnail'))->pluck('extension');

  $image = Image::make( Input::file('file')->getRealPath() );

  $filename = Helpers::toSlug(Helpers::addTimestamp( $file->getClientOriginalName(), null, $extension,  $timestamp ));

  $nb_ordre = Propriete::find($id)->photoPropriete()->max('ordre') + 1;

  $photoPropriete = new PhotoPropriete;

  $photoPropriete->url = $filename;

  $photoPropriete->ordre = $nb_ordre;

  $photoPropriete = Propriete::find( $id )->photoPropriete()->save($photoPropriete);

  $image->resize( 1200, 800, true )->save( $destinationPath.$filename );

  foreach( $imageType as $type){

    $filename = Helpers::toSlug(Helpers::addTimestamp( $file->getClientOriginalName(),'-'.$type->nom ,$type->extension , $timestamp));

    $image->resize( $type->width, $type->height, true )->save( $destinationPath.$filename );

  }

}

if( Helpers::isOk($image) ) {

  $propriete = Propriete::find($id);

  $propriete->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 3;

  $propriete->save();

  return Response::json('success', 200);

} else {

	return Response::json('error', 400);
}

}
}

public function deletePhoto( $imageId, $proprieteId ){

  $photo = PhotoPropriete::find($imageId);
  
/**
*
* Si la photo existe bien en bdd
*
**/

if( $photo ){
  
/**
*
* défini le chemin 
*
**/

$destinationPath = public_path(). '/'.Config::get('var.upload_folder').'/'.Auth::user()->id.'/'.Config::get('var.propriete_folder').'/'.$proprieteId.'/';

/**
*
* Choper tous les types d'images
*
**/

$types = ImageType::all();

/**
*
* Si le fichier de base existe
*
**/

if(File::exists( $destinationPath.$photo->url )){

  /**
  *
  * On le supprime
  *
  **/
  
  File::delete( $destinationPath.$photo->url );

}

/**
*
* La même pour les différents types d'image
*
**/

foreach( $types as $type ){

  if(File::exists( $destinationPath.Helpers::addBeforeExtension($photo->url, $type->nom) )){

    File::delete( $destinationPath.Helpers::addBeforeExtension($photo->url, $type->nom) );

  }
}

$photo->delete();

if( $photo ){

  return Response::json('success', 200 );

}
}

}
}