<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\KeyObject;
use Illuminate\Http\Request;
use Exception;

class KeyController extends APIBaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_all_key()
    {
	$key_obj = KeyObject::all();
		
	return $this->sendResponse($key_obj,'get all keys completed');
    	
    }

    public function get_key($key_id = '', Request $request)
    {
		$data = $request->all();
		$timestamp = null;

		if(array_key_exists('timestamp', $data) == true)
			$timestamp = $data['timestamp'];

		if($timestamp == null)
			$key_obj = KeyObject::where('key_id', $key_id)->get();
		else
		{
			$datetimeFormat = 'Y-m-d H:i:s';
			$dt = new \DateTime();
		
			$dt->setTimestamp($timestamp);
			$my_date = $dt->format($datetimeFormat);

			$key_obj = KeyObject::where('key_id', $key_id)->where('updated_at', $my_date)->get();
		}


		return $this->sendResponse($key_obj,'get key completed');
    	
    }


    public function add_key(Request $request)
    {
    	$data = $request->getContent();
	  	$data_obj = json_decode($data, true);

	  	if($data_obj == null)
	  		return $this->sendError('Data cannot be decoded', 400);

	  	foreach($data_obj as  $key => $value)
	  	{
	  		if(is_string($value) == true)
	  		{
	  			$key_obj = KeyObject::where('key_id', $key)->first();

		  		if($key_obj)
		  		{
		  			$key_obj->value = $value;
		  			$key_obj->save();
		  		}
		  		else
		  		{
		  			$key_obj = KeyObject::create([
		  				'key_id' => $key,
		  				'value' => $value
	  				]);
		  		}
	  		}
  		
	  	}

    	return $this->sendResponse('', 'add key completed');
    }

}
