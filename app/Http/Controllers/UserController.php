<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Group;
use App\Service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toJSON;

class UserController extends Controller{
    public function register(Request $request){
    	$nyumbakumi = new Group();
    	$nyumbakumi -> name = $request['nyumbaKumiName'];
    	if($nyumbakumi -> save()){
		    $user = new User();
		    if(User::where('phone', $request['phone'])->count() > 0 ){
		    	return redirect()->back()->with([
		    		'bg' => 'danger',
				    'message' => 'Sorry, That Phone Number is already in use'
			    ]);
		    }
		    $user -> phone = $request['phone'];
		    $user -> names = $request['names'];
		    $user -> idno = $request['idno'];
		    $user -> confirmed = 1;
		    $user -> admin = true;
		    $user -> group = $nyumbakumi->id;
		    if($request['password'] == $request['passwordCon']){
		    	$user -> password = bcrypt($request['password']);
		    }else{
		    	return redirect()->back()->with([
		    		'bg' => 'danger',
		    		'message' => 'Password Do Not Match'
			    ]);
		    }
		
		    if($request->hasFile('proffPic')){
			    $ext = $request->proffPic->extension();
			    if($ext!='jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'bmp' && $ext != 'gif' && $ext != 'svg'){
				    return redirect()->back()->with([
				    	'message' => 'Sorry, We don\'t permit that type of file',
					    'bg' => 'danger'
				    ]);
			    }else{
				    $randomString = str_random(30).'.'.$ext;
				    while(User::where('photo', '$randomString')->count() != 0){
					    $randomString = str_random(30).'.'.$ext;
				    }
				    if(!is_null($user->pic)){
					    try{
						    Storage::delete('public/proffPics/'.$user->pic);
					    }catch (Exception $e){}
				    }
				    $user -> photo = $randomString;
				    $request->proffPic->move( public_path('proffPics'), $randomString);
				    
			    }
		    }
		    if($user->save()){
		    	return redirect()->route('loginPage')->with([
		    		'bg' => 'success',
				    'message' => 'registration was successful, Please Login Now'
			    ]);
		    }
	    }else{
    		return redirect()->back()->with([
    			'bg' => 'danger',
			    'message' => 'Could not save User'
		    ]);
	    }
	    return redirect()->back();
    }
    
    public function login(Request $request){
    	if(Auth::attempt(['phone' => $request['phone'], 'password' => $request['password'], 'admin' => true])){
    		//create User and Forward to Home:
		    $user = User::where('phone', $request['phone'])->first();
		    return redirect()->route('home');
	    }else{
    		return redirect()->back()->with([
    			'bg' => 'danger',
			    'message' => 'Login Failed, Please recheck your Credentials'
		    ]);
	    }
    }
    
    public function logout(){
    	Auth::logout();
    	return redirect()->route('loginPage')->with([
    		'bg' => 'warning',
		    'message' => 'Good Bye..., '
	    ]);
    }
    
    public function loadHome(){
    	// Try and collect the different types of service types available
	    $serviceTypes = Service::where('group', Auth::user()->group)->distinct('type')->get();
	    $members = User::where('group', Auth::user()->group)
		            ->where('confirmed', true)
				    ->where('id', '!=', Auth::user()->id)
				    ->get();
	    $services = Service::where('group', Auth::user()->group)->get();
    	return view('home',[
    		'user' => Auth::user(),
		    'serviceTypes' => $serviceTypes,
		    'members' => $members,
		    'services' => $services
	    ]);
    }
    
    public function addMember(Request $request){
	    $member = new User();
	    if(User::where('phone', $request['phone'])->count() > 0 ){
		    return redirect()->back()->with([
			    'bg' => 'danger',
			    'message' => 'Sorry, That Phone Number is already in use'
		    ]);
	    }
	    $member -> phone = $request['phone'];
	    $member -> names = $request['names'];
	    $member -> idno = $request['idno'];
	    $member -> confirmed = false;
	    $member -> admin = true;
	    $member -> group = Auth::user()->group;
	    $member -> password = bcrypt($request['idno']);
	
	    if($request->hasFile('proffPic')){
		    $ext = $request->proffPic->extension();
		    if($ext!='jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'bmp' && $ext != 'gif' && $ext != 'svg'){
			    return redirect()->back()->with([
				    'message' => 'Sorry, We don\'t permit that type of file',
				    'bg' => 'danger'
			    ]);
		    }else{
			    $randomString = str_random(30).'.'.$ext;
			    while(User::where('photo', '$randomString')->count() != 0){
				    $randomString = str_random(30).'.'.$ext;
			    }
			    if(!is_null($member->pic)){
				    try{
					    Storage::delete('public/proffPics/'.$member->pic);
				    }catch (Exception $e){}
			    }
			    $member -> photo = $randomString;
			    $request->proffPic->move( public_path('proffPics'), $randomString);
			
		    }
	    }
	    if($member->save()){
		    return redirect()->route('home')->with([
			    'message' => 'Member Has Been Added, They will Have To Confirm This When They Log Into Their Device',
			    'bg' => 'success'
		    ]);
	    }
	    return redirect()->back()->with([
	    	'bg' => 'danger',
		    'message' => 'An Unknown Error Ocuured'
	    ]);
    }
    
