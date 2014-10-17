<?php
use Intervention\Image\ImageServiceProvider;
class CompanyProfileController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$user = Auth::user();
		//$profile = User::find(1)->company_profile;
		//$profile = $user->profile?: new CompanyProfile;
		$profile =CompanyProfile::firstOrCreate(array('user_id' => $user->id));
		//$profile->user_id = $user->id;
		//$profile->save();
		//$profile = $user->company_profile ?: new CompanyProfile;
		//$profile = CompanyProfile::find(1)->user; //->company_profile;
		//return var_dump($profile);
		$host_path = Config::get('app.host_path');
		$profile->image = $host_path.$profile->image;
		return Response::json($profile);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{



			$rules = array(
		    //'user_id'       => 'required|integer|exists:users,id',
		    'company_name'  => 'required|alphaNum',
		    'designation'   => 'required|alphaNum',
			'company_email' => 'required|email', 
			'membership_number'      => 'required|alphaNum',
			'trade_license_number'   => 'required|alphaNum',
			'image'		    => 'image',

		);
	$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{
			$user = Auth::user();
			$profile = CompanyProfile::firstOrCreate(array('user_id' => $user->id));

			//$profile->user_id	= Input::get('user_id');
			$profile->company_name = Input::get('company_name');
			$profile->designation  = Input::get('designation');
			$profile->company_email = Input::get('company_email');
			$profile->membership_number = Input::get('membership_number');
			$profile->trade_license_number = Input::get('trade_license_number');
			$profile->image = Input::file('image');

			// $pathToFile = public_path().'/images/dd.jpg';
			// $img=Image::make(Input::file('image')->getRealPath())->save($pathToFile);
			// return $img->response(); //$img->response('jpg');
			// $profile->image = $pathToFile;

if(Input::file('image')!= null){
$image = Input::file('image');
$filename      = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)).'-'.time(). '.' . $image->getClientOriginalExtension();
$relative_path = 'images/profile/' . $filename;
$path = public_path($relative_path);
Image::make($image->getRealPath())->save($path);
$profile->image = $relative_path;
}

//     ->resize(870, null, true, false)

			}

			$profile->save();
			return Response::json(array('status'=>'success'));
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
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
