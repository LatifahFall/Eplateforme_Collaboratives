<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use Database\Seeders\VendorBusinessDetailsTableSeeder;
use Illuminate\Support\Facades\Auth;
//use Intervention\Image\Drivers\Gd\Driver; // Import the GD driver
use Intervention\Image\Facades\Image;


class AdminController extends Controller
{
    public function dashbord()
    {
        return view('admin.dashbord');
    }



    public function updateAdminPassword(Request $request)
{   
    // Vérifier si l'utilisateur est authentifié
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
    }

    // Récupérer les détails de l'administrateur connecté
    $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();

    // Si la requête est GET, afficher la page
    if (!$request->isMethod('post')) {
        return view('admin.settings.update_admin_password', compact('adminDetails'));
    }

    // Récupérer les données du formulaire
    $data = $request->all();

    // Vérifier si le mot de passe actuel est correct
    if (!isset($data['current_password']) || !Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
        return redirect()->back()->with('error_message', 'Your current password is Incorrect!');
    }

    // Vérifier si les nouveaux mots de passe correspondent
    if ($data['New_Password'] !== $data['Confirm_Password']) {
        return redirect()->back()->with('error_message', 'New Password and Confirm Password do not match!');
    }

    // Mettre à jour le mot de passe
    $admin = Auth::guard('admin')->user();
    $admin->password = Hash::make($data['New_Password']);
    $admin->save();

    return redirect()->back()->with('success_message', 'Password updated successfully!');
}

   public function checkAdminPassword(Request $request){
    $data = $request->all();
    /*echo "<pre>"; print_r($data); die;*/
    if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
        return "true";
    }else{
        return "false";
    }
}
//siham
public function updateAdminDetails(Request $request)
{
    if ($request->isMethod('post')) {
        $data = $request->all();

        $rules = [
            'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'admin_mobile' => 'required|numeric'
        ];

        $customMessages = [
            'admin_name.required' => 'Name is required',
            'admin_name.regex' => 'Valid Name is required',
            'admin_mobile.required' => 'Mobile is required',
            'admin_mobile.numeric' => 'Valid Mobile is required',
        ];

        $this->validate($request, $rules, $customMessages);

        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        $imageName = $admin->image;

        // Vérifier si un fichier a été uploadé
        if ($request->hasFile('admin_image')) {
            $image_tmp = $request->file('admin_image');
            
            if ($image_tmp->isValid()) {
                // Generate unique name
                $imageName = rand(111, 99999) . '.' . $image_tmp->getClientOriginalExtension();
                
                // Save image using Laravel Storage (public path)
                $image_tmp->move(public_path('admin/images/photos/'), $imageName);
                
                // Update in database
                $admin->image = $imageName;
                $admin->save();
            }
        }
        
        // Mettre à jour les détails de l'admin
        Admin::where('id', Auth::guard('admin')->user()->id)->update([
            'name' => $data['admin_name'],
            'mobile' => $data['admin_mobile'],
            'image' => $imageName
        ]);

        return redirect()->back()->with('success_message', 'Admin details updated successfully!');
    }

    return view('admin.settings.update_admin_details');
}


