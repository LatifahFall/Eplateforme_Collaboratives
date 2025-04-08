@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Update Vendor Details</h3>
                  <!--<h6 class="font-weight-normal mb-0">Update Admin Password</h6> -->
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                      <a class="dropdown-item" href="#">January - March</a>
                      <a class="dropdown-item" href="#">March - June</a>
                      <a class="dropdown-item" href="#">June - August</a>
                      <a class="dropdown-item" href="#">August - November</a>
                    </div>
                  </div>
                 </div>
                </div>
              </div>
            </div>
        </div>
        @if($slug=="personal")
        <div class="row">
          
        <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <h4 class="card-title">Update Personal Informations</h4>
                @if (@Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error: </strong> {{ Session::get('error_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              @endif
              @if(Session::has('success_message'))
        
              <div class="alert alert-success alert-dismissible fade show" role="alert">
            
        <strong>Success: </strong> {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
<!-- me -->
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post"
                  enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Vendor Username/Email</label>
                      <input type="text" class="form-control" value="{{  Auth::guard('admin')->user()->email  }}" readonly="">

                    </div>
                    <div class="form-group">
                       <label for="vendor_name">Name</label>
                       <input type="text" class="form-control" id="vendor_name" placeholder="Enter Your Name" name="vendor_name" 
                       value="{{ Auth::guard('admin')->user()->name}}" required>
                    </div>
                    <div class="form-group">
                       <label for="vendor_address">Address</label>
                       <input type="text" class="form-control" id="vendor_address" placeholder="Enter Your Address" name="vendor_address" 
                       value="{{ $vendorDetails['address']}}" >
                    </div>
                    <div class="form-group">
                       <label for="vendor_city">City</label>
                       <input type="text" class="form-control" id="vendor_city" placeholder="Enter Your City" name="vendor_city" 
                       value="{{ $vendorDetails['city']}}" >
                    </div>
                    <div class="form-group">
                       <label for="vendor_state">State</label>
                       <input type="text" class="form-control" id="vendor_state" placeholder="Enter Your State" name="vendor_state" 
                       value="{{ $vendorDetails['state']}}" >
                    </div>
                    <div class="form-group">
                       <label for="vendor_country">Country</label>
                       <input type="text" class="form-control" id="vendor_country" placeholder="Enter Your Country" name="vendor_country" 
                       value="{{ $vendorDetails['country']}}" >
                    </div>
                    <div class="form-group">
                       <label for="vendor_pincode">Zip Code</label>
                       <input type="text" class="form-control" id="vendor_pincode" placeholder="Enter Your Zip Code" name="vendor_pincode" 
                       value="{{ $vendorDetails['pincode']}}" >
                    </div>
                
                    <div class="form-group">
                        <label for="vendor_mobile">Mobile</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Enter 10 digit Mobile Number" name="vendor_mobile"
                        value="{{ $vendorDetails['mobile']}}" required="" maxlength="10" minlength="10"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="vendor_image">Vendor Photo</label>
                        <input type="file" class="form-control" id="vendor_image"   name="vendor_image">
                        @if (!empty(Auth::guard('admin')->user()->image))
                           <a  target="_blank"href="{{ asset('admin/images/photos/' . Auth::guard('admin')->user()->image) }}">View Image</a>
                           <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image}}">
                        @endif

                     </div>

                        
 
                 <!-- 
<div class="form-group">
    <label for="Confirm_password">Confirm Password</label>
    <input type="password" class="form-control" id="Confirm_password" placeholder="Password" name="Confirm Password" required>
</div>  
-->
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          </div>
          @elseif($slug=="business")
          <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <h4 class="card-title">Update business Informations</h4>
                @if (@Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error: </strong> {{ Session::get('error_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              @endif
              @if(Session::has('success_message'))
        
              <div class="alert alert-success alert-dismissible fade show" role="alert">
            
        <strong>Success: </strong> {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif

                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post"
                  enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Business Username/Email</label>
                      <input type="text" class="form-control" value="{{  Auth::guard('admin')->user()->email  }}" readonly="">

                    </div>
                    <div class="form-group">
                       <label for="shop_name">Business Name</label>
                       <input type="text" class="form-control" id="shop_name" name="shop_name" 
                       value="{{ $vendorDetails['shop_name'] }}" >
                    </div>
                    <div class="form-group">
                       <label for="shop_address">Business Address</label>
                       <input type="text" class="form-control" id="shop_address" placeholder="Enter Business Address" name="shop_address" 
                       value="{{ $vendorDetails['shop_address']}}" >
                    </div>
                    <div class="form-group">
                       <label for="shop_city">Business City</label>
                       <input type="text" class="form-control" id="shop_city" placeholder="Enter Business City" name="shop_city" 
                       value="{{ $vendorDetails['shop_city']}}" >
                    </div>
                    <div class="form-group">
                       <label for="shop_state">Business State</label>
                       <input type="text" class="form-control" id="shop_state" placeholder="Enter Business State" name="shop_state" 
                       value="{{ $vendorDetails['shop_state']}}" >
                    </div>
                    <div class="form-group">
                       <label for="shop_country">Business Country</label>
                       <input type="text" class="form-control" id="shop_country" placeholder="Enter Business Country" name="shop_country" 
                       value="{{ $vendorDetails['shop_country']}}" >
                    </div>
                    <div class="form-group">
                       <label for="shop_zipcode">Business Zip Code</label>
                       <input type="text" class="form-control" id="shop_zipcode" placeholder="Enter Business Zip Code" name="shop_zipcode" 
                       value="{{ $vendorDetails['shop_zipcode']}}" >
                    </div>
                
                    <div class="form-group">
                        <label for="shop_mobile">Business Mobile</label>
                        <input type="text" class="form-control" id="shop_mobile" placeholder="Enter Business Mobile Number" name="shop_mobile"
                        value="{{ $vendorDetails['shop_mobile']}}" required="" maxlength="10" minlength="10"
                        >
                    </div>
<!-- la license de l association-->
                      <div class="form-group">
                        <label for="business_license_number">Business license number</label>
                        <input type="text" class="form-control" id="business_license_number" placeholder="Enter Business license number" name="business_license_number"
                        value="{{ $vendorDetails['business_license_number']}}" required="" 
                        >
                    </div>

                    <div class="form-group">
                        <label for="address_proof">Address Proof</label>
                        <select class="form-control" name="address_proof" id="address_proof">
                          <option value="CIN" @if($vendorDetails['address_proof']=="CIN") selected @endif> CIN</option>
                          <option value="Passeport" @if($vendorDetails['address_proof']=="Passeport") selected @endif> Passeport</option>
                          <option value="Driving License" @if($vendorDetails['address_proof']=="Driving License") selected @endif> Driving License</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address_proof_image">Address Proof Image</label>
                        <input type="file" class="form-control" id="address_proof_image"   name="address_proof_image">
                        @if (!empty($vendorDetails['address_proof_image']))
                           <a  target="_blank"href="{{ asset('admin/images/proofs/' . $vendorDetails['address_proof_image']) }}">View Image</a>
                           <input type="hidden" name="current_address_proof" value="{{ $vendorDetails['address_proof_image'] }}">
                        @endif

                     </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          </div>

        @elseif($slug=="bank")
        <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <h4 class="card-title">Update business Informations</h4>
                @if (@Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error: </strong> {{ Session::get('error_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              @endif
              @if(Session::has('success_message'))
        
              <div class="alert alert-success alert-dismissible fade show" role="alert">
            
        <strong>Success: </strong> {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif

              <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post"
                    enctype="multipart/form-data">@csrf
                      <div class="form-group">
                        <label>Business Username/Email</label>
                        <input type="text" class="form-control" value="{{  Auth::guard('admin')->user()->email  }}" readonly="">
  
                      </div>
                      <div class="form-group">
                         <label for="account_holder_name">Account Holder Name</label>
                         <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" 
                         value="{{ $vendorDetails['account_holder_name'] }}" >
                      </div>
                      <div class="form-group">
                         <label for="bank_name">Bank Name</label>
                         <input type="text" class="form-control" id="bank_name" placeholder="Enter Bank name" name="bank_name" 
                         value="{{ $vendorDetails['bank_name']}}" >
                      </div>
                      <div class="form-group">
                         <label for="bank_RIB">RIB</label>
                         <input type="text" class="form-control" id="bank_RIB" placeholder="Enter Bank RIB" name="bank_RIB" 
                         value="{{ $vendorDetails['bank_RIB']}}" >
                      </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          </div>
          @endif
@endsection