    public function addService(Request $request){
	    $service = new Service();
	    $service -> name = $request['names'];
	    $service -> phone = $request['phone'];
	    $service -> group = Auth::user()->group;
	    if($request['serviceType'] == '' && $request['customServiceType'] == ''){
	    	return redirect()->back()->with([
	    		'bg' => 'danger',
			    'message' => 'You must select a service Type or enter a new one, Try Again'
		    ]);
	    }elseif ($request['serviceType'] != ''){
	    	$service -> type = $request['serviceType'];
	    }elseif ($request['customServiceType'] != ''){
	    	$service -> type = $request['customServiceType'];
	    }
	    
	    if($service -> save()){
	    	return redirect()->route('home')->with([
	    		'bg' => 'success',
			    'message' => 'Service Has been Successfully added'
		    ]);
	    }
	    return redirect()->back()->with([
	    	'bg' => 'danger',
		    'message' => 'Sorry, A Error occurred'
	    ]);
    }
    
    public function deleteMember(Request $request){
    	$memberToDelete = User::where('id', $request['memberId'])->first();
    	if($memberToDelete -> delete()){
    		return redirect()->route('home')->with([
    			'bg' => 'warning',
			    'message' => 'Member has been deleted'
		    ]);
	    }
	    
	    return redirect()->back()->with([
	    	'bg' => 'danger',
		    'message' => 'An error occurred'
	    ]);
    }
    
    public function deleteService(Request $request){
    	$serviceToDelete = Service::where('id', $request['serviceId']);
	    if($serviceToDelete -> delete()){
		    return redirect()->route('home')->with([
			    'bg' => 'warning',
			    'message' => 'Service has been deleted'
		    ]);
	    }
	    return redirect()->back()->with([
		    'bg' => 'danger',
		    'message' => 'An error occurred'
	    ]);
    }
    
    public function androidTestMessaging(Request $request){
    	$chat = new Chat();
    	$arr = json_decode($request['theJson'], true);
    	$phone = $arr["phone"];
    	$idno = $arr["idno"];
    	
    	$chat -> member = $request["phone"];
    	$chat -> member = "Member";
    	$chat -> group = 17;
    	$chat -> message = $request['idno'];
    	$chat -> message = "Niaje";
    	if($chat -> save()){
		    return $chat;
	    }else{
    		return "Failed";
	    }
    }
    
    public function androidLogin(Request $request){
    	$arr = json_decode($request['theJson'], true);
    	$phone = $arr['phone'];
    	$idno = $arr['idno'];
	    $user = User::where('phone', $phone)->where('idno', $idno)->first();
	    if(User::where('phone', $phone)->where('idno', $idno)->count() == 0){
	    	return json_encode(['login' => 'false']);
	    }else{
	    	return array_merge(json_decode($user, true), ['login' => 'true']);
	    }
    }
    
    public function confirmjoin(Request $request){
    	$arr = json_decode($request['theJson'], true);
    	$user = User::where('id', $arr['user'])->first();
    	$user -> confirmed = $arr['confirmed'];
    	if($user -> save()){
    		return json_encode(['confirmed' => true]);
	    }else{
		    return json_encode(['confirmed' => false]);
	    }
    }
    
    public function sendChat(Request $request){
    	$arr = json_decode($request['theJson'], true);
    	$user = User::where('id', $arr['user'])->first();
    	$chat = new Chat();
    	$chat -> message = trim($arr['message']);
    	if($chat -> message == ''){
    		return json_encode(['send' => false]);
	    }
    	$chat -> member = $user -> id;
    	$chat -> names = $user -> names;
    	$chat -> group = $user -> group;
    	if($chat -> save()){
		    //get all the remaining chats
		    $chatsToSend = Chat::where('group', $user -> group)->where('id', '>' , $arr['theLatestChat'])->get();
		    return json_encode($chatsToSend);
	    }else{
    		return json_encode(['send' => false]);
	    }
    }
    
    public function updateChat(Request $request){
	    $arr = json_decode($request['theJson'], true);
	    $user = User::where('id', $arr['user'])->first();
	    $chatsToSend = Chat::where('group', $user -> group)->where('id', '>' , $arr['theLatestChat'])->get();
	    return $chatsToSend;
    }
    
    public function adminSendChat(Request $request){
    	$user = User::where('id', $request['userid'])->first();
    	$chat = new Chat();
    	$chat -> message = $request['theMessage'];
    	if(trim($chat -> message) == ''){
    		return json_encode(['send' => false]);
	    }
    	$chat -> member = $user -> id;
    	$chat -> names = $user->names;
    	$chat -> group = $user -> group;
    	if($chat -> save()){
    		return 'success';
	    }else{
    		return 'fail';
	    }
    }
    
    public function requestChats(Request $request){
    	$chats = Chat::where('group', Auth::user()->group)->where('id', '>', $request['highestchat'])->orderBy('id', 'desc')->take(30)->get();
    	$response = "";
    	foreach($chats as $chat){
    		$response.= "
						<div class=\"alert alert-info\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Tooltip on left\">
                            <small><b><u>". $chat -> names ."</u> - ". $chat -> created_at ."</b></small>
                            <br>".
                            $chat -> message
                        ."</div>";
	    }
    	return $response;
    }
    
    public function androidgetservices(Request $request){
    	$arr = json_decode($request['theJson'], true);
    	$user = $arr['user'];
    	$group = User::where('id', $user)->first()->group;
    	$services = Service::where('group', $group)->get();
    	return $services;
    }
    
}
