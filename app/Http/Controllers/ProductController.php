<?php namespace App\Http\Controllers;

use App\API\Connectors\APIProduct;
use App\API\Connectors\APITag;
use App\API\Connectors\APICategory;

use Response, Input, Collection, Session, BalinMail, Route, App, Cache;

/**
 * Used for Product Controller
 * 
 * @author agil
 */
class ProductController extends BaseController 
{	
	protected $controller_name 						= 'product';

	function __construct()
	{
		parent::__construct();

		if(Session::has('whoami'))
		{
			Session::put('API_token', Session::get('API_token_private'));
		}
		else
		{
			Session::put('API_token', Session::get('API_token_public'));
		}

		$this->page_attributes->title 				= 'BALIN.ID';
		$this->page_attributes->source 				= 'products.';
		$this->page_attributes->breadcrumb			=	[
															'Produk' 	=> route('balin.product.index'),
														];
		$this->take 								= 12;
	}

	/**
	 * function to generate view and display products of balin
	 * 
	 * 1. Check filter
	 * 2. Check page
	 * 3. Get data from API
	 * 4. Generate paginator
	 * 5. Generate breadcrumb
	 * 6. Generate view
	 * @return view
	 */
	public function index()
	{
		//1. Check filter
		$filters 									= null;
		$search 									= [];

		//1a. Filter of name
		if(Input::has('q'))
		{
			$search 								= 	['name'		=> Input::get('q')];
			$filters 								= 	[
															'name' 	=> 	Input::get('q')
														];
		}
		
		//1b. Filter of category
		if(Input::has('categories'))
		{
			$search['categories']					= Input::get('categories');
		}

		//1c. Filter of tag
		if(Input::has('tags'))
		{
			$search['tags']							= Input::get('tags');
		}

		//1d. Filter of label
		if(Input::has('label'))
		{
			$search['labelname']					= Input::get('label');
		}

		//1e. Filter for sorting
		if (Input::has('sort'))
		{
			$sort_item 							= explode('-', Input::get('sort'));
			$sort 								= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort								= ['name' => 'asc'];
		}

		//1f. Get filter remove
		$searchresult 							= '';
		$index 									= '';
		$activesearch							= [];
		foreach (Input::all() as $key => $value) 
		{
			if(in_array($key, ['tags', 'label', 'categories', 'q']))
			{
				$keys 								= [];
				// $query_string 					= Input::all();
				// unset($query_string['page']);
				// unset($query_string[$key]);
				// $searchresult[$value]			= route('balin.product.index', $query_string);
				// $index 							= $index.' '.$value;

				foreach ($value as $key2 => $value2) 
				{
					$keys 							= array_merge(explode('-', $value2), $keys);

					// create active filter & kategori aktif for mobile
					if ($key == 'categories')
					{
						$rename 					= 'Category: ' . str_replace('-', ' ', $value2);
						if ($value2 != 'pria' && $value2 != 'wanita') 
						{
							$activesearch[]			= ['value' => strtolower($rename), 'slug' => $value2, 'type' => 'categories'];
						}
					} 
					else
					{
						$rename						= preg_replace('/ /', ': ', str_replace('-', ' ', $value2), 1);
						$activesearch[]				= ['value' => strtolower($rename), 'slug' => $value2, 'type' => 'tags'];
					}

				}
				$keys_modified 						= array_unique($keys);
				
				$keys_final_modified 				= implode(' ', $keys_modified);
				$searchresult 						= $searchresult.' '.ucwords($keys_final_modified);
			}
		}

		//2. Check page
		if (is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}


		// dd($search);
		//3. Get data from API
		//3a. API Product

		// get cache
		$qs 										= http_build_query($search);

		$product 									= Cache::get("product" . $qs);	


		if($product == null){		
			// get data from API
			$APIProduct 							= new APIProduct;

			$product 								= $APIProduct->getIndex([
															'search' 	=> $search,
															'sort' 		=> $sort,
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);


			// save cache
			Cache::put("product" . $qs, $product, $this->ttlCache);
		}


		// throw 404 if no data
		if($product['data']['count'] == 0){
			App::abort(404);
		}


		if(Input::has('categories'))
		{
			$linked_search 							= ['categories' => [Input::get('categories')[0]]];
		}
		else
		{
			$linked_search 							= [];
		}

		$offer['data']['data'] 						= [];
		if(!count($product['data']['data']))
		{
			// Get from cache
			$offer 									= Cache::get("offer[". $linked_search['categories'][0]  ."]");

			if($offer == null){
				$offer 								= $APIProduct->getIndex([
															'search' 	=> $linked_search,
															'sort' 		=> ['newest' => 'desc'],
															'take'		=> 3,
															'skip'		=> 0,
														]);

				// strore cache
				Cache::put("offer[". $linked_search['categories'][0]  ."]", $offer, $this->ttlCache);
			}
		}

		//3c. API Filters

		// Get filters from cache
		$get_api_tag 								= Cache::get("filter[". $linked_search['categories'][0]  ."]");	


		if($get_api_tag == null){
			$API_tag 								= new APITag;
			$get_api_tag							= $API_tag->getIndex([
															'search' 	=> 	$linked_search,
															'sort' 		=> 	[
																				'path'	=> 'asc',
																			],
														]);

			// strore cache
			Cache::put("filter[". $linked_search['categories'][0]  ."]", $get_api_tag, $this->ttlCache);
		}



		$color_chart 								= $this->getcolorchart();
		
		foreach ($get_api_tag['data']['data'] as $k => $v)
		{
			if (isset($v['tag']) && (strtolower($v['tag']['slug'])=='warna'))
			{
				$get_api_tag['data']['data'][$k]['code']	= (isset($color_chart[strtolower($v['name'])]) ? $color_chart[strtolower($v['name'])] : '#000');
			}
		}

		//3e. Manage data in collection
		// $collection_category						= new Collection;
		// $collection_category->add($get_api_category['data']['data']);

		// $collection_tag 							= new Collection;
		// $collection_tag->add($get_api_tag['data']['data']);

		// $category 									= $collection_category->sortBy('name')->all();
		// $tag 										= $collection_tag->sortBy('name')->all();

		//4. Generate paginator
		$this->paginate(route('balin.product.index'), $product['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb										= 	[
																'Produk' => route('balin.product.index')
															];

		if(Input::has('page') && Input::get('page') > 1)
		{
			$breadcrumb['Halaman '.Input::get('page')]	= route('balin.product.index', ['page' => Input::get('page')]);
		}

		//6. Generate view
		$this->page_attributes->search 				= $searchresult;

		$this->page_attributes->subtitle 			= 'Produk Batik Modern ' . (!empty($index) ? $index . '' : '') . (Input::has('page') ? 'Halaman ' . Input::get('page') . ' ' : '') . (!is_null($searchresult) ? str_replace('-', ' ', $searchresult) : '');
		$this->page_attributes->controller_name 	= $this->controller_name;
		$this->page_attributes->data				= 	[
															'offer' 			=> $offer['data']['data'],
															'product' 			=> $product['data']['data'],
															'type'				=> explode('0', Input::get('categories')[0])[0],
															'tag'				=> $get_api_tag['data']['data'],
															'linked_search'		=> $linked_search,
															'active_search'		=> $activesearch	
														];
		// $this->page_attributes->active_search 		= $active_search

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	/**
	 * function to generate view and display spesific product of balin
	 * 
	 * @return view, redirect route
	 */
	public function show($slug = null)
	{
		//1. Check product
		$API_product 							= new APIProduct;
		$product 								= $API_product->getIndex([
														'search' 	=> 	[
																			'slug' 	=> $slug,
																		],
													]);

		$type 									= 'pria';

		if($product['status'] != 'success')
		{
			$this->errors						= $product['message'];
		}
		elseif($product['data']['count'] < 1)
		{
			$this->errors 						= 'Tidak ada data.';
		}
		else
		{
			$categories 						= $product['data']['data'][0]['categories'];
			$slugs								= [];

			foreach ($categories as $key => $value) 
			{
				$slugs[]						= $value['slug'];

				if(str_is('pria*', $value['slug']) )
				{
					$type 						= 'pria';
				}
				else
				{
					$type 						= 'wanita';
				}
			}

			//2. Get Related product
			$search 							= 	[
														'categories' 	=> $slugs,
														'notid' 		=> $product['data']['data'][0]['id'],
													];

			$qs 								= http_build_query($search);

			//get from cache
			$related 							= Cache::get($qs);	

			if($related == null){
				//if no cache get from api
				$related 						= $API_product->getIndex([
														'search' 	=> 	$search,
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> 8,
													]);	
					
				// store cache
				Cache::put($qs, $related, $this->ttlCache);
			}


			if(!count($related['data']['data']))
			{
				$search 						= 	[
														'categories' 	=> $type,
														'notid' 		=> $product['data']['data'][0]['id'],
													];

				$qs 							= http_build_query($search);

				//get from cache
				$related 						= Cache::get($qs);	

				if($related == null){
					//if no cache get from api
					$related 					= $API_product->getIndex([
														'search' 	=> 	$search,
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> 8,
													]);	

					// store cache
					Cache::put($qs, $related, $this->ttlCache);					
				}
			}

			$carts 									= Session::get('carts');

			//breadcrumb
			$breadcrumb								= 	[	
															ucwords($type)						=> route('balin.product.index', ['categories' => [$type]]),
															$product['data']['data'][0]['name'] => route('balin.product.show', $product['data']['data'][0]['slug'])
														];

			//generate View
			$this->page_attributes->subtitle 		= $product['data']['data'][0]['name'];
			$this->page_attributes->controller_name = $this->controller_name;
			$this->page_attributes->data			= 	[
															'product' 	=> $product,
															'related'	=> $related['data']['data'],
															'carts'		=> $carts,
															'type' 		=> $type,
														];

			$this->page_attributes->breadcrumb		= array_merge($breadcrumb);
			$this->page_attributes->source 			=  $this->page_attributes->source . 'show';

			return $this->generateView();
		}

		return $this->generateRedirectRoute('balin.product.index');
	}
}