//oumayma&chaymae
/*
public function updateAdminDetails(Request $request)
{
    if ($request->isMethod('post')) {
        $data = $request->all();
        //echo "<pre>";print_r($data) ;die

        $rules = [
            'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'admin_mobile' => 'required|numeric'
        ];
        
        $customMessages = [
            'admin_name.required' => 'Name is required',
            'admin_name.regex' => 'Valid Name is required',
            'admin_mobile.required' => 'Mobile is required',
            'admin_mobile.numeric' => 'Valid Mobile is required',
        ];
        
        $this->validate($request, $rules, $customMessages);

        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        $imageName = $admin->image;
    
        // Vérifier si un fichier a été uploadé
        if ($request->hasFile('admin_image')) {
            $image_tmp = $request->file('admin_image');
    
            if ($image_tmp->isValid()) {
                // Récupérer l'extension
                $extension = $image_tmp->getClientOriginalExtension(); 
    
                // Générer un nom unique
                $imageName = rand(111, 99999) . '.' . $extension;
    
                // Définir le chemin de sauvegarde
                $imagePath = 'admin/images/photos/'.$imageName; 
    
                // Sauvegarder l'image avec Intervention Image
                \Intervention\Image\Facades\Image::make($image_tmp)->save($imagePath);
    
                // Mettre à jour l'image dans la base de données
                $admin->image = $imageName;
                $admin->save();
            
         }}
          else if(!empty($data['current_admin_image'])){
            $imageName=$data['current_admin_image'];
          }else{
            $imageName=" ";
          }

        // Update admin details
        Admin::where('id', Auth::guard('admin')->user()->id)->update([
            'name' => $data['admin_name'],
            'mobile' => $data['admin_mobile'],
            'image' => $imageName
        ]);

        return redirect()->back()->with('success_message', 'Admin details updated successfully!');
    }

    return view('admin.settings.update_admin_details');
}
    */

//login

    public function login(Request $request){
        if ($request->isMethod('post')){
            // Super secure password: 123 and username=admin@admin.com
            $data = $request->all();

            $rules = [
                'email' => 'required |email |max:255',
                'password' => 'required',
            ];    
            $customMessages = [
                // Add Custom Messages here
                'email. required' => 'Email is required!',
                'email.email' => 'Valid Email is required',
                'password. required' => 'Password is required',
            ];    
            $this->validate($request,$rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashbord');
            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }
        }
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin' )->Logout();
        return redirect('admin/login');
    }

