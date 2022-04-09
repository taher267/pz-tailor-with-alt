<div>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">New Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('customers')}}">Customers</a></li>
            <li class="breadcrumb-item active">New Customer</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container">
      @if ($errors->any())
        @foreach ($errors->all() as $err)
            <p class="text-danger">{{$err}}</p>
        @endforeach
      @endif
      <form class="form-horizontal" wire:submit.prevent='addCustomer'>
        <div class="row">
          <div class="col-md-10 pl-3">
                <div class="form-group row">
                  <label for="inputName" class="col-sm-2 col-form-label">Order No</label>
                  <div class="col-sm-10">
                    <div class="row">
                      <div class="col-lg-7">
                          <label for="order_number" style="letter-spacing:px">অর্ডার নং- <span
                                  class="text-info">(সর্বশেষ অর্ডার
                                  নং-@if(DB::table('customers')->get()->count()>0){{DB::table('customers')->orderBy('id','DESC')->first()->order_number}}@else 0 @endif)
                              </span></label>
                          <input type="number" class="form-control @error('order_number') is-invalid @enderror"
                              @if(!$force_id) min="{{!$force_id ? $maxOrderId: $order_number}}"
                              max="{{$maxOrderId}}" @else min="1" @endif wire:model="order_number"
                              id="order_number" required>
                          @error('order_number')<div class="invalid-feedback">{!!'অর্ডার নং'.$message!!}</div>
                          @enderror
                      </div>
                      <div class="col-lg-5">
                          <input type="checkbox" value="1" wire:model="force_id" id="force_wish">
                          <label for="force_wish">পূর্ববর্তী অর্ডার নং যুক্ত করুন</label>
                      </div>
                  </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="নাম" required>
                    @error('name')<div class="invalid-feedback">{!!'নাম'.$message!!}</div>@enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="mobilePhone" class="col-sm-2 col-form-label">Mobile No</label>
                  <div class="col-sm-10">
                    <input type="text" wire:model.debounce.500ms="mobile" class="form-control @error('mobile')is-invalid @enderror" id="mobilePhone" placeholder="019xxxxxxx" required>
                    @error('mobile')<div class="invalid-feedback">{!!'মোবাইল নম্বর'.$message!!}</div>@enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email"  wire:model.debounce.500ms="email" class="form-control @error('email')is-invalid @enderror" id="inputEmail" placeholder="Email">
                    @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="address" class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-10">
                    <textarea class="form-control @error('address')is-invalid @enderror" wire:model="address" id="address" placeholder="Address"></textarea>
                    @error('address')<div class="invalid-feedback">{{$message}}</div>@enderror
                  </div>
                </div>
                
          </div>
          <div class="col-md-2 col-xs-10 offset-xs-2">
            <div class="text-center">
                @if ($photo)
                  <img style="max-width: 100%" src="{{$photo->temporaryUrl()}}">
                @else
                  <img style="max-width: 100%"src="{{config('app.url').'/assets/alt/dist/img/default-150x150.png'}}">
                @endif
            </div>
            <div class="form-group row">
                <div class="custom-file mt-3">
                  <input type="file" class="custom-file-input @error('photo')is-invalid @enderror" wire:model="photo" id="customerphoto" accept="image/*" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="customerphoto"><i class="fa fa-camera-retro" aria-hidden="true"></i> Choose</label>
                  @error('photo')<div class="invalid-feedback">{{$message}}</div>@enderror
                </div>
            </div>
          </div>
          <div class="col-md-12 ml-1">
            {{-- delivery System --}}
              <div class="col-xl-12">
                <div class="col-xl-12 d-flex form-group ">
                    <div class="form-check custom-radio d-flex">
                        <input value="1" wire:model='order_delivery' type="checkbox"
                            class="custom-control-input" id="otherDelivery" name="daliveryPolicy">
                        <label class="custom-control-label text-info" for="otherDelivery">অন্য কোনো মাধ্যমে আপনার পণ্য ডেলিভারি হবে?</label>
                    </div>
                </div>

                @if ( $order_delivery == 1 )
                <div class="row py-3 test-class mb-4" id="dalivery_address"
                    style="background: linear-gradient(355deg,#009cea00, rgb(128 0 128 / 5%) )">
                    <div class="col-xl-12 ">
                        <h6 class="text-primary">কুরিয়ার বা কোন মাধ্যমে আপনার পণ্য সমূহ ডেলিভারি হবে
                            তার বিস্তারিত--</h6>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <label for="deliverysystem" @error('delivery_system') class="text-danger"
                            @enderror>কিভাবে অর্ডার ডেলিভারি নিতেচান?</label>
                        <select wire:model="delivery_system" class="custom-select d-block w-100 @error('delivery_system')is-invalid @enderror"
                            id="deliverysystem" required >
                            <option>নির্বাচন করুন</option>
                            <option value="1">কুরিয়ার</option>
                            <option value="2">নিজে নিবেন</option>
                        </select>
                        @error('delivery_system')<div class="text-danger"> {!!$message!!}</div> @else
                        <div class="invalid-feedback"> Select a delivery system name</div> @enderror
                    </div>
                    <div class="col-xl-6 mb-3">
                        <label for="deliverycharge">কুরিয়ার চার্জ</label>
                        <input wire:model="delivery_charge" type="number" class="form-control"
                            id="deliverycharge" placeholder="কুরিয়ার চার্জ..." required>
                        @error('delivery_charge') <div class="text-danger">{!!$message!!}</div> @else
                        <div class="invalid-feedback">কুরিয়ার চার্জ লিখুন!</div>@enderror
                    </div>

                    <div class="col-xl-12 mb-3">
                        <label for="couriername">কুরিয়ার এর তথ্য</label>
                        <input wire:model="courier_name" type="text" class="form-control"
                            id="couriername" placeholder="কুরিয়ার এর নাম এবং শাখার বিস্তারিত..."
                            required>
                        @error('courier_name') <div class="text-danger">{!!$message!!}</div> @else
                        <div class="invalid-feedback">Courier details is required.</div>@enderror
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label for="coun_try">দেশ</label>
                        <select wire:model="country" class="custom-select d-block w-100" id="coun_try" required>
                            <option value="0">...</option>
                            <option value="bd">Bangladesh</option>
                        </select>
                        @error('country') <div class="text-danger">{!!$message!!}</div> @else <div
                            class="invalid-feedback">Select a country</div> @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="ccity">শহর</label>
                        <input wire:model="city" type="text" class="form-control" id="ccity"
                            placeholder="City" required>
                        @error('city') <div class="text-danger">{!!$message!!}</div> @else <div
                            class="invalid-feedback">শহর দিন!</div>@enderror
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label for="line1">লাইন ১</label>
                        <input wire:model="line1" type="text" class="form-control" id="line1"
                            placeholder="বাড়ি নং,গ্রাম/মহল্লা সড়ক নং লিখুন...." required>
                        @error('line1') <div class="text-danger">{!!$message!!}</div> @else <div
                            class="invalid-feedback">লাইন ১ দিন!</div>@enderror
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label for="line2">লাইন ২</label>
                        <input wire:model="line2" type="text" class="form-control" id="line2"
                            placeholder="লাইন ২..">
                        @error('line2') <div class="text-danger">{!!$message!!}</div> @enderror
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label for="cprovince">প্রদেশ</label>
                        <input wire:model="province" type="text" class="form-control" id="cprovince"
                            placeholder="প্রদেশ" required>
                        @error('province') <div class="text-danger">{!!$message!!}</div> @else <div
                            class="invalid-feedback">প্রদেশ দিন!</div>@enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="zip">জিপ-কোড</label>
                        <input wire:model="zipcode" type="number" class="form-control" id="zip"
                            placeholder="জিপ-কোড" required>
                        @error('zipcode') <div class="text-danger">{!!$message!!}</div> @else <div
                            class="invalid-feedback">সঠিক জিপ-কোড দিন!</div>@enderror
                    </div>
                </div>
                @endif
            </div>
            {{-- delivery System --}}
          <div class="form-group row">
            <div class="col-sm-12 text-right">
              <button type="submit" class="btn btn-danger"><i class="fa fa-user-plus"></i> Submit</button>
            </div>
          </div>
        </div>
        </div>
    </form>
    </div>
  </div>
</div>
@push('scripts')
  <script>
    $(document).ready(function(){$('.custom-file-input').change(function () {$('.custom-file-input').next().text(this.files[0].name);});});
  </script>
@endpush