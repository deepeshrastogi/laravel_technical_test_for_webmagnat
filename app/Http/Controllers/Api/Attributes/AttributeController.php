<?php
namespace App\Http\Controllers\Api\Attributes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Attributes;
use Validator;

class AttributeController extends Controller {
    use ApiResponse;

    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['']]);
        $this->middleware('auth:api');
    }

    /**
     * user registration through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [ 
            'attribute_name' => 'required', 
            'attribute_value' => 'required', 
        ]);

        if ($validator->fails()) { 
            return $this->error($validator->errors());     
        }

        $attribute = Attributes::create([
            'attribute_name' => $request->attribute_name,
            'attribute_value' => $request->attribute_value,
        ]);

        return $this->success(['attribute' => $attribute]);  

    }

    /**
     * user registration through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function attributelist(Request $request) {
        $attribute = Attributes::all();
        return $this->success(['attribute' => $attribute]);  
    }


    

}
