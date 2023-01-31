<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Image;
use DB;
use Session;

class SupplierMenuSubMenuController extends Controller{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->loged_id     = Session::get('admin_id');
        $this->current_time = date("H:i:s");
        $this->random_number_one = rand(10000 , 99999).mt_rand(1000000000, 9999999999);
    }

    public function mainMenuList()
    {
        
        $menu = DB::table('tbl_menu')->get() ;
        $result = DB::table('tbl_menu')->orderBy('menu_name', 'asc')->get() ;
        return view('supplier.storeMenu.mainMenuList')->with('result', $result)->with('menu', $menu) ;
    }

    public function insertMenuInfo(Request $request)
    {
        $menu_name = $request->menu_name ;
        $supplier_id = Session::get('supplier_id');

        if ($menu_name == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_menu')
        ->where('menu_name', $menu_name)
        ->where('supplier_id', $supplier_id)
        ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                   = array() ;
        $data['menu_name']  = $menu_name ;
        $data['supplier_id']  = $supplier_id ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate ;

        $query = DB::table('tbl_menu')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function getAllMenu(Request $request)
    {

        $supplier_id = Session::get('supplier_id');
        $result = DB::table('tbl_menu')->where('supplier_id',$supplier_id)->orderBy('menu_name', 'asc')->get() ;

        return view('supplier.storeMenu.mainMenuData')->with('result', $result) ;
    }

    public function changeMenuStatus(Request $request)
    {
        $menu_id = $request->menu_id ;

        $status_check   = DB::table('tbl_menu')->where('id', $menu_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_menu')->where('id', $menu_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
        }

    }

    public function editMainMenu(Request $request)
    {
        $id = $request->id ;
        $value   = DB::table('tbl_menu')->where('id', $id)->first() ;

        return view('supplier.storeMenu.editMainMenu')->with('value', $value) ;
    }

    public function updateMenuInfo(Request $request)
    {
        $menu_name  = $request->menu_name ;
        $primary_id     = $request->primary_id ;

        if ($menu_name == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $category_count = DB::table('tbl_menu')
        ->where('menu_name', $menu_name)
        ->whereNotIn('id', [$primary_id])
        ->count() ;

        if ($category_count > 0) {
            echo "duplicate_found";
            exit() ;
        }

        $data                   = array() ;
        $data['menu_name']  = $menu_name ;
        $data['created_at']     = $this->rcdate ;

        $query = DB::table('tbl_menu')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function menuDelete(Request $request){
        $id = $request->id ;
        $count = DB::table('tbl_sub_menu')->where('menu_id', $id)->count() ;
        if ($count > 0) {
            echo "cused" ;
            exit() ;
        }

        $query = DB::table('tbl_menu')->where('id', $id)->delete() ;
        if ($query) {
            echo "success" ;
            exit();
        }else{
            echo "failed" ;
            exit() ;
        }
    }



#======================== SECONDARY CATEGORY SECTION ==============================#
    public function subMenuList()
    {

        $all_primarycategory = DB::table('tbl_menu')->where('status', 1)->get() ;
        return view('supplier.storeMenu.subMenuList')->with('all_primarycategory', $all_primarycategory) ;

    }

    public function getAllSubMenuData(Request $request)
    {
        $result = DB::table('tbl_sub_menu')
        ->join('tbl_menu', 'tbl_sub_menu.menu_id', '=', 'tbl_menu.id')
        ->select('tbl_sub_menu.*', 'tbl_menu.menu_name')
        ->orderBy('tbl_sub_menu.id', 'desc')
        ->get() ;

        return view('supplier.storeMenu.getAllSubMenuData')->with('result', $result) ;
    }


    public function insertSubMenuInfo(Request $request)
    {
        $menu_id      = $request->menu_id ;
        $sub_menu_name      = $request->sub_menu_name ;
        $supplier_id = Session::get('supplier_id');


        if ($sub_menu_name == "" || $menu_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_sub_menu')
        ->where('menu_id', $menu_id)
        ->where('sub_menu_name', $sub_menu_name)
        ->where('supplier_id', $supplier_id)
        ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                   = array() ;
        $data['menu_id']        = $menu_id ;
        $data['sub_menu_name']  = $sub_menu_name ;
        $data['supplier_id']  = $supplier_id ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate ;

        $query = DB::table('tbl_sub_menu')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }


    public function changeSubMenuStatus(Request $request)
    {
        $sub_menu_id = $request->sub_menu_id ;

        $status_check   = DB::table('tbl_sub_menu')->where('id', $sub_menu_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_sub_menu')->where('id', $sub_menu_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
        }
    }

    public function editSubMenu(Request $request)
    {
        $id = $request->id ;
        $value   = DB::table('tbl_sub_menu')->where('id', $id)->first() ;
        $all_primarycategory = DB::table('tbl_menu')->where('status', 1)->get() ;

        return view('supplier.storeMenu.editSubMenu')->with('value', $value)->with('all_primarycategory', $all_primarycategory) ;
    }

    public function updateSubMenuInfo(Request $request)
    {
        $menu_id    = $request->menu_id ;
        $sub_menu_name          = $request->sub_menu_name ;
        $primary_id             = $request->primary_id ;

        if ($sub_menu_name == "" || $menu_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_sub_menu')
        ->where('menu_id', $menu_id)
        ->where('sub_menu_name', $sub_menu_name)
        ->whereNotIn('id', [$primary_id])
        ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['menu_id']        = $menu_id ;
        $data['sub_menu_name']    = $sub_menu_name ;
        $data['created_at']                 = $this->rcdate ;

        $query = DB::table('tbl_sub_menu')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function subMenuDelete(Request $request)
    {
        $id = $request->id ;
        $count = DB::table('tbl_sub_sub_menu')->where('sub_menu_id', $id)->count() ;
        if ($count > 0) {
            echo "cused" ;
            exit() ;
        }

        $query = DB::table('tbl_sub_menu')->where('id', $id)->delete() ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }


#========================== TERTIARY CATEGORY SECTION  ========================#
    public function subSubMenuList()
    {
        $menu = DB::table('tbl_menu')->where('status', 1)->get() ;

        return view('supplier.storeMenu.subSubMenuList')->with('menu', $menu) ;
    }

    public function getAllSubSubMenuData(Request $request)
    {
        $result = DB::table('tbl_sub_sub_menu')
        ->join('tbl_menu', 'tbl_sub_sub_menu.menu_id', '=', 'tbl_menu.id')
        ->join('tbl_sub_menu', 'tbl_sub_sub_menu.sub_menu_id', '=', 'tbl_sub_menu.id')
        ->select('tbl_sub_sub_menu.*', 'tbl_menu.menu_name', 'tbl_sub_menu.sub_menu_name')
        ->orderBy('tbl_sub_sub_menu.id', 'desc')
        ->get() ;

        return view('supplier.storeMenu.getAllSubSubMenuData')->with('result', $result) ;
    }

    public function getSubMenuByMenu(Request $request)
    {
        $submenu = DB::table('tbl_sub_menu')
        ->where('menu_id', $request->menu_id)
        ->where('status', 1)
        ->get() ;

        return view('supplier.storeMenu.getSubMenuByMenu')->with('submenu', $submenu) ;
    }

    public function insertSubSubMenuInfo(Request $request)
    {
        $menu_id        = $request->menu_id ;
        $sub_menu_id      = $request->sub_menu_id ;
        $sub_sub_menu_name              = $request->sub_sub_menu_name ;
        $supplier_id = Session::get('supplier_id');


        if ($sub_sub_menu_name == "" || $menu_id == ""|| $sub_menu_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_sub_sub_menu')
        ->where('menu_id', $menu_id)
        ->where('sub_menu_id', $sub_menu_id)
        ->where('sub_sub_menu_name', $sub_sub_menu_name)
        ->where('supplier_id', $supplier_id)
        ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['menu_id']        = $menu_id ;
        $data['sub_menu_id']      = $sub_menu_id ;
        $data['sub_sub_menu_name']  = $sub_sub_menu_name ;
        $data['supplier_id']  = $supplier_id ;
        $data['status']                     = 1 ;
        $data['created_at']                 = $this->rcdate ;

        $query = DB::table('tbl_sub_sub_menu')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function changeSubSubMenuStatus(Request $request)
    {
        $sub_sub_menu_id = $request->sub_sub_menu_id ;

        $status_check   = DB::table('tbl_sub_sub_menu')->where('id', $sub_sub_menu_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_sub_sub_menu')->where('id', $sub_sub_menu_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
        }
    }


    public function editSubSubMenu(Request $request)
    {
        $id = $request->id ;
        $value = DB::table('tbl_sub_sub_menu')->where('id', $id)->first() ;

        $submenu  = DB::table('tbl_sub_menu')->where('menu_id', $value->menu_id)->where('status', 1)->get() ;

        $menu = DB::table('tbl_menu')->where('status', 1)->get() ;

        return view('supplier.storeMenu.editSubSubMenu')->with('value', $value)->with('menu', $menu)->with('submenu', $submenu) ;
    }

    public function updateSubSubMenuInfo(Request $request)
    {

        $menu_id        = $request->menu_id ;
        $sub_menu_id      = $request->sub_menu_id ;
        $sub_sub_menu_name    = $request->sub_sub_menu_name ;
        $primary_id                 = $request->primary_id ;

        if ($sub_sub_menu_name == "" || $menu_id == ""|| $sub_menu_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_sub_sub_menu')
        ->where('menu_id', $menu_id)
        ->where('sub_menu_id', $sub_menu_id)
        ->where('sub_sub_menu_name', $sub_sub_menu_name)
        ->whereNotIn('id', [$primary_id])
        ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['menu_id']        = $menu_id ;
        $data['sub_menu_id']      = $sub_menu_id ;
        $data['sub_sub_menu_name']     = $sub_sub_menu_name ;

        $data['created_at']                 = $this->rcdate ;

        $query = DB::table('tbl_sub_sub_menu')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function subSubMenuDelete(Request $request){
        $id = $request->id ;

        $query = DB::table('tbl_sub_sub_menu')->where('id', $id)->delete() ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }


// background color change
    public function menuBackgroundColor(){
        $color_info = DB::table('tbl_supplier_header_settings')->where('supplier_id', Session::get('supplier_id'))->first() ;
        return view('supplier.storeMenu.backgroundColor')->with('color_info', $color_info) ;
    }

    public function udpateSupplierHeaderSettings(Request $request)
    {
        $this->validate($request, [
            'background_color'  => 'required',
            'font_color'        => 'required',
            'hover_color'       => 'required',
        ]) ;

        $background_color   = trim($request->background_color);
        $font_color         = trim($request->font_color);
        $hover_color        = trim($request->hover_color);
        $primary_id         = trim($request->primary_id) ;

        $data                       = array() ;
        $data['background_color']   = $background_color ;
        $data['font_color']         = $font_color ;
        $data['hover_color']        = $hover_color ;
        $data['updated_at']         = $this->rcdate ;
        DB::table('tbl_supplier_header_settings')->where('id', $primary_id)->update($data) ;

        $notification = array(
            'message'       => 'Header Color Update Successfully', 
            'alert-type'    => 'success'
        );

        return Redirect::to('menuBackgroundColor')->with($notification);

    }

    public function insertMenuBackgroundColor(Request $request)
    {
        $color_code = $request->color_code ;
        $supplier_id = Session::get('supplier_id');

        if ($color_code == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_header_background_color')
        ->where('color_code', $color_code)
        ->where('supplier_id', $supplier_id)
        ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                   = array() ;
        $data['color_code']  = $color_code ;
        $data['supplier_id']  = $supplier_id ;
        $data['created_at']     = $this->rcdate ;

        $query = DB::table('tbl_header_background_color')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function getAllMenuBackgroundColor(Request $request)
    {

        $supplier_id = Session::get('supplier_id');
        $result = DB::table('tbl_header_background_color')->where('supplier_id',$supplier_id)->orderBy('id', 'DESC')->get() ;


        return view('supplier.storeMenu.getBackgroundData')->with('result', $result) ;
    }

    public function editMenuBackgroundColor(Request $request)
    {
        $id = $request->id ;
        $value   = DB::table('tbl_header_background_color')->where('id', $id)->first() ;
        return view('supplier.storeMenu.editBackgroundColor')->with('value', $value) ;
    }

    public function updateMenuBackgroundColor(Request $request)
    {
        $color_code  = $request->color_code ;
        $primary_id     = $request->primary_id ;

        if ($color_code == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $check_count = DB::table('tbl_header_background_color')
        ->where('color_code', $color_code)
        ->whereNotIn('id', [$primary_id])
        ->count() ;

        if ($check_count > 0) {
            echo "duplicate_found";
            exit() ;
        }

        $data                   = array() ;
        $data['color_code']  = $color_code ;
        $data['created_at']     = $this->rcdate ;

        $query = DB::table('tbl_header_background_color')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }


    // font color change
    public function menuFontColor(){
        $result = DB::table('tbl_header_font_color')->orderBy('id', 'DESC')->get() ;
        return view('supplier.storeMenu.menuFontColor')->with('result', $result) ;
    }


    public function getAllMenuFontColor(Request $request)
    {

        $supplier_id = Session::get('supplier_id');
        $result = DB::table('tbl_header_font_color')->where('supplier_id',$supplier_id)->orderBy('id', 'DESC')->get() ;


        return view('supplier.storeMenu.getMenuFontColorData')->with('result', $result) ;
    }

    public function editMenuFontColor(Request $request)
    {
        $id = $request->id ;
        $value   = DB::table('tbl_header_font_color')->where('id', $id)->first() ;

        return view('supplier.storeMenu.editMenuFontColor')->with('value', $value) ;
    }

    public function updateMenuFontColor(Request $request)
    {
        $color_code  = $request->color_code ;
        $primary_id     = $request->primary_id ;

        if ($color_code == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $check_count = DB::table('tbl_header_font_color')
        ->where('color_code', $color_code)
        ->whereNotIn('id', [$primary_id])
        ->count() ;

        if ($check_count > 0) {
            echo "duplicate_found";
            exit() ;
        }

        $data                   = array() ;
        $data['color_code']  = $color_code ;
        $data['created_at']     = $this->rcdate ;

        $query = DB::table('tbl_header_font_color')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    # UPLOAD HEADER BANNER AIMGE 
    public function headerbanner()
    {
        $banner_info = DB::table('tbl_supplier_header_banner')
            ->where('supplier_id', Session::get('supplier_id'))
            ->first() ;

        return view('supplier.storeMenu.headerbanner')->with('banner_info', $banner_info) ;
    }

    # UPDATE HEADER BANNER IMAGE 
    public function updatesupplierbannerimage(Request $request)
    {
        $this->validate($request, [
            'header_image'      => 'mimes:jpeg,jpg,png',
            'background_image'  => 'mimes:jpeg,jpg,png',
        ]);

        $header_image = $request->header_image ;
        $background_image = $request->background_image ;
        
        
        $check_count = DB::table('tbl_supplier_header_banner')->where('supplier_id', Session::get('supplier_id'))->count();
        
         $image = DB::table('tbl_supplier_header_banner')->where('supplier_id', Session::get('supplier_id'))->first() ;
         
         

        $data = array();
        $data['supplier_id'] = Session::get('supplier_id');
        
         if ($request->hasFile('header_image')) {
             if($image){
             $image_path = public_path('images/defult/' .$image->header_image??'');
             if ($image->header_image && file_exists($image_path)) {
                    unlink($image_path);
                }
             }
                
            $image = $request->file('header_image');
            
            
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1100,550)->save(base_path('public/images/defult/') . $new_image_name);
            $data['header_image']  = $new_image_name;
        }
        
        // if($header_image){
        //     $imageName = 'banner-'.$this->random_number_one.'.'.$request->header_image->extension();
        //     $request->header_image->move(public_path('images'), $imageName);
        //     $data['header_image'] = $imageName;
        // }
 
        if($background_image){
            $imageName = 'background-'.$this->random_number_one.'.'.$request->background_image->extension();
            $request->background_image->move(public_path('images'), $imageName);
            $data['background_image'] = $imageName;
        }
        
       
       $data['created_at']  = $this->rcdate;
       if ($check_count == 0) {
            $data['status']      = 1;
            DB::table('tbl_supplier_header_banner')->insert($data) ;
       }else{
            DB::table('tbl_supplier_header_banner')->where('supplier_id', Session::get('supplier_id'))->update($data) ;
       }
       


       $notification = array(
            'message'       => 'Header Banner Upload Successfully', 
            'alert-type'    => 'success'
        );
        return Redirect::to('headerbanner')->with($notification);
    }

}

