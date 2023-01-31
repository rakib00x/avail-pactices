<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use Str;
use Input;
use Hash;
use Mail;
use Response;
use Pusher\Pusher;

class ChatController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate               = date('Y-m-d');
        $this->logged_id            = Session::get('admin_id');
        $this->current_time         = date('H:i:s');
        $this->current_date_time    = date("Y-m-d H:i:s") ;
        $this->random_number_one    = rand(10000 , 99999).mt_rand(1000000000, 9999999999);
    }
    
    public function insertProductChatInfo(Request $request)
    {
        $product_id     = $request->product_id;
        $supplier_id    = $request->receiver_id;
        $sender_id      = $request->sender_id;
        $product_name   = $request->product_name;
        
        
        if($product_id > 0){
            $productQuery = DB::table('tbl_product')->where('id',$product_id)->first();
            $product_images = $productQuery->products_image;
    
            $array = explode("#",$product_images);
            $image = $array[0];
    
            $product_count = DB::table('tbl_messages')->where('product_id', $product_id)->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();
            if($product_count == 0){
                $message = array();
                $message['chatting_id'] = 0;
                $message['sender_id']   = $sender_id;
                $message['receiver_id'] = $supplier_id;
                $message['product_id']  = $product_id;
                $message['message']     = $productQuery->product_name;
                $message['image']       = $image;
                $message['is_read']     = 0;
                $message['created_at']  = $this->rcdate;
                $query = DB::table('tbl_messages')->insert($message);
            }

            $messageCount = DB::table('tbl_messages')->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();

        }else{

            $messageCount = DB::table('tbl_messages')->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();
            if($messageCount == 0){
                $message = array();
                $message['chatting_id'] = 0;
                $message['sender_id']   = $sender_id;
                $message['receiver_id'] = $supplier_id;
                $message['product_id']  = $product_id;
                $message['message']     = "Hello";
                $message['image']       = null;
                $message['is_read']     = 0;
                $message['created_at']  = $this->rcdate;
                $query = DB::table('tbl_messages')->insert($message);
            }
            
        }

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $sender_id, 'to' => $supplier_id]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);

    
        if($messageCount == 0){
            $scQuery = DB::table('express')->where('id', $supplier_id)->first();
            return view('chat.mainchatinfo')->with('scQuery', $scQuery);
        }else{
            echo "2";
        }
    }
    
    # NEW CHAT PERSON COUNT 
    public function newchatpersoncount(Request $request)
    {
        if (Session::get('supplier_id') != null) {
            $my_id      = Session::get('supplier_id') ;
        }else{
            $my_id      = Session::get('buyer_id') ;
        }
        
        $result = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->get() ;
        
        $total_count_user = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->count() ;

        if($total_count_user > 0){
            $data_main_chat                         = array();
            $data_main_chat['chat_person_count']    = 1;
            DB::table('tbl_messages')->where('receiver_id', $my_id)->update($data_main_chat) ;
        
            return view('chat.newchatpersoncount')->with('result', $result)->with('login_primary_id', $my_id);
            exit() ;
        }else{
            echo "2";
            exit() ;
        }
        
    }


    # NEW CHAT PERSON COUNT 
    public function newchatboxpersoncount(Request $request)
    {
        if (Session::get('supplier_id') != null) {
            $my_id      = Session::get('supplier_id') ;
        }else{
            $my_id      = Session::get('buyer_id') ;
        }
        
        $result = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->get() ;
        
        $total_count_user = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->count() ;

        if($total_count_user > 0){
            $data_main_chat                         = array();
            $data_main_chat['chat_person_count']    = 1;
            DB::table('tbl_messages')->where('receiver_id', $my_id)->update($data_main_chat) ;
        
            return view('chat.newchatboxpersoncount')->with('result', $result)->with('login_primary_id', $my_id);
            exit() ;
        }else{
            echo "2";
            exit() ;
        }
        
    }
    
    # NEW CHAT PERSON COUNT 
    public function getnewusermessagecount(Request $request)
    {
        if (Session::get('supplier_id') != null) {
            $my_id      = Session::get('supplier_id') ;
        }else{
            $my_id      = Session::get('buyer_id') ;
        }
        
        $result = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('tbl_messages.*', DB::raw('count(tbl_messages.id) as totalnewmessage'))
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.is_read', 0)
            ->groupBy('tbl_messages.sender_id')
            ->get() ;
        
        
        return $result ;
        
    }

    public function addChatPersonAndMessage(Request $request)
    {
        $product_id     = $request->product_id;
        $supplier_id    = $request->supplier_id;
        $product_name   = $request->product_name;

        $productQuery = DB::table('tbl_product')->where('id',$product_id)->first();
        $product_images = $productQuery->products_image;

        $array = explode("#",$product_images);
        $image = $array[0];

        $person = array();
        $person['supplier_id'] = $supplier_id;
        $person['customer_id'] = Session::get('buyer_id');
        $person['status']       = 1;
        $person['created_at'] = $this->rcdate;
        $person['updated_at'] = $this->rcdate;

       $personCount = DB::table('tbl_chatting_person')->where('supplier_id',$supplier_id)->where('customer_id',Session::get('buyer_id'))->count();

       if($personCount == 0){
           DB::table('tbl_chatting_person')->insert($person);
       }

        $messageCount = DB::table('tbl_messages')->where('product_id',$product_id)->where('sender_id',Session::get('buyer_id'))->where('receiver_id',$supplier_id)->count();

        if($messageCount == 0){

            $last_row = DB::table('tbl_chatting_person')->where('supplier_id',$supplier_id)->where('customer_id',Session::get('buyer_id'))->orderBy('id', 'desc')->first();

            $message = array();
            $message['chatting_id'] = $last_row->id;
            $message['sender_id']   = Session::get('buyer_id');
            $message['receiver_id'] = $supplier_id;
            $message['product_id']  = $product_id;
            $message['message']     = $product_name;
            $message['image']       = $image;
            $message['is_read']     = 1;
            $message['created_at']  = $this->rcdate;
            $query = DB::table('tbl_messages')->insert($message);

            if($query){
                return "1";
            }else{
                return "2";
            }
        }else{
            return "1";
        }

    }

    public function supplierChatBox()
    {
        $chattingpersonQuery = DB::table('tbl_chatting_person')
                ->join('express','tbl_chatting_person.customer_id','=','express.id')
                ->select('tbl_chatting_person.*','express.first_name','express.last_name','express.email','express.mobile','express.image')
                ->where('tbl_chatting_person.supplier_id', Session::get('supplier_id'))
                ->get();

    	return view('chat.supplierChatBox')->with('chattingpersonQuery',$chattingpersonQuery);
    }

    public function supplierChatBoxDetails($id)
    {

        Session::put('receiver_id',$id);

        $chattingpersonQuery = DB::table('tbl_chatting_person')
            ->join('express','tbl_chatting_person.customer_id','=','express.id')
            ->select('tbl_chatting_person.*','express.first_name','express.last_name','express.email','express.mobile','express.image')
            ->where('tbl_chatting_person.supplier_id', Session::get('supplier_id'))
            ->get();

        $receiverQuery = DB::table('express')->where('id',$id)->first();

        return view('chat.chat-details')
            ->with('chattingpersonQuery',$chattingpersonQuery)
            ->with('receiverQuery',$receiverQuery);
    }

    public function loadSupplierChat(Request $request)
    {
        $receiver_id = Session::get('receiver_id');

        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.sender_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image as rphoto','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id',[Session::get('supplier_id'),$receiver_id])
            ->whereIn('receiver_id',[$receiver_id,Session::get('supplier_id')])
            ->get();

        return view('chat.loadSupplierChat')->with('fetchingChat',$fetchingChat);
    }

    public function loadSupplierChatSabbir(Request $request)
    {
        $sender_id = Session::get('supplier_id');
        $receiver_id = Session::get('receiver_id');

        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.sender_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image as rphoto','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id',[Session::get('supplier_id'),$receiver_id])
            ->whereIn('receiver_id',[$receiver_id,Session::get('supplier_id')])
            ->get();

        $data = array();
        $data['is_read'] = 1;

        DB::table('tbl_messages')->whereIn('sender_id',[$sender_id,$receiver_id])->whereIn('receiver_id',[$receiver_id, $sender_id])->where('is_read',0)->update($data);

        return view('chat.loadSupplierChat')->with('fetchingChat',$fetchingChat);
    }

    # CHATING SECTION
    public function getMessage(Request $request)
    {

        $user_id    = $request->receiver_id ;
        if (Session::get('supplier_id') != null) {
            $my_id      = Session::get('supplier_id') ;
        }else{
            $my_id      = Session::get('buyer_id') ;
        }

        // Get all message from selected user
        $messages = DB::table('tbl_messages')->where(function ($query) use ($user_id, $my_id) {
            $query->where('sender_id', $user_id)->where('receiver_id', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('sender_id', $my_id)->where('receiver_id', $user_id);
        })->get();

        return view('chat.getMessage')->with('messages', $messages)->with('user_id', $user_id)->with('sender_id', $my_id) ;
    }

    public function message(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $receiver_id    = $request->receiver_id ;
        if (Session::get('supplier_id') != null) {
            $sender_id      = Session::get('supplier_id') ;
        }else{
            $sender_id      = Session::get('buyer_id') ;
        }
        $message_text   = $request->message_text ;

        $data                   = array();
        $data['chatting_id']    = 0 ;
        $data['receiver_id']    = $receiver_id ;
        $data['sender_id']      = $sender_id ;
        $data['message']        = $message_text ;
        $data['is_read']        = 0 ;
        $data['created_at']     = date("Y-m-d H:i:s") ;

        DB::table('tbl_messages')->insert($data) ;
        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $sender_id, 'to' => $receiver_id]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function getUnreadMessage(Request $request)
    {
        $receiver_id        = $request->receiver_id;
        Session::put('receiver_id',$receiver_id);
        
        if(Session::get('buyer_id') != NULL){
            $sender_id = Session::get('buyer_id');
        }else{
            $sender_id = Session::get('supplier_id');
        }

        $count = DB::table('tbl_messages')->where('receiver_id', $sender_id)->where('is_read',0)->count();

        if($count > 0){
            return "load";
        }else{
            return "sorry";
        }
    }

    public function getUnreadMessageSupplier(Request $request)
    {
        $sender_id = Session::get('supplier_id');
        $receiver_id = Session::get('receiver_id');

        $count = DB::table('tbl_messages')->whereIn('sender_id',[$sender_id,$receiver_id])->whereIn('receiver_id',[$receiver_id, $sender_id])->where('is_read',0)->count();

        if($count > 0){
            return "load";
        }else{
            return "sorry";
        }
    }

    public function loadMessages(Request $request)
    {
        $receiver_id = $request->receiver_id;
    
    	if(Session::get('buyer_id') != NULL){
    		$sender_id = Session::get('buyer_id');
    	}else{
    		$sender_id = Session::get('supplier_id');
    	}

        $receiverPhotoQuery = DB::table('express')->where('id',$receiver_id)->first();
        $rphoto = $receiverPhotoQuery->image;

        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.receiver_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id', [$sender_id, $receiver_id])
            ->whereIn('receiver_id', [$receiver_id, $sender_id])
            ->get();

            $data = array();
            $data['is_read'] = 1; 
            
            DB::table('tbl_messages')->where('receiver_id', $sender_id)->update($data);

        return view('chat.loadMessages')->with('fetchingChat',$fetchingChat)->with('rphoto',$rphoto)->with('sender_id', $sender_id)->with('receiver_id', $receiver_id);
    }

    public function loadMessagesSabbir(Request $request)
    {
        $receiver_id = Session::get('receiver_id');
        $sender_id = Session::get('buyer_id');

        $receiverPhotoQuery = DB::table('express')->where('id',$receiver_id)->first();
        $rphoto = $receiverPhotoQuery->image;

        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.receiver_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id',[$sender_id,$receiver_id])
            ->whereIn('receiver_id',[$receiver_id,$sender_id])
            ->get();

        $data = array();
        $data['is_read'] = 1;

        DB::table('tbl_messages')->whereIn('sender_id',[Session::get('buyer_id'),$receiver_id])->whereIn('receiver_id',[$receiver_id, Session::get('buyer_id')])->where('is_read',0)->update($data);

        return view('chat.loadMessages')->with('fetchingChat',$fetchingChat)->with('rphoto',$rphoto);
    }

    public function loadSupplierInfo(Request $request)
    {
        $receiver_id = $request->receiver_id;
        Session::put('receiver_id',$receiver_id);
        $sellerInfo = DB::table('express')->where('id',$receiver_id)->first();
        return $sellerInfo->first_name;
    }

    public function saveMessage(Request $request)
    {
        $message = $request->message;
        $attachment = $request->file('attachment');

        $receiver_id = $request->receiver_id;

        if(Session::get('supplier_id') != NULL){
            $sender_id = Session::get('supplier_id');
        }else{
            $sender_id = Session::get('buyer_id');
        }

        $data = array();

        if($attachment){
            $image_name        = Str::random(12);
            $ext               = strtolower($attachment->getClientOriginalExtension());
            $image_full_name   = $image_name.'.'.$ext;
            $upload_path       = "public/images/";
            $success           = $attachment->move($upload_path,$image_full_name);
            // with image
            $data['image']     = $image_full_name;
        }

        $data['sender_id'] = $sender_id;
        $data['receiver_id'] = $receiver_id;
        $data['product_id'] = 0;
        $data['message'] = $message;
        $data['is_read'] = 0;
        $data['chat_person_count'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');

        $query = DB::table('tbl_messages')->insert($data);

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $sender_id, 'to' => $receiver_id, 'messages'=> $message]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);

        if($query){
            return "1";
        }else{
            return "2";
        }

    }

    public function saveSupplierMessage(Request $request)
    {
        $message = $request->message;
        $attachment = $request->file('attachment');

        $receiver_id = Session::get('receiver_id');
        $sender_id = Session::get('supplier_id');

        $data = array();

        if($attachment){
            $image_name        = Str::random(12);
            $ext               = strtolower($attachment->getClientOriginalExtension());
            $image_full_name   = $image_name.'.'.$ext;
            $upload_path       = "public/images/chat/";
            $success           = $attachment->move($upload_path,$image_full_name);
            // with image
            $data['image']     = $image_full_name;
        }

        $data['sender_id'] = $sender_id;
        $data['receiver_id'] = $receiver_id;
        $data['product_id'] = 0;
        $data['message'] = $message;
        $data['is_read'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');

        $query = DB::table('tbl_messages')->insert($data);

        if($query){
            return "1";
        }else{
            return "2";
        }
    }
    
    # LASTEST CHAT MESSAGE 
    public function loadHeaderMessages(Request $request)
    {
        if(Session::get('buyer_id') != NULL){
    		$sender_id = Session::get('buyer_id');
    	}else{
    		$sender_id = Session::get('supplier_id');
    	}

        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.sender_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto', DB::raw('count(tbl_messages.id) as totalnewmessage'))
            ->where('tbl_messages.receiver_id', $sender_id)
            ->where('tbl_messages.is_read', 0)
            ->groupBy('tbl_messages.sender_id')
            ->get();


        return view('chat.loadHeaderMessages')->with('fetchingChat',$fetchingChat);
    }
    
    
        # MOBILE CHAT SECTION 
    public function mobilechat($receiver_id)
    {
        
    	if(Session::get('buyer_id') != NULL){
    		$sender_id = Session::get('buyer_id');
    	}else{
    		$sender_id = Session::get('supplier_id');
    	}

        $receiverPhotoQuery = DB::table('express')->where('id',$receiver_id)->first();
        if($receiverPhotoQuery->image != "" || $receiverPhotoQuery->image != null){

            if(strpos($receiverPhotoQuery->image, "https") !== false){
                $rphoto = $receiverPhotoQuery->image ;
            } else{
                $rphoto = "public/images/".$receiverPhotoQuery->image;
            }
        }else{
            $rphoto = "public/images/Image 4.png";
        } 


        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.receiver_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id', [$sender_id, $receiver_id])
            ->whereIn('receiver_id', [$receiver_id, $sender_id])
            ->get();

        $data = array();
        $data['is_read'] = 1; 
            
        DB::table('tbl_messages')->where('receiver_id', $sender_id)->update($data);

        return view('mobile.mobilechat')->with('fetchingChat', $fetchingChat)->with('rphoto', $rphoto)->with('sender_id', $sender_id)->with('receiver_id', $receiver_id)->with('receiverPhotoQuery', $receiverPhotoQuery);
    }

    public function loadMobileMessages(Request $request)
    {
        $receiver_id = $request->receiver_id ;
        if(Session::get('buyer_id') != NULL){
    		$sender_id = Session::get('buyer_id');
    	}else{
    		$sender_id = Session::get('supplier_id');
    	}

        $receiverPhotoQuery = DB::table('express')->where('id',$receiver_id)->first();
        if($receiverPhotoQuery->image != "" || $receiverPhotoQuery->image != null){

            if(strpos($receiverPhotoQuery->image, "https") !== false){
                $rphoto = $receiverPhotoQuery->image ;
            } else{
                $rphoto = "public/images/".$receiverPhotoQuery->image;
            }
        }else{
            $rphoto = "public/images/Image 4.png";
        } 


        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.receiver_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id', [$sender_id, $receiver_id])
            ->whereIn('receiver_id', [$receiver_id, $sender_id])
            ->get();

        $data = array();
        $data['is_read'] = 1; 
            
        DB::table('tbl_messages')->where('receiver_id', $sender_id)->update($data);

        return view('mobile.loadMobileMessages')->with('fetchingChat', $fetchingChat)->with('rphoto', $rphoto)->with('sender_id', $sender_id)->with('receiver_id', $receiver_id)->with('receiverPhotoQuery', $receiverPhotoQuery);
    }

    public function saveMobileMessage(Request $request)
    {
        $message    = $request->message;
        $attachment = $request->file('attachment');

        $receiver_id = $request->receiver_id;

        if(Session::get('supplier_id') != NULL){
            $sender_id = Session::get('supplier_id');
        }else{
            $sender_id = Session::get('buyer_id');
        }

        $data = array();

        if($attachment){
            $image_name        = Str::random(12);
            $ext               = strtolower($attachment->getClientOriginalExtension());
            $image_full_name   = $image_name.'.'.$ext;
            $upload_path       = "public/images/";
            $success           = $attachment->move($upload_path,$image_full_name);
            // with image
            $data['image']     = $image_full_name;
        }

        $data['sender_id'] = $sender_id;
        $data['receiver_id'] = $receiver_id;
        $data['product_id'] = 0;
        $data['message'] = $message;
        $data['is_read'] = 0;
        $data['chat_person_count'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');

        $query = DB::table('tbl_messages')->insert($data);

                // pusher
                $options = array(
                    'cluster' => 'ap2',
                    'useTLS' => true
                );
        
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );
        
                $data = ['from' => $sender_id, 'to' => $receiver_id, 'messages'=> $message]; // sending from and to user id when pressed enter
                $pusher->trigger('my-channel', 'my-event', $data);
        

        if($query){
            return "1";
        }else{
            return "2";
        }

    }

    public function getMobileUnreadMessage(Request $request)
    {
        $receiver_id        = $request->receiver_id;
        
        if(Session::get('buyer_id') != NULL){
            $sender_id = Session::get('buyer_id');
        }else{
            $sender_id = Session::get('supplier_id');
        }

        $count = DB::table('tbl_messages')->where('receiver_id', $sender_id)->where('is_read',0)->count();

        if($count > 0){
            return "load";
        }else{
            return "sorry";
        }
    }

    public function mobilechatingperson()
    {
        if(Session::get('buyer_id') != NULL || Session::get('supplier_id') != null){
            if(Session::get('buyer_id') != NULL){
                $login_primary_id = Session::get('buyer_id');
            }else{
                $login_primary_id = Session::get('supplier_id');
            }
        }else{
            $login_primary_id =0 ;
        }
        
        if($login_primary_id == 0){
            return Redirect::to('m/signin');
        }

        $getSupplier = DB::table('tbl_messages')->where('sender_id',$login_primary_id)->orWhere('receiver_id',  $login_primary_id)->get();
        
        $allSupplierIds = array();
        $allSenderIds = array();
        foreach($getSupplier as $supplierChatValue){
            $allSupplierIds[]   = $supplierChatValue->receiver_id;
            $allSenderIds[]     = $supplierChatValue->sender_id;
            
            $data_main_chat                         = array();
            $data_main_chat['chat_person_count']    = 1;
            DB::table('tbl_messages')->where('receiver_id', $login_primary_id)->update($data_main_chat) ;
        }
        
        $mainSupplierMarge = array_merge($allSupplierIds, $allSenderIds);
        
        $uniqueArray = array_unique($mainSupplierMarge);

        return view('mobile.mobilechatingperson')->with('uniqueArray', $uniqueArray)->with('login_primary_id', $login_primary_id);
    }
    
    public function mobilenewchatpersoncount(Request $request)
    {
        if (Session::get('supplier_id') != null) {
            $my_id      = Session::get('supplier_id') ;
        }else{
            $my_id      = Session::get('buyer_id') ;
        }
        
        $result = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->get() ;
        
        $total_count_user = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->count() ;

        if($total_count_user > 0){
            $data_main_chat                         = array();
            $data_main_chat['chat_person_count']    = 1;
            DB::table('tbl_messages')->where('receiver_id', $my_id)->update($data_main_chat) ;
        
            return view('mobile.mobilenewchatpersoncount')->with('result', $result)->with('login_primary_id', $my_id);
            exit() ;
        }else{
            echo "2";
            exit() ;
        }
    }


    public function insertMoibleChatInfo($product_id, $supplier_id)
    {

        if(Session::get('buyer_id') != NULL || Session::get('supplier_id') != null){
            if(Session::get('buyer_id') != NULL){
                $login_primary_id = Session::get('buyer_id');
            }else{
                $login_primary_id = Session::get('supplier_id');
            }
        }else{
            $login_primary_id =0 ;
        }
        
        if($login_primary_id == 0){
            return Redirect::to('m/signin');
        }

        if($login_primary_id == $supplier_id){
            return back() ;
        }
    
        $sender_id      = $login_primary_id;


        
        if($product_id > 0){
            $productQuery = DB::table('tbl_product')->where('id',$product_id)->first();
            $product_images = $productQuery->products_image;
    
            $array = explode("#",$product_images);
            $image = $array[0];
    
            $product_count = DB::table('tbl_messages')->where('product_id', $product_id)->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();
            if($product_count == 0){
                $message = array();
                $message['chatting_id'] = 0;
                $message['sender_id']   = $sender_id;
                $message['receiver_id'] = $supplier_id;
                $message['product_id']  = $product_id;
                $message['message']     = $productQuery->product_name;
                $message['image']       = $image;
                $message['is_read']     = 0;
                $message['created_at']  = $this->rcdate;
                $query = DB::table('tbl_messages')->insert($message);
            }

            $messageCount = DB::table('tbl_messages')->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();

        }else{

            $messageCount = DB::table('tbl_messages')->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();
            if($messageCount == 0){
                $message = array();
                $message['chatting_id'] = 0;
                $message['sender_id']   = $sender_id;
                $message['receiver_id'] = $supplier_id;
                $message['product_id']  = $product_id;
                $message['message']     = "Hello";
                $message['image']       = null;
                $message['is_read']     = 0;
                $message['created_at']  = $this->rcdate;
                $query = DB::table('tbl_messages')->insert($message);
            }
            
        }

        return Redirect::to('m/chat/'.$supplier_id);
    }

    # MESSAGE BOX SECTION START HERE  
    public function loadMessagesForMessageBox(Request $request)
    {
        $receiver_id = $request->receiver_id;
    
    	if(Session::get('buyer_id') != NULL){
    		$sender_id = Session::get('buyer_id');
    	}else{
    		$sender_id = Session::get('supplier_id');
    	}

        $receiverPhotoQuery = DB::table('express')->where('id',$receiver_id)->first();
        $rphoto             = $receiverPhotoQuery->image;

        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.receiver_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id', [$sender_id, $receiver_id])
            ->whereIn('receiver_id', [$receiver_id, $sender_id])
            ->get();

        $data = array();
        $data['is_read'] = 1; 
        
        DB::table('tbl_messages')->where('receiver_id', $sender_id)->update($data);

        return view('chat.loadMessagesForMessageBox')->with('fetchingChat',$fetchingChat)->with('rphoto',$rphoto)->with('sender_id', $sender_id)->with('receiver_id', $receiver_id);
    }




}
