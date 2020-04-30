<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
use Validator;
use URL;
use Cookie;
use Redirect;
use Input;
use App\User;
class IonicapiController extends Controller
{
	public function __construct()
	{
	    
	}
	
    public function getriderLocation(Request $req){
        $lat = $req -> get("lat");
        $lng = $req -> get("lng");
        $user_kind = $req -> get("user_kind");
        $user_id =$req -> get("user_id");
        
        DB::table('locations')
            ->where('user_id', $user_id)
            ->where('user_kind', $user_kind)
            ->update(array('lat' => $lat, 'lng' => $lng));
        
        $haversine = "(3959 * acos( cos( radians($lat) ) * cos( radians( locations.lat ) ) * cos( radians( locations.lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( locations.lat ) ) ) )";
        if($user_kind == 1){
            $results = DB::table('locations')
                ->join('driver_information', 'driver_information.user_id', '=', 'locations.user_id')
                ->select('locations.*', 'driver_information.icon', 'driver_information.car_name')
                ->selectRaw("{$haversine} AS distance")
                ->whereRaw("{$haversine} < ?", ['10'])
                ->where('user_kind', 1)
                ->where('locations.user_id', '!=', $user_id)
                ->get();
            $notification = DB::table('orders')
                ->select('*')
                ->where('driver_id', $user_id)
                ->where('flag', 0)
                ->first();
            if (!empty($notification)) {
                return json_encode(array("data" => $results, "notification_data" => $notification, "notification" => "request"));
            }
        }else{
            $results = DB::table('locations')
                ->join('driver_information', 'driver_information.user_id', '=', 'locations.user_id')
                ->select('locations.*', 'driver_information.icon', 'driver_information.car_name')
                ->selectRaw("{$haversine} AS distance")
                ->whereRaw("{$haversine} < ?", ['10'])
                ->where('user_kind', 1)
                ->get();
            $notification = DB::table('orders')
                ->select('*')
                ->where('rider_id', $user_id)
                ->where('flag', 1)
                ->first();
            if (!empty($notification)) {
                return json_encode(array("data" => $results, "notification_data" => $notification, "notification" => "accepted"));
            }
        }
        return json_encode(array("data" => $results));
    }

    public function getorderdata(Request $req){
        $lat = $req -> get("lat");
        $lng = $req -> get("lng");
        $user_id = $req -> get("user_id");
        $rider_id = $req -> get("rider_id");
        $user_kind = $req -> get("user_kind");
        $order_id = $req -> get("order_id");
        
        DB::table('locations')
            ->where('user_id', $user_id)
            ->where('user_kind', 1)
            ->update(array('lat' => $lat, 'lng' => $lng));
        
        $results = DB::table('locations')
            ->join('riders', 'riders.id', '=', 'locations.user_id')
            ->select('locations.*', 'riders.email', 'riders.phonenubmer', 'riders.firstname')
            ->where('locations.user_kind', 2)
            ->where('locations.user_id', $rider_id)
            ->first();

        $notification = DB::table('orders')
            ->select('*')
            ->where('driver_id', $user_id)
            ->where('flag', 0)
            ->first();
        $canceled = DB::table('orders')
            ->select('*')
            ->where('id', $order_id)
            ->where('flag', 2)
            ->first();
        $completed  = DB::table('orders')
            ->select('*')
            ->where('id', $order_id)
            ->where('flag', 3)
            ->first();
        if (!empty($notification)) {
            return json_encode(array("data" => $results, "notification_data" => $notification, "notification" => "request"));
        } 
        if (!empty($canceled)) {
            return json_encode(array("data" => $results, "canceled" => $canceled, "notification" => "canceled"));
        }
         if (!empty($completed)) {
            return json_encode(array("data" => $results, "completed" => $completed, "notification" => "completed"));
        }
        return json_encode(array("data" => $results));
    }
    public function checkstatus(Request $req){
        $order_id = $req -> get("order_id");
        $result = DB::table('orders')
                ->select('*')
                ->where('id', $order_id)
                ->where('flag', 1)
                ->first();
        if (!empty($result)) {
            if ($result->status == 1) {
                return json_encode(array("rideOn" => $result));
            } else if ($result->status == 2) {
                return json_encode(array("rejectRide" => $result));
            }
        }
        return json_encode(array('return' => "return"));
    }

