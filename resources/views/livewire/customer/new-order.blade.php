<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
      <div class="content pl-3">
        <div class="container-fluid fz-13">
          <form class="form-horizontal" wire:submit.prevent='addOrder'>
              <div class="col-xl-12 $currentStep != 1 ? 'display-none' : ''">
                  <div class="personal_information">
                      <div class="row" style="font-size: 13px">
                              <div class="col-md-12"><h3 class="text-muted">অর্ডারের তথ্য</h3></div>
                              <div class="col-lg-4">
                                  <p class="d-flex m-0"><label for="delivery_date">ডেলিভেরি তারিখঃ</label>
                                      <span class="ml-1"> <input type="checkbox" wire:model="force_previous_date" id="forcePreviousDate">
                                          <label style="font-size:12px" class="text-info" for="forcePreviousDate"> পূর্ববর্তী তারিখ যুক্ত করুন</label>
                                      </span>
                                  </p>
                                  
                                  <input type="text" value="{{$delivery_date}}" autocomplete="off" autofocus='off'
                                      class="form-control @error('delivery_date')is-invalid @enderror"
                                      wire-model="delivery_date" id="delivery_date" required>
  
                                  @error('delivery_date') <div class="invalid-feedback">{!!$message!!}</div>
                                  @else
                                  @if ($delivery_date &&  $weekendholiday==Carbon\Carbon::createFromFormat('Y-m-d',$delivery_date)->dayOfWeek)
                                  <p class="mt-3" style="color: #2D88F3">
                                      ({{$delivery_date}}),
                                      নির্বাচিত তারিখটি
                                      @if ($weekendholiday=='6') শনিবার
                                      @elseif($weekendholiday=='0')রবিবার
                                      @elseif ($weekendholiday=='1') সোমবার
                                      @elseif ($weekendholiday=='2') মঙ্গলবার
                                      @elseif ($weekendholiday=='3')বুধবার
                                      @elseif ($weekendholiday=='4') বৃহস্পতিবার
                                      @elseif($weekendholiday=='5') শুক্রবার
                                      @endif
                                      প্রতিষ্ঠানের সাপ্তাহিক ছুটির দিন!
                                  </p>
                                  @else <div class="invalid-feedback">ডেলিভারি তারিখ দিন!</div>
                                  @endif
                                  @enderror
  
                              </div>
                              <div class="col-lg-5">
                                  <div class="row">
                                      <div class="col-lg-9">
                                          <label for="order_number" style="letter-spacing:px">অর্ডার নং- <span
                                                  class="text-info">(সর্বশেষ অর্ডার
                                                  নং-@if(DB::table('orders')->get()->count()>0){{DB::table('orders')->orderBy('id','DESC')->first()->order_number}}
                                                  @else 0 @endif)
                                              </span></label>
                                          <input type="number"
                                              class="form-control @error('order_number') is-invalid @enderror"
                                              @if(!$force_id) min="{{!$force_id ? $maxOrderId: $order_number}}"
                                              max="{{$maxOrderId}}" @else min="1" @endif wire:model="order_number"
                                              id="order_number" required>
                                          @error('order_number')<div class="invalid-feedback">{!!'অর্ডার নং'.$message!!}</div>
                                          @enderror
                                      </div>
                                      <div class="col-lg-3">
                                          <input type="checkbox" value="1" wire:model="force_id" id="force_wish">
                                          <label for="force_wish">পূর্ববর্তী অর্ডার নং যুক্ত করুন</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-3">
                                  <label for="orderdate">অর্ডার তারিখঃ </label>
                                  <input type="date" class="form-control" wire:model="order_date" id="orderdate">
                                  @error('order_date') <div class="text-danger">{!!$message!!}</div>@enderror
                              </div>
                          </div>
                  </div>
              </div>
              {{-- Step 2 --}}
                            @php
                                $uperArr=[];
                                $lowerArr=[];
                                if ($upperProductsPart){foreach ($upperProductsPart as $product){array_push($uperArr,$product->id);}}
                                if ($lowerProductsPart){foreach ($lowerProductsPart as $product){array_push($lowerArr,$product->id);}}
                            @endphp
                    <div class="col-xl-12 {{--$currentStep != 2 ? 'display-none' : '' --}} ">
                        <div class="measurement_and_design">
                            <div class="upper_part_wrapper" style="background: #2d89f35b">
                                <div class="row">
                                    <div class="col-lg-12 py-5 @error('products')bg-warning @enderror product_name cloth_name">
                                        <h5 class="d-block mb-4">পাঞ্জাবি শার্ট ফতুয়া ইত্যাদি জাতীয় পোশাক</h5>
                                        <div class="row ">
                                            @if ($upperProductsPart)
                                            @foreach ($upperProductsPart as $Uproduct)
                                            <div class="col-sm-2 col-xs-6" style="position: relative;">
                                                <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                    <input type="checkbox" wire:model="up_products" wire:change="designsShowHideControl" name="dresses"
                                                        value="{{$Uproduct->id}}"
                                                        class="custom-control-input @error('products')form-control is-invalid @enderror"
                                                        id="product_{{$Uproduct->id}}"
                                                        {{--sizeof($Uproducts)==0?'required':''--}}>
                                                    <label class="custom-control-label"
                                                        for="product_{{$Uproduct->id}}">{{$Uproduct->name}} <img
                                                            src="{{asset('assets/img/undraw_profile.svg')}}"
                                                            class="img-thumbnail-" width="30" alt=""></label>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div> {{--dresh panzabi .row end--}}
                                        {{-- @endforeach --}}
                                        @error('up_products') <div class="invalid-feedback"> {!!$message!!} </div> @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-xl-6 mb-3"> </div>
                                            @if (DB::table('size_charts')->count()>0)
                                            <div class="col-xl-6 mb-3">
                                                <label for="deliverysystem"> নির্ধারিত সাইজ </label>
                                                <select wire:model="readymade_size" class="custom-select d-block w-100"
                                                    id="deliverysystem" required>
                                                    <option value="0">Select Size</option>
                                                    @foreach (DB::table('size_charts')->get() as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach

                                                </select>
                                                @error('readymade_size')<div class="text-danger"> {!!$message!!}</div> @else<div
                                                    class="invalid-feedback"> Select a delivery system name</div> @enderror
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(count($up_products)>0 && in_array($up_products[0], $uperArr))
                                        {{-- Measure ment area --}}
                                        <div class="col-md-12 pt-4">
                                            <div class="row">
                                                <div class="col-lg-2 mb-3">
                                                    <label for="clothlong">লম্বা</label>
                                                    <input wire:model="cloth_long" type="text" class="form-control @error('cloth_long')is-invalid @enderror"
                                                        id="clothlong" placeholder="লম্বা" required>
                                                    @error('cloth_long')<div class="text-danger"> {!!$message!!}</div> @else
                                                    <div class="invalid-feedback">পোশাকের লম্বা দিন?</div> @enderror
                                                </div>
                                                {{-- Body part Start --}}
                                                <div class="col-lg-3 col-md-6 mb-3">
                                                    <div>
                                                        <label for="clothbody">বডি</label>
                                                        <input wire:model="cloth_body" type="text" class="form-control"
                                                            id="clothbody" placeholder="বডি">
                                                        @error('cloth_body')<div class="text-danger"> {!!$message!!}</div> @else
                                                        <div class="invalid-feedback">পোশাকের বডি দিন?</div> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="bodyloose">বডির লুজ</label>
                                                        <input wire:model="body_loose" type="text" class="form-control"
                                                            id="bodyloose" placeholder="বডির লুজ">
                                                        @error('body_loose')<div class="text-danger"> {!!$message!!}</div> @else
                                                        <div class="invalid-feedback">পোশাকের বডি লুজ দিন?</div> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="clothbelly">পেট</label>
                                                        <input wire:model="cloth_belly" type="text" class="form-control"
                                                            id="clothbelly" _ placeholder="পাট">
                                                        @error('cloth_belly')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">পোশাকের পেট পরিমাপ দিন?</div>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label for="bodyloose">পেটের লুজ</label>
                                                        <input wire:model="belly_loose" type="text" class="form-control"
                                                            id="bodyloose" placeholder="পাটের লুজ">
                                                        @error('belly_loose') <div class="text-danger">{!!$message!!} </div>
                                                        @else <div class="invalid-feedback">পোশাকের বডি পেট লুজের পরিমাপ দিন?
                                                        </div> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="enclosure">ঘের</label>
                                                        <input wire:model="cloth_enclosure" type="text" class="form-control"
                                                            id="enclosure" placeholder="ঘের" required>
                                                        @error('cloth_enclosure')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">পোশাকের ঘের দিন?</div> @enderror
                                                    </div>
                                                </div>
                                                {{-- Body Part End --}}
                                                {{-- Heeeve Area Start --}}
                                                <div class="col-lg-3 col-md-6 mb-3">
                                                    <div class="">
                                                        <label for="handlong">হাতা</label>
                                                        <input wire:model="hand_long" type="text" class="form-control"
                                                            id="handlong" placeholder="হাতা" required>
                                                        @error('hand_long')<div class="text-danger"> {!!$message!!}</div> @else
                                                        <div class="invalid-feedback">হাতা লম্বা দিন?</div> @enderror
                                                    </div>
                                                    <div>
                                                        <label for="sleeveenclosure">হাতার মুহুরী</label>
                                                        <input wire:model="sleeve_enclosure" type="text" class="form-control"
                                                            id="sleeveenclosure" placeholder=" হাতার মুহুরী">
                                                        @error('sleeve_enclosure')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">হাতার মুহুরী দিন?</div> @enderror
                                                    </div>
                                                    <div class="">
                                                        <label for="clothmora">মোরা</label>
                                                        <input wire:model="cloth_mora" type="text" class="form-control"
                                                            id="clothmora" placeholder="মোরা">
                                                        <div class="invalid-feedback">@error('cloth_mora') {!!$message!!} @else
                                                            Mora code required. @enderror</div>
                                                    </div>
                                                    <div>
                                                        <label for="SleevePasting">হাতায় পেস্টিং</label>
                                                        <input wire:model="sleeve_pasting" type="text" class="form-control"
                                                            id="SleevePasting" placeholder="হাতায় পেস্টিং">
                                                        @error('sleeve_pasting')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">হাতা লম্বা হবে?</div> @enderror
                                                    </div>
                                                </div>
                                                {{-- Heeeve Area End --}}

                                                <div class="col-lg-2 col-md-6 mb-3">
                                                    <div>
                                                        <label for="cloththroat">গলা</label>
                                                        <input wire:model="cloth_throat" type="text" class="form-control"
                                                            id="cloththroat" max="30" placeholder="গলা" @if($cloth_collar==null)
                                                            required @endif>
                                                        @error('cloth_throat') <div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">গলার পরিমাপ দিন?</div> @enderror
                                                    </div>
                                                    <div>
                                                        <label for="clothcollar">কলার</label>
                                                        <input wire:model="cloth_collar" type="text" class="form-control"
                                                            id="clothcollar" max="30" placeholder="কলার"
                                                            @if($cloth_throat==null) required @endif>
                                                        @if ($cloth_collar) <select class="form-control"
                                                            wire:model="collar_measure_type">
                                                            <option selected value="0">সাধারণ</option>
                                                            <option value="1">মোট</option>
                                                        </select> @endif
                                                        @error('cloth_collar') <div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">কলার পরিমাপ দিন?</div> @enderror
                                                    </div>
                                                    <div class="row mt-3 p-2 ">
                                                        <div class="col-md-6 plate_type_wrapper">
                                                            <div class="card bg-dark text-white">
                                                                {{-- <img src="/assets/alt/dist/img/tailors/flat-plate.png" class="card-img" alt="..."> --}}
                                                                <div class="card-img-overlay">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio1" name="customRadio" value="1" class="custom-control-input @error('plate_type')form-control is-invalid @enderror">
                                                                        <label class="custom-control-label" for="customRadio1"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white">
                                                                {{-- <img src="/assets/alt/dist/img/tailors/flat-plate.png" class="card-img" alt="..."> --}}
                                                                <div class="card-img-overlay">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio2" value="2" name="customRadio" class="custom-control-input @error('plate_type')form-control is-invalid @enderror">
                                                                        <label class="custom-control-label" for="customRadio2"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>  
                                                    </div>
                                                    
                                                    
                                                </div>
                                                <div class="col-lg-2 col-md-6 mb-3">
                                                    <div class="">
                                                        <label for="clothshoulder">পুট</label>
                                                        <input wire:model="cloth_shoulder" type="text" class="form-control"
                                                            id="clothshoulder" max="40" placeholder="পুট.." required>
                                                        @error('cloth_shoulder') <div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback"> পুটের পরিমাপ দিন?</div> @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="nokeshoho">নক সহ</label>
                                                        <input wire:model="noke_shoho" type="text" class="form-control"
                                                            id="nokeshoho" placeholder="নক সহ">
                                                        @error('noke_shoho') <div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback"> নক সহ দিন?</div> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-lg-12 col-sm-12 mx-lg-auto mb-3">
                                                    <label for="additional">অতিরিক্ত বিষয়গুলো এখানে লিখুন!</label>
                                                    <textarea type="text" wire:model="cloth_additional" class="form-control"
                                                        placeholder="সংযোজিত"></textarea>
                                                    @error('cloth_additional') <div class="text-danger">{!!$message!!} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Upper Design Start --}}
                                        <div class="col-md-12">
                                            <div class="panzabi_shart_fotua_desing_wrapper">
                                                <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                    <input type="checkbox" wire:model="upper_design_show" wire:change="groupTitleControl" class="custom-control-input" id="upper-design-show">
                                                    <label class="custom-control-label" for="upper-design-show"><h5>ডিজাইন</h5></label>
                                                </div>
                                                @if ($upper_design_show && $clothDesignPortion->count()>0 && $desgnGroups->count()>0)
                                                    @foreach ($desgnGroups as $group)
                                                        @if ($clothDesignPortion->where('type', $group->slug)->count())
                                                        <div class="card card-body fz-13 single-design-group">
                                                            <h5>{{$group->name}}</h5>
                                                            <div class="row">
                                                        @endif
                                                        @foreach ($clothDesignPortion->where('type', $group->slug) as $design)
                                                            @php
                                                                $apply_on_obj = json_decode($design->apply_on);
                                                                $is_show = $allproducts->where('id',array_filter($up_products)[0])->first()->slug;
                                                            @endphp
                                                            @if (isset($apply_on_obj->$is_show) && $apply_on_obj->$is_show)
                                                                <div class="col-lg-2 col-sm-6 single_design_item design_bg sarwani" style="background:url({{--asset('assets/img/')--}})">
                                                                    <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                                        <input type="checkbox" wire:model="up_designs_check.{{$design->id}}"
                                                                            wire:change="fillEmptyStyleField({{$design->id}})"
                                                                            value="{{ $design->id }}"
                                                                            id="style_{{$design->id}}" @if( in_array( $design->id, array_keys($up_design_fields)) && $up_design_fields[$design->id] !='' &&  in_array( $design->id, array_keys(array_filter($up_designs_check)))==false ) class="custom-control-input is-invalid" required @else class="custom-control-input" @endif>
                                                                        <label class="custom-control-label"
                                                                            for="style_{{$design->id}}">{{$design->name}}</label>
                                                                                <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                                                                        @error("designs_check.$design->id") <div class="text-danger">
                                                                            {!!$message!!}</div> @enderror
                                                                        <textarea rows="1" wire:model="up_design_fields.{{ $design->id }}" rows="1"
                                                                            class="form-control" value="{{$design->id}}"></textarea>
                                                                    </div>
                                                                </div>
                                                            @endif                                                                
                                                            {{-- =================== --}}
                                                            
                                                        @endforeach
                                                        @if ($clothDesignPortion->where('type', $group->slug)->count())</div></div>@endif
                                                    @endforeach
                                            @endif
                                            </div>
                                        </div>

                                        {{-- Upper Design End --}}
                                    @endif
                                </div>
                            </div>
                            

                            
                                {{-- Measure area End --}}
                            <div class="row">
                                <div class="col-lg-12 py-5 @error('products')bg-warning @enderror product_name cloth_name">
                                    <h5 class="d-block mb-4">সালোয়ার, পাজামা,প্যান্ট ইত্যাদি জাতীয় পোশাক</h5>
                                    <div class="row ">
                                        @if ($lowerProductsPart)
                                        @foreach ($lowerProductsPart as $Lproduct)
                                        <div class="col-sm-2 col-xs-6" style="position: relative;">
                                            <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                <input type="checkbox" wire:model="lo_products" name="dresses"
                                                    value="{{$Lproduct->id}}"
                                                    class="custom-control-input @error('products')form-control is-invalid @enderror"
                                                    id="product_{{$Lproduct->id}}">
                                                <label class="custom-control-label"
                                                    for="product_{{$Lproduct->id}}">{{$Lproduct->name}} <img
                                                        src="{{asset('assets/img/undraw_profile.svg')}}"
                                                        class="img-thumbnail-" width="30" alt=""></label>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                    </div> {{--dresh panzabi .row end--}}
                                    {{-- @endforeach --}}
                                    @error('lo_products') <div class="invalid-feedback"> {!!$message!!} </div> @enderror
                                </div>
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-6 mb-3"> </div>
                                        @if (DB::table('size_charts')->count()>0)
                                        <div class="col-xl-6 mb-3">
                                            <label for="deliverysystem"> নির্ধারিত সাইজ </label>
                                            <select wire:model="readymade_size" class="custom-select d-block w-100"
                                                id="deliverysystem" required>
                                                <option value="0">Select Size</option>
                                                @foreach (DB::table('size_charts')->get() as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach

                                            </select>
                                            @error('readymade_size')<div class="text-danger"> {!!$message!!}</div> @else<div
                                                class="invalid-feedback"> Select a delivery system name</div> @enderror
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @if(count($lo_products)>0 && in_array($lo_products[0], $lowerArr))
                                    {{-- Measure ment area --}}
                                    <div class="col-md-12 pt-4">
                                        <div class="row">
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothlength">লম্বা</label>
                                                <input wire:model="length" type="text" class="form-control @error('length')is-invalid @enderror"
                                                    id="clothlength" placeholder="লম্বা" required>
                                                @error('length')<div class="text-danger">পোশাকের লম্বা{!!$message!!}</div>@enderror
                                            </div>
                                            
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothlength">পায়ের মুহুরী</label>
                                                <input wire:model="around_ankle" type="text" class="form-control @error('around_ankle')is-invalid @enderror"
                                                    id="clothlength" placeholder="পায়ের মুহুরী" required>
                                                @error('around_ankle')<div class="text-danger">পায়ের মুহুরী{!!$message!!}</div>@enderror
                                            </div>
                                            
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothcrotch">পায়ের মুহুরী</label>
                                                <input wire:model="crotch" type="text" class="form-control @error('crotch')is-invalid @enderror"
                                                    id="clothcrotch" placeholder="পায়ের মুহুরী" required>
                                                @error('crotch')<div class="text-danger">পায়ের মুহুরী{!!$message!!}</div>@enderror
                                            </div>
                                            
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothcrotch">কোমর</label>
                                                <input wire:model="waist" type="text" class="form-control @error('waist')is-invalid @enderror"
                                                    id="clothwaist" placeholder="কোমর" required>
                                                @error('waist')<div class="text-danger">কোমরের পরিমাপ{!!$message!!}</div>@enderror
                                            </div>

                                            <div class="col-lg-2 mb-3">
                                                <label for="clothcrotch">রাবার</label>
                                                <input wire:model="rubber" type="text" class="form-control @error('rubber')is-invalid @enderror" id="clothrubber" placeholder="রাবার">
                                                @error('rubber')<div class="text-danger">রাবার{!!$message!!}</div>@enderror
                                            </div>

                                        </div>
                                        <div class="row ">
                                            <div class="col-lg-12 col-sm-12 mx-lg-auto mb-3">
                                                <label for="additional">অতিরিক্ত বিষয়গুলো এখানে লিখুন!</label>
                                                <textarea type="text" wire:model="lower_additional" class="form-control"
                                                    placeholder="সংযোজিত"></textarea>
                                                @error('lower_additional') <div class="text-danger">সংযোজিত{!!$message!!} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12"></div>
                                
                                {{-- <div class="col-lg-6 col-sm-12 mx-lg-auto mb-3">
                                    <h6>অর্ডারের নমুনা ছবিঃ</h6>
                                    <div class="custom-file my-1">
                                        <input wire:model="order_sample_images" type="file"
                                            class="custom-file-input" id="orderSampleImage" multiple>
                                        <label class="custom-file-label" for="orderSampleImage">অর্ডারের নমুনা
                                            ছবিঃ</label>
                                        @error('order_sample_images') <div class="text-danger">{!!$message!!}
                                        </div> @else <div class="invalid-feedback">সঠিক ছবি যুক্ত করুন! ছবির ধরন
                                            (jpg, jpeg, png)!</div>@enderror
                                    </div>
                                    @if ( $order_sample_images )
                                    <span class="temp_img_wrap">
                                        @foreach ($order_sample_images as $sample)
                                        <img src="{{$sample->temporaryUrl()}}" width="60" alt="">
                                        @endforeach
                                    </span>
                                    @endif
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Order Delivery Start-->
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
                                    <select wire:model="delivery_system" class="custom-select d-block w-100"
                                        id="deliverysystem" required>
                                        <option value="0">নির্বাচন করুন</option>
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
                                    <input wire:model="courier_details" type="text" class="form-control"
                                        id="couriername" placeholder="কুরিয়ার এর নাম এবং শাখার বিস্তারিত..."
                                        required>
                                    @error('courier_details') <div class="text-danger">{!!$message!!}</div> @else
                                    <div class="invalid-feedback">Courier details is required.</div>@enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="coun_try">দেশ</label>
                                    <select wire:model="country" class="custom-select d-block w-100" id="coun_try"
                                        required>
                                        <option>...</option>
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

                        <!-- Order Delivery Start-->
                        <div class="col-xl-12">
                            <div class="product_role_container container-fluid">
                                <!-- DataTales Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h3>মজুরি(WAGES)</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-2 text-center">
                                                <h6 class=" border-bottom mb-2 pb-1">পোশাক</h6>
                                                {{-- <p>
                                                    @foreach ($allproducts as $product)
                                                        @if ($product->id == $products)
                                                            <p>{{$product->name}}</p>
                                                        @endif
                                                    @endforeach
                                                </p> --}}
                                            </div>
                                            <div class="col-lg-2">
                                                <h6 class="text-center border-bottom mb-2 pb-1">@error('quantity')<span class="text-danger">পরিমাণ{!!$message!!}
                                                </span>@else পরিমাণ @enderror </h6>
                                                <p><input type="number" min="1" wire:model="quantity"
                                                        class="form-control @error('quantity')is-invalid @enderror" placeholder="পরিমাণ" required></p>
                                            </div>

                                            <div class="col-lg-2">
                                                <h6 class="text-center border-bottom mb-2 pb-1">@error('wages')<span
                                                        class="text-danger">মজুরি{!!$message!!}</span> @else মজুরি
                                                    @enderror </h6>
                                                <p>
                                                    <input type="number" wire:model="wages" class="form-control @error('wages')is-invalid @enderror"
                                                        placeholder="মজুরি" required>
                                                <div class="invalid-feedback">আইটেম এর পরিমান দিন!</div>
                                                </p>
                                            </div>
                                            <div class="col-lg-2">
                                                <h6 class="text-center border-bottom mb-2 pb-1">ছাড়
                                                    @error('discount')<span class="text-danger">{!!$message!!}</span>
                                                    @enderror </h6>
                                                <p><input type="number" wire:model="discount" class="form-control"
                                                        placeholder="ছাড়"></p>
                                            </div>
                                            <div class="col-lg-2">
                                                <h6 class="text-center border-bottom mb-2 pb-1">অগ্রিম
                                                    @error('advance')<span class="text-danger">{!!$message!!}</span>
                                                    @enderror </h6>
                                                <p><input type="number" wire:model="advance" class="form-control @error('advance')is-invalid @enderror"
                                                        placeholder="অগ্রিম.."></p>
                                            </div>
                                            <div class="col-lg-2">
                                                <h6 class="text-center border-bottom mb-2 pb-1">@error('total')<span class="text-danger">মোটের পরিমান{!!$message!!}</span>
                                                    @else মোট@enderror</h6>
                                                <p><input type="number" wire:model="total" class="form-control @error('total')is-invalid @else {{$total?'is-valid':''}} @enderror"
                                                        placeholder="মোট" required></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              <button type="submit" class="btn btn-primary"> <i class="fa fa-cart-plus" aria-hidden="true"></i> Place</button>
        </form>
        </div>
      </div>
      <div class="container-fluid was-valideted">
      {{-- @if ($clothDesignPortion->count()>0 && $desgnGroups->count()>0)
        @foreach ($desgnGroups as $group)
            @if ($clothDesignPortion->where('type', $group->slug)->count())<div class="card card-body fz-13">
                <h5>{{$group->name}}</h5>
                <div class="row">
                @endif        
                
                @foreach ($clothDesignPortion->where('type', $group->slug) as $design)
                
                    <div class="col-lg-2 col-sm-6 design_bg sarwani" style="background:url()">
                        <div class="custom-control custom-checkbox mb-1 d-inline-block">
                            <input type="checkbox" wire:model="up_designs_check.{{$design->id}}"
                                wire:change="fillEmptyStyleField({{$design->id}})"
                                value="{{ $design->id }}"
                                id="style_{{$design->id}}" @if( in_array( $design->id, array_keys($up_design_fields)) && $up_design_fields[$design->id] !='' &&  in_array( $design->id, array_keys(array_filter($up_designs_check)))==false ) class="custom-control-input is-invalid" required @else class="custom-control-input" @endif>
                            <label class="custom-control-label"
                                for="style_{{$design->id}}">{{$design->name}}</label>
                                    <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                            @error("designs_check.$design->id") <div class="text-danger">
                                {!!$message!!}</div> @enderror
                            <textarea rows="1" wire:model="up_design_fields.{{ $design->id }}" rows="1"
                                class="form-control" value="{{$design->id}}"></textarea>
                        </div>
                    </div>
                @endforeach
            @if ($clothDesignPortion->where('type', $group->slug)->count())</div></div>@endif
        @endforeach
      @endif --}}
    </div>
    <div class="clipboard" style="clip-path: polygon(85% 6%, 70% 15%, 30% 15%, 15% 5%, 0% 25%, 10% 45%, 10% 75%, 25% 90%, 40% 95%, 60% 95%, 75% 91%, 90% 75%, 90% 45%, 100% 25%);">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati ad quaerat repellendus temporibus recusandae tenetur repellat optio nostrum? Adipisci voluptates ut dolores ullam alias rerum, ipsum magnam aperiam aliquid distinctio!</div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function(){
        // Delivery Date
            $('#delivery_date').on('change', function (s) {
            @this.set('delivery_date', s.target.value);
        });
        //Plate Select

        $('.plate_type_wrapper input[type=radio]').on('change', function (r) {
            console.log(r.target.value);
            @this.set('plate_type', r.target.value);
        });
        $("#forcePreviousDate").on("change",function () {
            if ($(this).is(":checked")) {
                flickerfun('');
            }else{
                flickerfun('today');
            }
        });
        function flickerfun(parms=null) {
            // console.log("");
            $("#delivery_date").flatpickr({
            dateFormat:"Y-m-d",
            defaultDate: "{{$delivery_date}}",
            minDate:parms,
            disable: [
                function(date) {
                if("{{$weekendholiday}}") return (date.getDay()=="{{$weekendholiday}}");
                }
            ],
        });
        }
        flickerfun('today');
        });

        function showHideDesignGroupTitle() {
                const cardItems = document.querySelectorAll('.single-design-group');
                const allitems = document.querySelectorAll('.single_design_item');
                // console.log('Alhamdu lillah');
                cardItems.forEach(item => {
                    if (item.children[1].childNodes.length<2) {
                    item.remove(); 
                    }
                });
            
        }
        $(document).ready(function(){
            window.addEventListener('groupTitleShow', event => {
                showHideDesignGroupTitle();
            });
        });
    </script>

@endpush


