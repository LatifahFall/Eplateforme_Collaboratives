<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
//use Intervention\Image\Facades\Image;
use Image;

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
        return view('admin.settings.update_admin_details', compact('adminDetails'));
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
//oumayma&chaymae
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
                $imagePath = public_path('admin/images/photos' . $imageName);
    
                // Sauvegarder l'image avec Intervention Image
                Image::make($image_tmp)->save($imagePath);
    
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
