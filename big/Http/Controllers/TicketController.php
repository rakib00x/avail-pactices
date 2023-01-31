<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;
use Image;

class TicketController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
        $this->current_date_time = date("Y-m-d H:i:s") ;
        $this->random_number_one = rand(10000 , 99999).mt_rand(1000000000, 9999999999);
    }

    # Ticket add form 
    public function ticketSection()
    {
        return view('supplier.ticket.ticketSection') ;
    }


    # INSERT TICKET INFO 
    public function insertTicketInfo(Request $request)
    {
        $this->validate($request , [
            'subject'   => 'required',
            'note'      => 'required',
            'image'     => 'mimes:jpeg,jpg,png',
        ]) ;

        $subject    = $request->subject ;
        $note       = $request->note ;
        $image      = $request->image ;

        $data = array() ;
        $data['ticket_number']  = rand(99999, 111111) ;
        $data['supplier_id']    = Session::get('supplier_id') ;
        $data['ticket_title']   = $subject ;
        $data['ticket_details'] = $note ;
        if ($image) {
            $imageName = 'ticket-'.$this->random_number_one.'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            Image::make('public/images/'.$imageName)->resize(360, 240)->save('public/images/'.$imageName);
            $data['image']      = $imageName;
        }
        $data['status']         = 0 ;
        $data['created_at']     = $this->current_date_time ;

       $query = DB::table('tbl_support_ticket')->insert($data) ;

        echo "success" ;
    }


    # TICKET DETAILS
    public function ticketDetails($ticket_number)
    {
        $ticket_value = DB::table('tbl_support_ticket')
            ->where('ticket_number', $ticket_number)
            ->first() ;

        return view('supplier.ticket.ticketDetails')->with('ticket_value', $ticket_value);
    }

    # TICKET ADMIN SECTION 
    public function allticket()
    {
        $result = DB::table('tbl_support_ticket')
            ->join('express', 'tbl_support_ticket.supplier_id', '=', 'express.id')
            ->select('tbl_support_ticket.*', 'express.first_name', 'express.last_name', 'express.email')
            ->orderBy('tbl_support_ticket.id', 'desc')
            ->where('tbl_support_ticket.status', 0)
            ->get() ;
        return view('admin.ticket.allticket')->with('result', $result) ;
    }


    # GET ADMIN TICKET DETAILS 
    public function getAdminTicketDetails(Request $request)
    {
        $ticket_id = $request->id ;

        $ticket_details = DB::table('tbl_support_ticket')
            ->join('express', 'tbl_support_ticket.supplier_id', '=', 'express.id')
            ->select('tbl_support_ticket.*', 'express.first_name', 'express.last_name', 'express.email')
            ->where('tbl_support_ticket.id', $ticket_id)
            ->first() ;

        return view('admin.ticket.getAdminTicketDetails')->with('ticket_details', $ticket_details) ;

    }

    # INSERT TICKET INFO 
    public function insetTicketReply(Request $request)
    {
        if($request->ticket_status == 0){
            $status = 0 ;
        }else{
            $status = 1 ;
        }

        $data                   = array() ;
        $data['status']         = $status;
        $data['ticket_reply']   = $request->ticket_reply;
        $data['updated_at']     = $this->current_date_time ;

        DB::table('tbl_support_ticket')->where('id', $request->primary_id)->update($data) ;

        echo "success" ;
    }
    
    # contact ADMIN SECTION 
    public function allcontact()
    {
        $result = DB::table('contact')->orderBy('id','desc')->get() ;
        return view('admin.contact.allcontact',compact('result')) ;
    }
    public function getAdminContact(Request $request)
    {
        $id = $request->id ;
        $contact_show = DB::table('contact')->where('id', $id)->first() ;
        return view('admin.contact.getContact')->with('contact_show', $contact_show) ;
    }
    public function showContact(Request $request)
    {
        $contact_id = $request->contact_id;
		$status_check   = DB::table('contact')->where('id', $contact_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 0) {
			$db_status = 1;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		
		$query = DB::table('contact')->where('id', $contact_id)->update($data) ;
		
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}
    }
    # DELETE PRODUCT ADS INFO 
  public function deleteContactForm(Request $request)
  {
      $query = DB::table('contact')->where('id', $request->id)->delete() ;

      if ($query) {
        echo "success" ;
        exit() ;
      }else{
        echo "failed" ;
        exit() ;
      }
  }

    # Ticket add form 
    public function sellerticketSection()
    {
        return view('seller.ticket.sellerticketSection') ;
    }

    public function sellerTicketDetails($ticket_number)
    {
        $ticket_value = DB::table('tbl_support_ticket')
            ->where('ticket_number', $ticket_number)
            ->first() ;

        return view('seller.ticket.ticketDetails')->with('ticket_value', $ticket_value);
    }


}
