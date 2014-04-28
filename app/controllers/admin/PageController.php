<?php

class Admin_PageController extends \Admin_BaseController{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$listPages = Page::with('pageTraduction')->get();

		return View::make('admin.page.index')
		->with(compact('listPages'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$page = Page::find($id)->with('pageTraduction')->first();

		return View::make('admin.page.edit',array('widget'=>array('editor','tab')))
		->with(compact('page'));


	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
		$input = Input::all();

		$page = Page::find($id)->with(array('pageTraduction','seo'))->first();
		$pageTraduction = PageTraduction::wherePageId( $page->id )->get();
		
		if(Helpers::isOk( $page )){

			foreach(Config::get('var.langId') as $key => $value){
				
				foreach($pageTraduction as $traduction){
					
					if(isset($traduction->langage_id) && $traduction->langage_id == $key ){

						$traduction->titre = $input['titre'][$key];
						$traduction->texte = $input['texte'][$key];

					}
					else{

						$pageTraduction = new PageTraduction;

						$pageTraduction->titre = $input['titre'][$key];
						$pageTraduction->texte = $input['texte'][$key];
						$pageTraduction->langage_id = $key;
						$pageTraduction->page_id = (int)$page->id;

						$pageTraduction->save();
						
					}
				}
dd($pageTraduction);
			}
			dd($pageTraduction);
			if(Helpers::isOk($page->seo)){



			}
		}
		dd($page);
		dd(Input::all());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