//vendor details
public function updateVendorDetails($slug,Request $request){
    if ($slug=="personal"){
        if ($request->isMethod('post')) {
            $data = $request->all();
    
            $rules = [
                'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                'vendor_mobile' => 'required|numeric',
                'vendor_address' => 'required', 
                'vendor_country' => 'required',
                'vendor_pincode' => 'required|numeric',
                'vendor_state' => 'required'
            ];
    
            $customMessages = [
                'vendor_name.required' => 'Name is required',
                'vendor_name.regex' => 'Valid Name is required',
                'vendor_city.required' => 'City is required',
                'vendor_mobile.required' => 'Mobile is required',
                'vendor_mobile.numeric' => 'Valid Mobile is required',
                'vendor_address.required' => 'Address is required',
                'vendor_country.required' => 'Country is required',
                'vendor_pincode.required' => 'ZipCode is required',
                'vendor_state.required' => 'State is required'
            ];
    
            $this->validate($request, $rules, $customMessages);
    
            $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();
            $imageName = $admin->image;
    
            // Vérifier si un fichier a été uploadé
            if ($request->hasFile('vendor_image')) {
                $image_tmp = $request->file('vendor_image');
                
                if ($image_tmp->isValid()) {
                    // Generate unique name
                    $imageName = rand(111, 99999) . '.' . $image_tmp->getClientOriginalExtension();
                    
                    // Save image using Laravel Storage (public path)
                    $image_tmp->move(public_path('admin/images/photos/'), $imageName);
                    
                    // Update in database
                    $admin->image = $imageName;
                    $admin->save();
                }
            }
            
            // update in admin table
            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'name' => $data['vendor_name'],
                'mobile' => $data['vendor_mobile'],
                'image' => $imageName
            ]);
            //update in vendor table 
            Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update([
                'name' => $data['vendor_name'],
                'mobile' => $data['vendor_mobile'],
                'address' => $data['vendor_address'],
                'city' => $data['vendor_city'],
                'country' => $data['vendor_country'],
                'pincode' => $data['vendor_pincode'],
                'state' => $data['vendor_state'],
                'image' => $imageName]);
    
            return redirect()->back()->with('success_message', 'Vendor details updated successfully!');
        }
        $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();



    }
    else if ($slug=="business"){
        $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            if ($request->isMethod('post')) {
                $data = $request->all();
        //add what is mandotory like license
                $rules = [
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required|numeric',
                    'shop_address' => 'required', 
                    'shop_country' => 'required',
                    'shop_zipcode' => 'required|numeric',
                    'shop_state' => 'required',
                    'business_license_number' => 'required'
                ];
        
                $customMessages = [
                    'shop_name.required' => 'Name is required',
                    'shop_name.regex' => 'Valid Name is required',
                    'shop_city.required' => 'City is required',
                    'shop_mobile.required' => 'Mobile is required',
                    'shop_mobile.numeric' => 'Valid Mobile is required',
                    'shop_address.required' => 'Address is required',
                    'shop_country.required' => 'Country is required',
                    'shop_zipcode.required' => 'ZipCode is required',
                    'shop_state.required' => 'State is required'
                ];
        
                $this->validate($request, $rules, $customMessages);
        
                $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();
                $imageName = $admin->image;
        
                // Vérifier si un fichier a été uploadé
                if ($request->hasFile('address_proof_image')) {
                    $image_tmp = $request->file('address_proof_image');
                    
                    if ($image_tmp->isValid()) {
                        // Generate unique name
                        $imageName = rand(111, 99999) . '.' . $image_tmp->getClientOriginalExtension();
                        
                        // Save image using Laravel Storage (public path)
                        $image_tmp->move(public_path('admin/images/proofs/'), $imageName);
                        
                        // Update in database
                        $admin->image = $imageName;
                        $admin->save();
                    }
                }
                
                //update in vendor_business_details table 
                VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
                    'shop_name' => $data['shop_name'],
                    'shop_mobile' => $data['shop_mobile'],
                    'shop_address' => $data['shop_address'],
                    'shop_city' => $data['shop_city'],
                    'shop_country' => $data['shop_country'],
                    'shop_zipcode' => $data['shop_zipcode'],
                    'shop_state' => $data['shop_state'],
                    'address_proof' => $data['address_proof'],
                    'address_proof_image' => $imageName,
                    'business_license_number' => $data['business_license_number']]);
        
                return redirect()->back()->with('success_message', 'Vendor details updated successfully!');
            }
    
    
    
        }

    else if ($slug=="bank") {
        $vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();
    
            $rules = [
                'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'bank_name' => 'required',
                'bank_RIB' => 'required|numeric',
            ];
    
            $customMessages = [
                'account_holder_name.required' => 'Account Holder Name is required',
                'account_holder_name.regex' => 'Valid Account Holder Name is required',
                'bank_name.required' => 'Bank Name is required',
                'bank_RIB.required' => 'Bank RIB is required',
                'bank_RIB.numeric' => 'Valid Bank RIB is required',
            ];
    
            $this->validate($request, $rules, $customMessages);            
            
            //update in vendors_bank_details table 
            VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
                'account_holder_name' => $data['account_holder_name'],
                'bank_name' => $data['bank_name'],
                'bank_RIB' => $data['bank_RIB']]);
    
            return redirect()->back()->with('success_message', 'Vendor details updated successfully!');
        }

    }
    return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails'));

}
public function admins($type=null){
    $admins = Admin::query();
    if(!empty($type)){
        $admins = $admins->where('type',$type);   
        $title = ucfirst($type)."s";
    }else{
        $title = "All Admins/Subadmins/Vendors";
    }
    $admins = $admins->get()->toArray();
    /*dd($admins);*/
    return view('admin.admins.admins')->with(compact('admins','title'));
}
public function viewVendorDetails($id) {
    $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
    $vendorDetails = json_decode(json_encode($vendorDetails),true);
    return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));

}

// update admin status
public function updateAdminStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        if($data['status']=="Active"){
            $status = 0;
        }
        else {
            $status = 1;
        }
        Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
    }

}

}

 

/*namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashbord (){
        return view('admin.dashbord');
    }
}
*/