    public function getdriver(Request $req){
		$origin_lat = $req -> get("origin_lat");
		$origin_lng = $req -> get("origin_lng");
		$destination_lat = $req -> get("destination_lat");
		$destination_lng = $req -> get("destination_lng");
		$rider_id = $req -> get("uid");
		$driver_id = $req -> get("did");
        $payment_id = $req -> get("payment_id");
        $showpickup = $req -> get("showpickup");
        $amount = $req -> get("amount");
        $distance = $req -> get("distance");
        $showdestination = $req -> get("showdestination");
        
		$id = DB::table('orders')->insertGetId(
            ['origin_lat' => $origin_lat, 'origin_lng' => $origin_lng, 'destination_lat' => $destination_lat, 'destination_lng' => $destination_lng, 'rider_id' => $rider_id, 'driver_id' => $driver_id, 'showpickup' => $showpickup, 'showdestination' => $showdestination, 'amount' => $amount, 'distance' => $distance, 'flag' => 0]
        );

        DB::table('payments')
            ->where('id', $payment_id)
            ->update(['order_id' => $id]);
        // return json_encode(array('id', $id));

        $result = DB::table('locations')
            ->select('locations.lat', 'locations.lng', 'orders.id', 'drivers.email', 'drivers.phonenubmer', 'drivers.city', 'drivers.profile', 'drivers.firstname', 'drivers.lastname')
            ->join('orders', 'orders.driver_id', '=', 'locations.user_id')
            ->join('drivers', 'drivers.id', '=', 'locations.user_id')
            ->where('orders.id', $id)
            ->where('locations.user_id', $driver_id)
            ->where('locations.user_kind', 1)
            ->first();
		return json_encode($result);
    }
    
