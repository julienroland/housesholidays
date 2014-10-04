<?php

class RechercheController extends BaseController {

    /**
     * @var Propriete
     */
    private $propriete;

    function __construct(Propriete $propriete)
    {
        $this->propriete = $propriete;
    }

    /**
     * @param null $pays
     * @param null $region
     * @param null $sousRegion
     * @param int $paginate
     * @return mixed
     */
    public function carte($pays = null, $region = null, $sousRegion = null, $paginate = 10)
    {

        $proprietes = $this->propriete->home_carte($pays, $region, $paginate);

        $filariane = $this->fildarinane($pays, $region, $sousRegion);

        $typeBatimentList = TypeBatiment::listing(trans('form.typeHebergement'));

        $paysList = Pays::selectList();

        $imageType = imageType::whereNom(Config::get('var.image_standard'))->first();

        return $this->loadListingView($proprietes, $filariane, $pays, $region, $sousRegion, $typeBatimentList, $paysList, $imageType);

    }

    public function regionFromPays($pays_id)
    {
        $pays = Pays::findOrFail($pays_id);

        $data = $pays->region()->with('regionTraduction')->get();

        return Response::json(Helpers::each($data, array('regionTraduction.0.region_id', 'regionTraduction.0.nom')));

    }

    public function sousRegionFromRegion($region_id)
    {
        $region = Region::findOrFail($region_id);

        $data = $region->sousRegion()->with('sousRegionTraduction')->get();

        return Response::json(Helpers::each($data, array('sousRegionTraduction.0.sous_region_id', 'sousRegionTraduction.0.nom')));

    }

    private function fildarinane($pays = null, $region = null, $sousRegion = null)
    {
        if($pays === trans('general.monde'))
        {
            $pays = null;
        }

        $filariane = new stdClass();
        
        $filariane->pays = $pays;
        $filariane->region = $region;
        $filariane->sous_region = $sousRegion;

        return $filariane;
    }

    private function loadListingView($proprietes, $filariane, $pays, $region, $sousRegion, $typeBatimentList, $paysList, $imageType)
    {


        if (Helpers::isNotOk($pays) || $pays === trans('general.monde'))
        {
            $paysWithPropriete = $this->propriete->proprieteParPays();

            return View::make('listing.index', array('page' => 'listing'))
                ->with(compact('proprietes', 'imageType', 'paysWithPropriete', 'filariane', 'typeBatimentList', 'paysList'));
        } else if (Helpers::isNotOk($region))
        {
            $paysView = PaysTraduction::where('nom', $pays)->lang()->first();

            $regionWithPropriete = $this->propriete->proprieteParRegion($pays);

            return View::make('listing.index', array('page' => 'listing'))
                ->with(compact('proprietes', 'imageType', 'regionWithPropriete', 'filariane', 'typeBatimentList', 'paysList', 'paysView'));
        } else
        {
            $paysView = PaysTraduction::where('nom', $pays)->lang()->first();
            $regionView = RegionTraduction::where('nom', $region)->lang()->first();
            $sousRegionView = SousRegionTraduction::where('nom', $sousRegion)->lang()->first();

            $sousRegionWithPropriete = $this->propriete->proprieteParSousRegion($region);

            return View::make('listing.index', array('page' => 'listing'))
                ->with(compact('proprietes', 'imageType', 'sousRegionWithPropriete', 'filariane', 'typeBatimentList', 'paysList', 'paysView', 'regionView', 'sousRegionView'));
        }
    }
}



