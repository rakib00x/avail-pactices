<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Image;
use DB;
use Session;

class SupplierColorController extends Controller{
	public function __construct(){
		date_default_timezone_set('Asia/Dhaka');
		$this->rcdate       = date('Y-m-d');
		$this->loged_id     = Session::get('admin_id');
		$this->current_time = date("H:i:s");
	}

	public function mainColorList()
	{
		$result = DB::table('tbl_color')->orderBy('color_name', 'asc')->get() ;
		return view('supplier.color.mainColorList')->with('result', $result) ;
	}

	public function getAllImages(Request $request)
	{
		$media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->get();
		return view('supplier.color.paginations')->with('media_result', $media_result);
	}

	public function fileStore(Request $request)
	{
		$image      = $request->file('file');
		$imageName  = $image->getClientOriginalName();
		$image->move(public_path('images'),$imageName);

		$data                   = array() ;
		$data['supplier_id']    = 0 ;
		$data['image']          = $imageName ;
		$data['status']         = 0 ;
		$data['created_at']     = $this->rcdate ;

		DB::table('tbl_media')->insert($data) ;

		return response()->json(['success'=>$imageName]);
	}

	public function fileDestroy(Request $request)
	{
		$file_value = DB::table('tbl_media')->where('image', $filename)->first();
		if ($file_value->status == 0) {
			$filename =  $request->get('filename');
			DB::table('tbl_media')->where('image', $filename)->delete() ;
			$path=public_path().'/images'.$filename;
			if (file_exists($path)) {
				unlink($path);
			}
			return $filename; 
		}

	}

	public function ColorSaveImage(Request $request)
	{
		$supplier_id = $request->supplier_id;
		$data = array();
		$data['status'] = 1 ;

		$query =  DB::table('tbl_media')->where('supplier_id', $supplier_id)->update($data) ;

		echo $query;
	}

	public function getSearchValue(Request $request)
	{
		$search_keyword = $request->search_keyword ;

		$media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->where('image', 'like', '% '.$search_keyword.' %')->get();
		return view('supplier.color.paginations')->with('media_result', $media_result);
	}

