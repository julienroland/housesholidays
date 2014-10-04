<?php

class HomeController extends BaseController {

    /**
     * @var ListingController
     */
    private $listing;
    /**
     * @var Propriete
     */
    private $propriete;
    /**
     * @var ImageType
     */
    private $imageType;

    function __construct(ListingController $listing, Propriete $propriete, ImageType $imageType)
    {
        $this->listing = $listing;
        $this->propriete = $propriete;
        $this->imageType = $imageType;
    }

    public function index()
    {

        $typeBatimentList = TypeBatiment::listing(trans('form.typeHebergement'));

        $paysList = Pays::selectList();

        return View::make('index', array('page' => 'home', 'widget' => array('carte', 'datepicker')))->with(compact(array(
            'typeBatimentList',
            'paysList',
        )));
    }

    public function homeSearch()
    {

        $input = Input::all();

        Session::put('home_search', $input);

        $proprietes = $this->propriete->home_filter($input);

        $imageType = $this->imageType->findFormType(Config::get('var.image_standard'));

        $paysWithPropriete = $this->propriete->proprieteParPays($input);

        if ($proprietes->count() > 0)
        {
            if (Request::ajax())
            {
                return Response::json(array('success' => true));
            }

            return View::make('listing.index')
                ->with(compact('proprietes', 'imageType', 'paysWithPropriete'));

        } else
        {
            if (Request::ajax())
            {
                return Response::json(array('search_errors' => trans('general.aucun_resultat_recherche')));
            }

            return Redirect::back()
                ->with(array('search_errors' => trans('general.aucun_resultat_recherche')));
        }
    }

    public function quickSearch()
    {
        $q = Input::has('quickSearch') ? Input::get('quickSearch') : null;

        if (Helpers::isOk($q))
        {
            $pays = Pays::where('id', $q)
                ->with('paysTraduction')
                ->orWhere('initial_2', 'LIKE', $q . '%')
                ->orWhere('initial_3', 'LIKE', $q . '%')
                ->orWhere('code_telephone', 'LIKE', '%' . $q . '%')
                ->orWhere('extension_domaine', $q . '%')
                ->get();


            $paysTraduction = PaysTraduction::where(Config::get('var.lang_col'), Session::get('langId'))
                ->where('nom', 'LIKE', $q . '%')
                ->with(array('pays', 'pays.region.regionTraduction', 'pays.region.proprieteCountRelation', 'pays.proprieteCountRelation'))
                ->wherehas('pays', function ($query)
                {
                    $query->has('proprieteCountRelation');
                })
                ->distinct()
                ->get();

            // wherehas $paysTraduction->proprieteCountRelation
            if ($paysTraduction->count() <= 0)
            {

                $paysTraduction = PaysTraduction::where(Config::get('var.lang_col'), Session::get('langId'))
                    ->with(array('pays', 'pays.proprieteCountRelation', 'pays.region.proprieteCountRelation', 'pays.region.regionTraduction'))
                    ->whereHas('pays', function ($query) use ($q)
                    {
                        $query->whereHas('region', function ($query) use ($q)
                        {
                            $query->whereHas('regionTraduction', function ($query) use ($q)
                            {
                                $query->where('nom', 'LIKE', '%' . $q . '%');
                            });
                        });

                    })
                    ->distinct()
                    ->get();

            }

            return Response::json($paysTraduction, 200);
        }
    }

}