    public function payWithStripe()
    {
        return view('paywithstripe');
    }
    public function postPaymentWithStripe(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            'amount' => 'required'
        ]);
        
        $input = $req->all();
        if ($validator->passes()) {         
            $input = array_except($input,array('_token'));            
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number'    => $req->get('card_no'),
                        'exp_month' => $req->get('ccExpiryMonth'),
                        'exp_year'  => $req->get('ccExpiryYear'),
                        'cvc'       => $req->get('cvvNumber'),
                    ],
                ]);
                if (!isset($token['id'])) {
                    \Session::put('error','The Stripe Token was not generated correctly');
                    return redirect()->route('stripe');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    // 'metadata' => ['order_id' => '6735'],
                    'amount'   => $req->get('amount'),
                    'description' => 'Add in wallet',
                    'application_fee_amount' => $req->get('amount')*10,
                    'transfer_data' => [
                        'destination' => 'acct_1EiQpRHQoRiZL0dj',
                    ],
                ]);
                if($charge['status'] == 'succeeded') {
                    /**
                    * Write Here Your Database insert logic.
                    */
                    \Session::put('success','Money add successfully in wallet');
                    return redirect()->route('stripe');
                } else {
                    \Session::put('error','Money not add in wallet!!');
                    return redirect()->route('stripe');
                }
            } catch (Exception $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripe');
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripe');
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripe');
            }
        }
        \Session::put('error','All fields are required!!');
        return redirect()->route('stripe');
    }

    public function createstripe(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'number' => 'required',
            'expMonth' => 'required',
            'expYear' => 'required',
            'cvc' => 'required',
        ]);
        
        $input = $req->all();
        if ($validator->passes()) {
            $input = array_except($input, array('_token'));            
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number'    => $req->get('number'),
                        'exp_month' => $req->get('expMonth'),
                        'exp_year'  => $req->get('expYear'),
                        'cvc'       => $req->get('cvc'),
                    ],
                ]);
                if (!isset($token['id'])) {
                    return json_encode(array('error' => 'The Stripe Token was not generated correctly'));
                }else{
                    $id = DB::table('payments')
                        ->insertGetId(
                        ['number' => $req->get('number'), 'token' => json_encode($token), 'exp_month' => $req->get('expMonth'), 'exp_year' => $req->get('expYear'), 'cvc' => $req->get('cvc'), 'rider_id' => $req->get('rider_id'), 'driver_id' => $req->get('driver_id'), 'flag' => 0]
                        );
                    return json_encode(array('success' => 'Money add successfully in wallet', 'token' => $token, 'id' => $id ));
                }
            } catch (Exception $e) {
                return json_encode(array('error' => $e->getMessage()));
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                return json_encode(array('error' => $e->getMessage()));
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                return json_encode(array('error' => $e->getMessage()));
            }
        }
        return json_encode(array('error' => 'All fields are required!!'));
    }

    public function stripepaydriver(Request $req){
        $order_id = $req->get('order_id');
        $amount = $req->get('amount');
        DB::table('orders')
            ->where('id', $order_id)
            ->update(['amount' => $amount]);
        return json_encode(array('success' => true));
    }

    public function chargestripe(Request $req){
        $token_id = $req->get('token_id');
        $id = $req->get('id');
        $data = DB::table('payments')
                    ->select('orders.amount', 'drivers.stripe_id')
                    ->join('orders', 'orders.id', '=', 'payments.order_id')
                    ->join('drivers', 'drivers.id', '=', 'payments.driver_id')
                    ->where('orders.amount', '>', 0)
                    ->where('payments.id', $id)
                    ->first();

        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try {
            $charge = $stripe->charges()->create([
                'card' => $token_id,
                'currency' => 'USD',
                'amount'   => $data->amount,
                'application_fee_amount' => $data->amount * 10,
                'description' => 'Add in wallet for Uber booking',
                'transfer_data' => [
                    'destination' => $data->stripe_id,
                ],
            ]);
            if($charge['status'] == 'succeeded') {
                DB::table('payments')
                    ->where('id', $id)
                    ->update(['flag' => 3]);
                $data = DB::table('payments')
                    ->join('orders', 'orders.id', '=', 'payments.order_id')
                    ->select('orders.id')
                    ->where('payments.id', $id)
                    ->first();
                DB::table('orders')
                    ->where('id', $data->id)
                    ->update(['flag' => 3]);
                return json_encode(array('success' => 'Money add successfully in wallet'));
            } else {
                return json_encode(array('error' => 'Money not add in wallet!!'));
            }
        } catch (Exception $e) {
            return json_encode(array('error' => $e->getMessage()));
        } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return json_encode(array('error' => $e->getMessage()));
        } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            return json_encode(array('error' => $e->getMessage()));
        }
        return json_encode(array('error' => 'All fields are required!!'));
    }

    public function cancelbooking(Request $req){
        $id = $req->get('id');

        DB::table('payments')
            ->where('id', $id)
            ->update(['flag' => 2]);
        $data = DB::table('payments')
            ->join('orders', 'orders.id', '=', 'payments.order_id')
            ->select('orders.id')
            ->where('payments.id', $id)
            ->first();
        DB::table('orders')
            ->where('id', $data->id)
            ->update(['flag' => 2]);

        return json_encode(array('success' => 'Your pickup was canceled!'));
    }
    public function payoutstripe(Request $req){

        $stripe = Stripe::make(env('STRIPE_SECRET'));
        // $account = $stripe->account()->create([
        //     'type' => 'custom',
        //     'country' => 'US',
        //     'email' => 'evan@ebroder.net'
        // ]);
        // $account = $stripe->account()->all();
        $token_id = $req->get('token_id');
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try {
            $charge = $stripe->payout()->create([
                'card' => $token_id,
                'currency' => 'USD',
                'amount'   => 50,
                'description' => 'Add in wallet',
            ]);
            if($charge['status'] == 'succeeded') {
                return json_encode(array('success' => 'Money add successfully in wallet'));
            } else {
                return json_encode(array('error' => 'Money not add in wallet!!'));
            }
        } catch (Exception $e) {
            return json_encode(array('error' => $e->getMessage()));
        } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return json_encode(array('error' => $e->getMessage()));
        } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            return json_encode(array('error' => $e->getMessage()));
        }
        return json_encode(array('error' => 'All fields are required!!'));
        \Stripe\Payout::create([
          "amount" => 400,
          "currency" => "usd",
        ]);
    }
    public function createstripeaccount(Request $req){
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $account = $stripe->account()->create([
          "type" => "custom",
          "country" => "US",
          "email" => "bob@example.com",
          "reqed_capabilities" => ["card_payments"]
        ]);

        if (!isset($account)) {
            \Session::put('error','The Stripe Token was not generated correctly');
            return redirect()->route('stripe');
        }
    }

    public function authstatuschang(Request $req){
        $user_id = $req -> get("user_id");
        $status = $req -> get("status");
        DB::table('driver_information')
            ->where('user_id', $user_id)
            ->update(['status' => $status]);
        return json_encode(array("return" => $status));
    }

    public function acceptrequest(Request $req){
        $id = $req -> get("id");
        $status = $req -> get("status");

        DB::table('orders')
            ->where('id', $id)
            ->where('flag', 0)
            ->update(['flag' => 1, 'status' => $status]);

        $result = DB::table('orders')
            ->join('riders', 'riders.id', '=', 'orders.rider_id')
            ->select('orders.*', 'riders.email', 'riders.phonenubmer', 'riders.firstname')
            ->where('orders.id', $id)
            ->first();
        return json_encode(array("data" => $result));
    }

    public function completeride(Request $req){
        $id = $req -> get("id");
        $flag = $req -> get("flag");

        DB::table('orders')
            ->where('id', $id)
            ->update(['flag' => 3]);
        DB::table('payments')
            ->where('order_id', $id)
            ->update(['flag' => 3]);
        return json_encode(array("success" => "Your pick-up has been successfully completed!"));
    }
    // public function authstatuschang(Request $req){
    //     return json_encode(array("return" => true));
    // }
    // public function authstatuschang(Request $req){
    //     return json_encode(array("return" => true));
    // }
	public function driverregister(Request $req){
		// $data = $req->json()->all();
		// $firstname = $data['firstname'];
		// $lastname = $data['lastname'];
		// $email = $data['email'];
		// $password = $data['password'];
		// $phonenumber = $data['phonenumber'];
		// $city = $data['city'];

		$firstname = $req -> get("firstname");
		$lastname = $req -> get("lastname");
		$email = $req -> get("email");
		$password = Hash::make($req -> get("password"));
		$phonenumber = $req -> get("phonenumber");
		$city = $req -> get("city");

		if($firstname != ""){
			$dbresult = DB::insert('insert into drivers (firstname, lastname, email, password, phonenubmer, city, approval) values (?, ?, ?, ?, ?, ?, ?)', [$firstname, $lastname, $email, $password, $phonenumber, $city, "unapproval"]);

			if ($dbresult == 1) {
	            return response()->json("succeed");
	        }
		}
        return response()->json("failed");
	}
    public function driversignin(Request $req)
    {

        $email = $req->get("email");
        $password = $req->get("password");
        $results = DB::select('select * from drivers where email = ?', [$email]);
        if (count($results) > 0) {
            foreach ($results as $value) {
                if (Hash::check($password, $value->password)) {
                    Session::put('driverid', $value->id);
                    $value->profile = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path() ."/" . $value->profile));
                    return response()->json(["status" => "suceed", "user" => $value]);
                }
            }
        }
        return response()->json("failed");
    }
    public function driveruploadprofile(Request $req)
    {

        $id = $req->input("id");
        $image = $req->input("profile");
        $image = base64_decode($image);
        $fileName = time() .".jpg";
        $file = public_path('profiles') . "/" . $fileName;
        file_put_contents($file, $image);

        DB::update('UPDATE drivers SET profile= ? WHERE id=?', ["profiles/$fileName", $id]);

        return response()->json(["status" => true, "image" => "profiles/$fileName"]);
    }
    public function driverlogout(Request $req)
    {

        Session::forget('driverid');
        if (Session::has('driverid'))
        {
            return response()->json("failed");
        }
        // return response()->json(["status" => "suceed", "user" => $value]);
        return response()->json("suceed");
        
    }

    public function driverupdate(Request $req){
        $id = $req -> get("id");
		$firstname = $req -> get("firstname");
		$lastname = $req -> get("lastname");
		$phonenumber = $req -> get("phonenumber");
		$city = $req -> get("city");
        $driverid = Session::get('driverid');

        // $dbresult = DB::update('UPDATE drivers SET firstname= ?, lastname= ?, phonenumber= ?, city= ? WHERE id= ?', [$firstname, $lastname, $phonenumber, $city, $id]);
        $dbresult = DB::update('update drivers set firstname = ?, lastname = ?, phonenubmer = ?, city = ? where id = ?', [$firstname, $lastname, $phonenumber,$city, $id]);
        if ($dbresult == 1) {
            return response()->json("succeed");
        }

        return response()->json("failed");
        //  return response()->json(["status" => "failed", "userid" => $firstname]);
	}	
	
	
    //RIDERS
    public function riderregister(Request $req){
		$firstname = $req -> get("firstname");
		$lastname = $req -> get("lastname");
		$email = $req -> get("email");
		$password = Hash::make($req -> get("password"));
		$phonenumber = $req -> get("phonenumber");
		$city = $req -> get("city");

		if($firstname != ""){
			$dbresult = DB::insert('insert into riders (firstname, lastname, email, password, phonenubmer, city, approval) values (?, ?, ?, ?, ?, ?, ?)', [$firstname, $lastname, $email, $password, $phonenumber, $city, "unapproval"]);
			if ($dbresult == 1) {
	            return response()->json("succeed");
	        }
		}
        return response()->json("failed");
	}
    public function ridersignin(Request $req)
    {

        $email = $req->get("email");
        $password = $req->get("password");
        $results = DB::select('select * from riders where email = ?', [$email]);
        if (count($results) > 0) {
            foreach ($results as $value) {
                if (Hash::check($password, $value->password)) {
                    Session::put('riderid', $value->id);
                    $value->profile = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path() ."/" . $value->profile));
                    return response()->json(["status" => "suceed", "user" => $value]);
                }
            }
        }
        return response()->json("failed");
    }
    public function rideruploadprofile(Request $req)
    {

        $id = $req->input("id");
        $image = $req->input("profile");
        $image = base64_decode($image);
        $fileName = time() .".jpg";
        $file = public_path('profiles') . "/" . $fileName;
        file_put_contents($file, $image);

        DB::update('UPDATE riders SET profile= ? WHERE id=?', ["profiles/$fileName", $id]);

        return response()->json(["status" => true, "image" => "profiles/$fileName"]);
    }
    public function riderlogout(Request $req)
    {

        Session::forget('riderid');
        if (Session::has('riderid'))
        {
            return response()->json("failed");
        }
        return response()->json("suceed");
        
    }

    public function riderupdate(Request $req){
        $id = $req -> get("id");
		$firstname = $req -> get("firstname");
		$lastname = $req -> get("lastname");
		$phonenumber = $req -> get("phonenumber");
		$city = $req -> get("city");
        $riderid = Session::get('riderid');
// if($id == $riderid){

        $dbresult = DB::update('update riders set firstname = ?, lastname = ?, phonenubmer = ?, city = ? where id = ?', [$firstname, $lastname, $phonenumber,$city, $id]);
        if ($dbresult == 1) {
            return response()->json("succeed");
        }
// }
        return response()->json("failed");
        //  return response()->json(["status" => "failed", "userid" => $firstname]);
	}	   	
}