	public function insertPrimaryColorInfo(Request $request)
	{
		$color_name = $request->color_name ;
		$color_image = $request->color_image ;
		$supplier_id = Session::get('supplier_id');
		
		$color_count = DB::table('tbl_color')
		->where('color_name', $color_name)
		->where('supplier_id', $supplier_id)
		->count() ;

		if ($color_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($color_name == "" || $color_image == "") {
			echo "invalid_input" ;
			exit() ;
		}


		$data                = array();
		$data['color_name']  = $color_name ;
		$data['color_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $color_name)) ;
		$data['color_image'] = $color_image;
		$data['supplier_id'] = $supplier_id;
		$data['status']      = 1;
		$data['created_at']  = $this->rcdate ;

		$query = DB::table('tbl_color')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllPrimaryColor(Request $request)
	{
		$supplier = Session::get('supplier_id');
		$result = DB::table('tbl_color')->where('supplier_id',$supplier)->orderBy('color_name', 'asc')->get() ;

		return view('supplier.color.mainColorData')->with('result', $result) ;
	}

	public function changeColorStatus(Request $request)
	{
		$color_id = $request->color_id ;

		$status_check   = DB::table('tbl_color')->where('id', $color_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('tbl_color')->where('id', $color_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}

	}

	public function editMainColor(Request $request)
	{
		$id = $request->id ;
		$value   = DB::table('tbl_color')->where('id', $id)->first() ;
		return view('supplier.color.editMainColor')->with('value', $value) ;
	}

	public function updatePrimaryColorInfo(Request $request)
	{
		$color_name  = $request->color_name ;
		$color_image  = $request->color_image ;
		$primary_id     = $request->primary_id;

		if ($color_name == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$color_count = DB::table('tbl_color')
		->where('color_name', $color_name)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($color_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data                   = array() ;
		$data['color_name']  = $color_name ;
		$data['color_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $color_name)) ;
		$data['color_image']  = $color_image ;
		$data['created_at']     = $this->rcdate ;

		$query = DB::table('tbl_color')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function primaryColorDelete(Request $request)
	{
		$id = $request->id ;
		$query = DB::table('tbl_color')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}

	//supplier Size List
	public function sizeList()
	{
		$result = DB::table('tbl_size')->orderBy('size', 'asc')->get() ;
		return view('supplier.size.sizeList')->with('result', $result) ;
	}


	public function insertSizeInfo(Request $request)
	{
		$size = $request->size;
		$supplier_id = Session::get('supplier_id');

		
		$data_check = DB::table('tbl_size')
		->where('size', $size)
		->where('supplier_id', $supplier_id)
		->count() ;

		if ($data_check > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($size == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data                = array();
		$data['size']  = $size ;
		$data['supplier_id']  = $supplier_id ;
		$data['size_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $size)) ;
		$data['status']      = 1 ;
		$data['created_at']  = $this->rcdate ;

		$query = DB::table('tbl_size')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllSize(Request $request)
	{
		$supplier = Session::get('supplier_id');
		$result = DB::table('tbl_size')->where('supplier_id',$supplier)->orderBy('size', 'asc')->get() ;

		return view('supplier.size.sizeData')->with('result', $result) ;
	}

	public function changeSizeStatus(Request $request)
	{
		$size_id = $request->size_id ;

		$status_check   = DB::table('tbl_size')->where('id', $size_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('tbl_size')->where('id', $size_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}

	}

	public function editSize(Request $request)
	{
		$id = $request->id ;
		$value   = DB::table('tbl_size')->where('id', $id)->first() ;

		return view('supplier.size.editSize')->with('value', $value) ;
	}

	public function updateSizeInfo(Request $request)
	{
		$size  = $request->size ;
		$primary_id     = $request->primary_id ;

		if ($size == "" ) {
			echo "invalid_input" ;
			exit() ;
		}

		$data_count = DB::table('tbl_size')
		->where('size', $size)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data                   = array() ;
		$data['size']  = $size ;
		$data['size_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $size)) ;
		$data['created_at']     = $this->rcdate ;

		$query = DB::table('tbl_size')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function sizeDelete(Request $request)
	{
		$id = $request->id ;
		$query = DB::table('tbl_size')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}

	//supplier slider

	public function sliderList(){
    $result = DB::table('tbl_slider')->orderBy('slider_title', 'asc')->get();

    return view('supplier.slider.supplierSliderList')->with('result', $result) ;
  }


  public function insertSupplierSlider(Request $request)
  {
      $request->validate([
            'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        ]);
    $slider_title = $request->slider_title;
    $slider_link = $request->slider_link;
    $slider_image = $request->slider_image;
    $supplier_id = Session::get('supplier_id');
    
    
    $package_check = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
    if($package_check->package_id == 0){
        echo "package_not_active";
        exit() ;
    }

    $package_info               = DB::table('tbl_package')->where('id',$package_check->package_id)->first() ;
    $product_upload_quantit    = $package_info->slider_update_status;
    
    # SUPPLIER SLIDER COUNT 
    $slider_count = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->count() ;

    if($slider_count == $product_upload_quantit){
        echo "limit_over";
        exit() ;
    }


    if ($slider_image == "" ) {
      echo "invalid_input" ;
      exit() ;
    }

    $data                  = array();
    $data['slider_title']  = $slider_title;
    $data['slider_link']   = $slider_link;
    $data['slider_slug']   = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $slider_title)) ;
    $data['slider_image']  = $slider_image;
    $data['supplier_id']   = $supplier_id;
    $data['type']          = 2;
    $data['status']        = 1 ;
    $data['created_at']    = $this->rcdate ;
    
    if ($request->hasFile('slider_image')) {
            $image = $request->file('slider_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1100,550)->save(base_path('public/images/supplierSlider/') . $new_image_name);
            $data['slider_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_slider')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function getAllSupplierSlider(Request $request)
  {
    $supplier_id = Session::get('supplier_id');
    $result = DB::table('tbl_slider')->where('supplier_id',$supplier_id)->orderBy('slider_title', 'asc')->get();
    return view('supplier.slider.supplierSliderData')->with('result', $result) ;
  }

  public function changeSliderStatus(Request $request)
  {
    $slider_id = $request->slider_id;

    $status_check   = DB::table('tbl_slider')->where('id', $slider_id)->first() ;
    $status         = $status_check->status;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('tbl_slider')->where('id', $slider_id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }

  }

  public function editSupplierSlider(Request $request)
  {
    $id = $request->id ;
    $value   = DB::table('tbl_slider')->where('id', $id)->first() ;

    return view('supplier.slider.editSlider')->with('value', $value) ;
  }

  public function updateSupplierSlider(Request $request)
  {
      $request->validate([
            'slider_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        ]);

    $slider_title = $request->slider_title;
    $slider_link = $request->slider_link;
    $slider_image = $request->slider_image;
    $primary_id     = $request->primary_id ;
    
    $image = DB::table('tbl_slider')->where('id', $primary_id)->first() ;


    if ($slider_image == "") {
      echo "invalid_input" ;
      exit() ;
    }


    $data                   = array() ;
    $data['slider_title']  = $slider_title;
    $data['slider_link']  = $slider_link;
    $data['slider_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $slider_title)) ;
    $data['slider_image']  = $slider_image;
    $data['created_at']     = $this->rcdate ;
    
    if ($request->hasFile('slider_image')) {
        $image_path = public_path('images/supplierSlider/' .$image->slider_image);
        if ($image->slider_image && file_exists($image_path)) {
                    unlink($image_path);
                }
        
            $image = $request->file('slider_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1100,550)->save(base_path('public/images/supplierSlider/') . $new_image_name);
            $data['slider_image']  = $new_image_name;
        }

    $query = DB::table('tbl_slider')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function supplierSliderDelete(Request $request)
  {
    $id = $request->id ;
    $image = DB::table('tbl_slider')->where('id', $id)->first() ;
    
    $image_path = public_path('images/supplierSlider/' .$image->slider_image);
        if ($image->slider_image && file_exists($image_path)) {
                    unlink($image_path);
                }
                
    $query = DB::table('tbl_slider')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }

    //supplier Brand List
	public function brandList()
	{
		$result = DB::table('tbl_brand')->orderBy('id', 'desc')->get() ;
		return view('supplier.brand.brandList')->with('result', $result) ;
	}


	public function insertBrandInfo(Request $request)
	{
		$brand_name = $request->brand_name;
		$discription = $request->discription;
		$supplier_id = Session::get('supplier_id');

		
		$data_check = DB::table('tbl_brand')
		->where('brand_name', $brand_name)
		->where('supplier_id', $supplier_id)
		->count() ;

		if ($data_check > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($brand_name == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data                = array();
		$data['brand_name']  = $brand_name ;
		$data['discription']  = $discription ;
		$data['supplier_id']  = $supplier_id ;
		$data['brand_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $brand_name)) ;
		$data['status']      = 1 ;
		$data['created_at']  = $this->rcdate ;

		$query = DB::table('tbl_brand')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllBrand(Request $request)
	{
		$supplier = Session::get('supplier_id');
		$result = DB::table('tbl_brand')->where('supplier_id',$supplier)->orderBy('id', 'desc')->get();

		return view('supplier.brand.brandData')->with('result', $result) ;
	}

	public function changeBrandStatus(Request $request)
	{
		$brand_id = $request->brand_id ;

		$status_check   = DB::table('tbl_brand')->where('id', $brand_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('tbl_brand')->where('id', $brand_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}

	}

	public function editBrand(Request $request)
	{
		$id = $request->id ;
		$value   = DB::table('tbl_brand')->where('id', $id)->first() ;
		return view('supplier.brand.editBrand')->with('value', $value) ;
	}

	public function updateBrandInfo(Request $request)
	{
		$brand_name  = $request->brand_name;
		$discription = $request->discription;
		$primary_id  = $request->primary_id ;

		if ($brand_name == "" ) {
			echo "invalid_input" ;
			exit() ;
		}

		$data_count = DB::table('tbl_brand')
		->where('brand_name', $brand_name)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data                   = array() ;
		$data['brand_name']  = $brand_name ;
		$data['discription']  = $discription ;
		$data['brand_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $brand_name)) ;
		$data['created_at']     = $this->rcdate ;

		$query = DB::table('tbl_brand')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function brandDelete(Request $request)
	{
		$id = $request->id ;
		$query = DB::table('tbl_brand')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}


}
