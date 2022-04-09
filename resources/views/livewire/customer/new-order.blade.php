<div>
<style>
    .ordered_products span:nth-child(even){
        color:#2D88F3;
    }
</style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <div class="row">
                  <div class="col-sm-6">
                    <div class="card card-body">
                        <div class="row"><div class="col-sm-6 text-primary">অর্ডার নম্বরঃ</div><div class="col-sm-6">{{$order_number}}</div></div>
                        <div class="row"><div class="col-sm-6 text-primary">মোবাইল </div><div class="col-sm-6">{{$mobile}}</div></div>
                        <div class="row"><div class="col-sm-6 text-primary">গত ডেলিভেরীঃ</div><div class="col-sm-6"></div></div>
                        {{-- <div class="row"><div class="col-sm-6">নামঃ মোবাইল নম্বরঃ মোট  গত ডেলিভেরী</div></div> --}}
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card card-body px-0">
                        <div class="row"><div class="col-sm-6 text-right text-primary">নামঃ </div><div class="col-sm-6">{{$name}}</div></div>
                        <div class="row"><div class="col-sm-6 text-right text-primary">মোবাইল নম্বরঃ</div><div class="col-sm-6">{{$mobile}}</div></div>
                        <div class="row"><div class="col-sm-6 text-right text-primary">ডেলিভেরীঃ</div><div class="col-sm-6"></div></div>
                        {{-- <div class="row"><div class="col-sm-6">নামঃ মোবাইল নম্বরঃ মোট অর্ডার গত ডেলিভেরী</div></div> --}}
                    </div>
                  </div>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
                <h2 class="m-0 text-right border-bottom py-2 italic">নতুন অর্ডার</h2>
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('customers')}}"><i class="fa fa-users"></i> গ্রাহকসমূহঃ</a></li>
                <li class="breadcrumb-item active">নতুন অর্ডার</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
      <!-- /.content-header -->
      <div class="content pl-3">
        @if ($errors->any())
        @foreach ($errors->all() as $err)
        
            <p class="text-danger">{!!$err!!}</p>
        @endforeach
      @endif
        <div class="container-fluid fz-13">
          <form class="form-horizontal" wire:submit.prevent='addOrder'>
              <div class="col-xl-12 {{--$currentStep != 1 ? 'display-none' : ''--}}">
                  <div class="personal_information">
                      <div class="row py-2" style="font-size: 13px">
                              <div class="col-md-12"><h3 class="text-muted">অর্ডারের তথ্য</h3></div>
                              <div class="col-lg-4">
                                  <p class="d-flex m-0"><label for="delivery_date">ডেলিভেরি তারিখঃ</label>
                                      <span class="ml-1"> <input type="checkbox" wire:model.debounce.500ms="force_previous_date" id="forcePreviousDate">
                                          <label style="font-size:12px" class="text-info" for="forcePreviousDate"> পূর্ববর্তী তারিখ যুক্ত করুন</label>
                                      </span>
                                  </p>
                                  
                                  <input type="text" value="{{$delivery_date}}" autocomplete="off" autofocus='off'
                                      class="form-control @error('delivery_date')is-invalid @enderror"
                                      wire-model="delivery_date" id="delivery_date" required>
  
                                  @error('delivery_date') <div class="invalid-feedback">{!!$message!!}</div>
                                  @else
                                  
                                  @if ($delivery_date &&  $weekendholiday && $weekendholiday==Carbon\Carbon::createFromFormat('Y-m-d',$delivery_date)->dayOfWeek)
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
                                    <div class="col-lg-12 py-3 @error('up_products')bg-warning @enderror product_name cloth_name">
                                        <h5 class="d-block mb-4">পাঞ্জাবি শার্ট ফতুয়া ইত্যাদি জাতীয় পোশাক</h5>
                                        <div class="row ">
                                            @if ($upperProductsPart)
                                            @foreach ($upperProductsPart as $Uproduct)
                                            <div class="col-sm-2" style="position: relative;">
                                                <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                    <input type="checkbox" wire:model="up_products" {{--wire:change="designsShowHideControl"--}} name="dresses"
                                                        value="{{$Uproduct->id}}"
                                                        class="custom-control-input @error('up_products')form-control is-invalid @enderror"
                                                        id="product_{{$Uproduct->id}}">
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
                                            {{-- @if (DB::table('size_charts')->count()>0)
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
                                            @endif --}}
                                        </div>
                                    </div>
                                    @if(count($up_products)>0 && in_array($up_products[0], $uperArr))
                                        {{-- Measure ment area --}}
                                        <div class="col-md-12 pt-3">
                                            <div class="row">
                                                <div class="col-lg-2 mb-3">
                                                    <label for="clothlong">@error('cloth_long')<span class="text-danger">পোশাকের লম্বা {!!$message!!}</span> @else <span class="{{$cloth_long==''?'text-danger':''}}">লম্বা<sup class="fz-14">*</sup></span> @enderror</label>
                                                    <input wire:model.debounce.500ms="cloth_long" type="text" class="form-control @error('cloth_long')is-invalid @enderror"
                                                        id="clothlong" placeholder="লম্বা" required>
                                                    
                                                </div>
                                                {{-- Body part Start --}}
                                                <div class="col-lg-3 col-md-6 mb-3">
                                                    <div class="mb-2">
                                                        <label for="clothbody">@error('cloth_body')<span class="text-danger">পোশাকের বডি {!!$message!!}</span> @elseবডি@enderror</label>
                                                        <input wire:model.debounce.500ms="cloth_body" type="text" class="form-control"
                                                            id="clothbody" placeholder="বডি">
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="bodyloose">বডির লুজ</label>
                                                        <input wire:model.debounce.500ms="body_loose" type="text" class="form-control"
                                                            id="bodyloose" placeholder="বডির লুজ">
                                                        @error('body_loose')<div class="text-danger"> {!!$message!!}</div> @else
                                                        <div class="invalid-feedback">পোশাকের বডি লুজ দিন?</div> @enderror
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="clothbelly">পেট</label>
                                                        <input wire:model.debounce.500ms="cloth_belly" type="text" class="form-control"
                                                            id="clothbelly" _ placeholder="পাট">
                                                        @error('cloth_belly')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">পোশাকের পেট পরিমাপ দিন?</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="bodyloose">পেটের লুজ</label>
                                                        <input wire:model.debounce.500ms="belly_loose" type="text" class="form-control"
                                                            id="bodyloose" placeholder="পাটের লুজ">
                                                        @error('belly_loose') <div class="text-danger">{!!$message!!} </div>
                                                        @else <div class="invalid-feedback">পোশাকের বডি পেট লুজের পরিমাপ দিন?
                                                        </div> @enderror
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="enclosure">@error('cloth_enclosure')<span class="text-danger">পোশাকের ঘের{!!$message!!}</span> @else<span class="{{$cloth_enclosure==''?'text-danger':''}}">ঘের<sup class="fz-14">*</sup></span>@enderror</label>
                                                        <input wire:model.debounce.500ms="cloth_enclosure" type="text" class="form-control"
                                                            id="enclosure" placeholder="ঘের" required>
                                                        @error('cloth_enclosure')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">পোশাকের ঘের দিন?</div> @enderror
                                                    </div>
                                                </div>
                                                {{-- Body Part End --}}
                                                {{-- Heeeve Area Start --}}
                                                <div class="col-lg-3 col-md-6 mb-3">
                                                    <div class="mb-2">
                                                        <label for="handlong">@error('hand_long')<span class="text-danger">পোশাকের হাতা {!!$message!!}</span> @else<span class="{{$hand_long==''?'text-danger':''}}">হাতা<sup class="fz-14">*</sup></span>@enderror</label>
                                                        <input wire:model.debounce.500ms="hand_long" type="text" class="form-control"
                                                            id="handlong" placeholder="হাতা" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="sleeveenclosure">হাতার মুহুরী</label>
                                                        <input wire:model.debounce.500ms="sleeve_enclosure" type="text" class="form-control"
                                                            id="sleeveenclosure" placeholder=" হাতার মুহুরী">
                                                        @error('sleeve_enclosure')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">হাতার মুহুরী দিন?</div> @enderror
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="clothmora">মোরা</label>
                                                        <input wire:model.debounce.500ms="cloth_mora" type="text" class="form-control"
                                                            id="clothmora" placeholder="মোরা">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="SleevePasting">হাতায় পেস্টিং</label>
                                                        <input wire:model.debounce.500ms="sleeve_pasting" type="text" class="form-control"
                                                            id="SleevePasting" placeholder="হাতায় পেস্টিং">
                                                        @error('sleeve_pasting')<div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">হাতা লম্বা হবে?</div> @enderror
                                                    </div>
                                                </div>
                                                {{-- Heeeve Area End --}}

                                                <div class="col-lg-2 col-md-6 mb-3">
                                                    <div class="mb-2">
                                                        <label for="cloththroat">@error('cloth_throat')<span class="text-danger">পোশাকের গলা {!!$message!!}</span>@else<span class="{{($cloth_throat=='' && $cloth_collar=='')?'text-danger':''}}">গলা অথবা কলার<sup class="fz-14">*</sup></span>@enderror</label>
                                                        <input wire:model.debounce.500ms="cloth_throat" type="text" class="form-control"
                                                            id="cloththroat" max="30" placeholder="গলা" @if($cloth_collar==null)
                                                            required @endif>
                                                        @error('cloth_throat') <div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback">গলার পরিমাপ দিন?</div> @enderror
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="clothcollar">@error('cloth_collar')<span class="text-danger">পোশাকের কলার {!!$message!!}</span>@else<span class="{{($cloth_throat=='' && $cloth_collar=='')?'text-danger':''}}">কলার অথবা গলা<sup class="fz-14">*</sup></span>@enderror</label>
                                                        <input wire:model.debounce.500ms="cloth_collar" type="text" class="form-control"
                                                            id="clothcollar" max="30" placeholder="কলার"
                                                            @if($cloth_throat==null) required @endif>
                                                        @if ($cloth_collar) <select class="form-control"
                                                            wire:model.debounce.500ms="collar_measure_type">
                                                            <option selected value="0">সাধারণ</option>
                                                            <option value="1">মোট</option>
                                                        </select> @endif
                                                    </div>
                                                    <div class="row mt-3 p-2 ">
                                                        <div class="col-md-12"><label class="@error('plate_type')@else{{!$plate_type?'text-danger':''}}@enderror">কলারের ধরণ নির্বাচন করুন</label></div>
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white">
                                                                <img src="/assets/alt/dist/img/tailors/flat-plate.png" class="card-img" alt="...">
                                                                <div class="card-img-overlay">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="plate_type1" wire:model="plate_type" value="1" name="plate_type" required class="custom-control-input @error('plate_type')form-control is-invalid @enderror">
                                                                        <label class="custom-control-label" for="plate_type1"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white">
                                                                <img src="/assets/alt/dist/img/tailors/flat-plate.png" class="card-img" alt="...">
                                                                <div class="card-img-overlay">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="plate_type2" wire:model="plate_type" value="2" name="plate_type" required class="custom-control-input @error('plate_type')form-control is-invalid @enderror">
                                                                        <label class="custom-control-label" for="plate_type2"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6 mb-3">
                                                    <div class="mb-2">
                                                        <label for="clothshoulder">@error('cloth_shoulder')<span class="text-danger">পোশাকের পুট {!!$message!!}</span> @else<span class="{{$cloth_shoulder==''?'text-danger':''}}">পুট<sup class="fz-13">*</sup></span>@enderror</label>
                                                        <input wire:model.debounce.500ms="cloth_shoulder" type="text" class="form-control"
                                                            id="clothshoulder" max="40" placeholder="পুট.." required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="nokeshoho">নক সহ</label>
                                                        <input wire:model.debounce.500ms="noke_shoho" type="text" class="form-control"
                                                            id="nokeshoho" placeholder="নক সহ">
                                                        @error('noke_shoho') <div class="text-danger"> {!!$message!!}</div>
                                                        @else <div class="invalid-feedback"> নক সহ দিন?</div> @enderror
                                                    </div>
                                                    <div class="row mt-3 p-2 ">
                                                        <div class="col-md-12"><label class="@error('pocket_type')text-danger @enderror">পকেটের ধরণ নির্বাচন করুন</label></div>
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white">
                                                                <img src="/assets/alt/dist/img/tailors/round-pocket.png" class="card-img" alt="...">
                                                                <div class="card-img-overlay">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="pocket_type1" name="pocket_type" wire:model="pocket_type" value="1" class="custom-control-input @error('pocket_type')form-control is-invalid @enderror">
                                                                        <label class="custom-control-label" for="pocket_type1"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white">
                                                                <img src="/assets/alt/dist/img/tailors/round-pocket.png" class="card-img" alt="...">
                                                                <div class="card-img-overlay">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="pocket_type2" wire:model="pocket_type" value="2" name="pocket_type" class="custom-control-input @error('pocket_type')form-control is-invalid @enderror">
                                                                        <label class="custom-control-label" for="pocket_type2"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
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
                                                <div class="upper-designs-cards-wrapper">
                                                    @if ($upper_design_show && $designItems->count()>0 && $desgnGroups->count()>0)
                                                        @foreach ($desgnGroups as $group)
                                                            @if ($designItems->where('type', $group->slug)->count())
                                                            <div class="card card-body fz-13 single-design-group">
                                                                <h5>{{$group->name}}</h5>
                                                                <div class="row">
                                                            @endif
                                                            @foreach ($designItems->where('type', $group->slug) as $up_design)
                                                                
                                                                    {{-- particular product basis design --}}
                                                                    @php
                                                                    $apply_on_obj_upper = json_decode($up_design->apply_on);
                                                                    $is_show = $allproducts->where('id',array_filter($up_products)[0])->first()->slug;
                                                                @endphp
                                                                @if (isset($apply_on_obj_upper->$is_show) && $apply_on_obj_upper->$is_show)
                                                                    <div class="col-lg-2 col-sm-6 single_design_item design_bg sarwani" style="background:url({{--asset('assets/img/')--}})">
                                                                        <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                                            <input type="checkbox" wire:model="up_designs_check.{{$up_design->id}}"
                                                                                wire:change="upperFillEmptyStyleField({{$up_design->id}})"
                                                                                value="{{ $up_design->id }}"
                                                                                id="style_{{$up_design->id}}" @if( in_array( $up_design->id, array_keys($up_design_fields)) && $up_design_fields[$up_design->id] !='' &&  in_array( $up_design->id, array_keys(array_filter($up_designs_check)))==false ) class="custom-control-input is-invalid" required @else class="custom-control-input" @endif>
                                                                            <label class="custom-control-label"
                                                                                for="style_{{$up_design->id}}">{{$up_design->name}}</label>
                                                                                    <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                                                                            @error("designs_check.$up_design->id") <div class="text-danger">
                                                                                {!!$message!!}</div> @enderror
                                                                            <textarea rows="1" wire:model="up_design_fields.{{ $up_design->id }}" rows="1"
                                                                                class="form-control" value="{{$up_design->id}}"></textarea>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                {{-- =================== --}}
                                                                
                                                            @endforeach
                                                            @if ($designItems->where('type', $group->slug)->count())</div></div>@endif
                                                        @endforeach
                                                            @else @if ($upper_design_show)
                                                                <h5 class="text-muted text-center">দুঃখিত কোন ডিজাইন নেই <i class="fa fa-exclamation-triangle"></i></h5>
                                                            @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Upper Design End --}}
                                    @endif
                                </div>
                            </div>
                                {{-- Measure area End --}}
                            <div class="row">
                                <div class="col-lg-12 py-5 @error('lo_products')bg-warning @enderror product_name cloth_name">
                                    <h5 class="d-block mb-4">সালোয়ার, পাজামা,প্যান্ট ইত্যাদি জাতীয় পোশাক</h5>
                                    <div class="row ">
                                        @if ($lowerProductsPart)
                                        @foreach ($lowerProductsPart as $Lproduct)
                                        <div class="col-sm-2 col-xs-6" style="position: relative;">
                                            <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                <input type="checkbox" wire:model="lo_products" name="dresses"
                                                    value="{{$Lproduct->id}}"
                                                    class="custom-control-input @error('lo_products')form-control is-invalid @enderror"
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
                                        {{-- @if (DB::table('size_charts')->count()>0)
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
                                        @endif --}}
                                    </div>
                                </div>
                                @if(count($lo_products)>0 && in_array($lo_products[0], $lowerArr))
                                    {{-- Measure ment area --}}
                                    <div class="col-md-12 pt-4">
                                        <div class="row">
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothlength">লম্বা</label>
                                                <input wire:model.debounce.500ms="length" type="text" class="form-control @error('length')is-invalid @enderror"
                                                    id="clothlength" placeholder="লম্বা" required>
                                                @error('length')<div class="text-danger">পোশাকের লম্বা{!!$message!!}</div>@enderror
                                            </div>
                                            
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothlength">পায়ের মুহুরী</label>
                                                <input wire:model.debounce.500ms="around_ankle" type="text" class="form-control @error('around_ankle')is-invalid @enderror"
                                                    id="clothlength" placeholder="পায়ের মুহুরী" required>
                                                @error('around_ankle')<div class="text-danger">পায়ের মুহুরী{!!$message!!}</div>@enderror
                                            </div>
                                            
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothcrotch">পায়ের মুহুরী</label>
                                                <input wire:model.debounce.500ms="crotch" type="text" class="form-control @error('crotch')is-invalid @enderror"
                                                    id="clothcrotch" placeholder="পায়ের মুহুরী" required>
                                                @error('crotch')<div class="text-danger">পায়ের মুহুরী{!!$message!!}</div>@enderror
                                            </div>
                                            
                                            <div class="col-lg-2 mb-3">
                                                <label for="clothcrotch">কোমর</label>
                                                <input wire:model.debounce.500ms="waist" type="text" class="form-control @error('waist')is-invalid @enderror"
                                                    id="clothwaist" placeholder="কোমর" required>
                                                @error('waist')<div class="text-danger">কোমরের পরিমাপ{!!$message!!}</div>@enderror
                                            </div>

                                            <div class="col-lg-2 mb-3">
                                                <label for="clothcrotch">রাবার</label>
                                                <input wire:model.debounce.500ms="rubber" type="text" class="form-control @error('rubber')is-invalid @enderror" id="clothrubber" placeholder="রাবার">
                                                @error('rubber')<div class="text-danger">রাবার{!!$message!!}</div>@enderror
                                            </div>
                                            <div class="col-lg-12 col-sm-12 mx-lg-auto mb-3">
                                                <label for="additional">অতিরিক্ত বিষয়গুলো এখানে লিখুন!</label>
                                                <textarea type="text" wire:model.debounce.500ms="lower_additional" class="form-control"
                                                    placeholder="সংযোজিত"></textarea>
                                                @error('lower_additional') <div class="text-danger">সংযোজিত{!!$message!!} </div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Lower Design Start --}}
                                        <div class="col-md-12">
                                            <div class="panzabi_shart_fotua_desing_wrapper">
                                                <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                    <input type="checkbox" wire:model.debounce.500ms="lower_design_show" wire:change="groupTitleControl" class="custom-control-input" id="lower-design-show">
                                                    <label class="custom-control-label" for="lower-design-show"><h5>ডিজাইন</h5></label>
                                                </div>
                                                <div class="lower-designs-cards-wrapper">
                                                    @if ($lower_design_show && $designItems->count()>0 && $desgnGroups->count()>0)
                                                        @foreach ($desgnGroups as $group)
                                                            @if ($designItems->where('type', $group->slug)->count())
                                                                @foreach ($designItems->where('type', $group->slug) as $lo_design)
                                                            @php
                                                                $apply_on_obj_lower_title = json_decode($lo_design->apply_on);
                                                                $is_lo_show_title = $allproducts->where('id',array_filter($lo_products)[0])->first()->slug;
                                                                $demo ="পাজামা";
                                                            @endphp
                                                            @if (isset($apply_on_obj_lower_title->$demo) && $apply_on_obj_lower_title->$demo)
                                                            <div class="card card-body fz-13 single-design-group">
                                                            <h5>{{$group->name}}</h5>
                                                            @endif        
                                                        @endforeach
                                                               
                                                                <div class="row">
                                                            @endif
                                                            @foreach ($designItems->where('type', $group->slug) as $lo_design)
                                                                    {{-- particular product basis design --}}
                                                                @php
                                                                    $apply_on_obj_lower = json_decode($lo_design->apply_on);
                                                                    $is_lo_show = $allproducts->where('id',array_filter($lo_products)[0])->first()->slug;
                                                                    $demo ="পাজামা";
                                                                @endphp
                                                                @if (isset($apply_on_obj_lower->$demo) && $apply_on_obj_lower->$demo)
                                                                    <div class="col-lg-2 col-sm-6 single_design_item design_bg sarwani" style="background:url()">
                                                                        <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                                            <input type="checkbox" wire:model="lo_designs_check.{{$lo_design->id}}"
                                                                                wire:change="lowerFillEmptyStyleField({{$lo_design->id}})"
                                                                                value="{{ $lo_design->id }}"
                                                                                id="style_{{$lo_design->id}}" @if( in_array( $lo_design->id, array_keys($lo_design_fields)) && $lo_design_fields[$lo_design->id] !='' &&  in_array( $lo_design->id, array_keys(array_filter($lo_designs_check)))==false ) class="custom-control-input is-invalid" required @else class="custom-control-input" @endif>
                                                                            <label class="custom-control-label"
                                                                                for="style_{{$lo_design->id}}">{{$lo_design->name}}</label>
                                                                                    <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                                                                            @error("designs_check.$lo_design->id") <div class="text-danger">
                                                                                {!!$message!!}</div> @enderror
                                                                            <textarea rows="1" wire:model="lo_design_fields.{{ $lo_design->id }}" rows="1"
                                                                                class="form-control" value="{{$lo_design->id}}"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    {{-- @else <style>.lower-empty-card-{{$group->id}}{display:none!important}</style> --}}
                                                                @endif
                                                                {{-- =================== --}}
                                                                
                                                            @endforeach
                                                                @if ($designItems->where('type', $group->slug)->count())</div></div>@endif
                                                        @endforeach
                                                        @else @if ($lower_design_show)
                                                                <h5 class="text-muted text-center">দুঃখিত কোন ডিজাইন নেই <i class="fa fa-exclamation-circle text-warning"></i></h5>
                                                            @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Lower Design End --}}
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                {{-- <div class="col-md-12"></div> --}}
                                <div class="col-lg-6 col-sm-12 mx-lg-auto mb-3">
                                    <h6>অর্ডারের নমুনা ছবিঃ</h6>
                                    <div class="custom-file my-1">
                                        <input wire:model="order_sample_images" type="file"
                                            class="custom-file-input" id="orderSampleImage" multiple>
                                        <label class="custom-file-label" for="orderSampleImage">অর্ডারের নমুনা
                                            ছবিঃ</label>
                                        @error('order_sample_images') <div class="text-danger">{!!$message!!}
                                        </div> @else <div class="invalid-feedback">সঠিক ছবি যুক্ত করুন! ছবির ধরন
                                            (jpg, jpeg, png)!</div>@enderror
                                    @if ( $order_sample_images )
                                    <span class="temp_img_wrap">
                                        @foreach ($order_sample_images as $sample)
                                        <img src="{{$sample->temporaryUrl()}}" width="60" alt="" class="d-inline-block">
                                        @endforeach
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- @if (count($up_products)>0||count($lo_products)>0)
                            
                        @endif --}}
                        <div class="col-xl-12">
                            <div class="product_role_container container-fluid">
                                <!-- DataTales Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-6"><h3>মজুরি(WAGES)</h3></div>
                                            <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <input type="url" class="form-control @error('wages_screenshot_url')is-invalid @enderror" id="wages-screenshot" wire:model.debounce.500ms="wages_screenshot_url" placeholder="https://example.com" required/>
                                                    <label for="wages-screenshot">@error('wages_screenshot_url')<div class="text-danger">মজুরীর স্ক্রিনশট লিংক{!!$message!!}</div>@else Wages Screenshot URL @enderror </label>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-2 text-center">
                                                <h6 class=" border-bottom mb-2 pb-1">পোশাক</h6>
                                                {{-- <p class="ordered_products">
                                                    @foreach ($up_products as $key=> $product)
                                                        <span title="{{count($lo_products)}}">{{$allproducts->where('id',$product)->first()->name}}@if(($key+1)===count($up_products) && count($lo_products)==0)@else,@endif</span>                                                       
                                                    @endforeach
                                                    @foreach ($lo_products as $key=> $product)
                                                        <span>{{$allproducts->where('id',$product)->first()->name}}@if(($key+1)!==count($lo_products)),@endif</span>
                                                    @endforeach
                                                </p> --}}
                                            </div>
                                            <div class="col-lg-10 wageses-wrapper">
                                                {{-- <h3>{{var_dump(count($wages_selected_products)>0 && array_values($wages_selected_products))}}</h3> --}}
                                                @foreach ($wages_inputs as $key=> $input)
                                                    <div class="row wages-item pb-sm-3">
                                                        <div class="col-lg-2 col-sm-6">
                                                            <div class="form-group">
                                                                <h6 class="text-center border-bottom mb-2 pb-1 @if($key===0) d-block @else d-md-none @endif">@error('wages_selected_products.'.$key)<span class="text-danger">নির্বাচন করুনঃ {!!$message!!}
                                                                </span>@else নির্বাচন করুনঃ @enderror</h6>
                                                                @php
                                                                    $uid= $wages_selected_products;
                                                                    $selectStatus = false;
                                                                    if (count($wages_selected_products)) {
                                                                        // $indexes = array_keys($uid, $wages_selected_products[$key]);
                                                                        // $selectStatus= count($indexes)>0?true:false;
                                                                    }                                                         
                                                                @endphp
                                                                <select class="form-control {{--count($wages_selected_products)==0 && !isset($wages_selected_products[$key]) ?'is-invalid':''}} {{--/*&& count(array_keys(count($wages_selected_products)))==0--}} @error('wages_selected_products')is-invalid @enderror" wire:model="wages_selected_products.{{$key}}" required>
  
                                                                    {{-- <option>{{var_dump(count($wages_selected_products)>0 && array_values($wages_selected_products)&& array_values())}}</option> --}}
                                                                    <option>...</option>
                                                                    @foreach ($up_products as $uproduct)
                                                                    @php
                                                                        $UselectedProduct= $allproducts->where('id',$uproduct)->first()->name;
                                                                    @endphp     
                                                                        <option>{{$UselectedProduct}}</option>
                                                                    @endforeach

                                                                    @foreach ($lo_products as $lproduct)
                                                                    @php
                                                                        $LselectedProduct= $allproducts->where('id',$lproduct)->first()->name;
                                                                    @endphp  
                                                                        <option value="{{$LselectedProduct}}">{{$LselectedProduct}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback">আইটেম এর পরিমান দিন!</div>
                                                              </div>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-6">
                                                            <h6 class="text-center border-bottom mb-2 pb-1 @if($key===0) d-block @else d-md-none @endif">@error('quantity.'.$key)<span class="text-danger">পরিমাণ{!!$message!!}
                                                            </span>@else পরিমাণ @enderror </h6>
                                                            <p><input type="number" min="1" wire:model.debounce.500ms="quantity.{{$key}}"
                                                                    class="form-control @error('quantity.'.$key)is-invalid @enderror" placeholder="পরিমাণ" required/></p>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-6">
                                                            <h6 class="text-center border-bottom mb-2 pb-1 @if($key===0) d-block @else d-md-none @endif">@error('wages.'.$key)<span
                                                                    class="text-danger">মজুরি{!!$message!!}</span> @else মজুরি
                                                                @enderror </h6>
                                                            <p>
                                                                <input type="number" wire:model.debounce.500ms="wages.{{$key}}" class="form-control @error('wages.'.$key)is-invalid @enderror"
                                                                    placeholder="মজুরি" required/>
                                                            <div class="invalid-feedback">আইটেম এর পরিমান দিন!</div>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-1 col-sm-6">
                                                            <h6 class="text-center border-bottom mb-2 pb-1 @if($key===0) d-block @else d-md-none @endif">ছাড়
                                                                @error('discount.'.$key)<span class="text-danger">{!!$message!!}</span>
                                                                @enderror </h6>
                                                            <p><input type="number" wire:model.debounce.500ms="discount.{{$key}}" class="form-control"
                                                                    placeholder="ছাড়"></p>
                                                        </div>
                                                        <div class="col-md-1 col-sm-6">
                                                            <h6 class="text-center border-bottom mb-2 pb-1 @if($key===0) d-block @else d-md-none @endif">অগ্রিম
                                                                @error('advance.'.$key)<span class="text-danger">{!!$message!!}</span>
                                                                @enderror </h6>
                                                            <p><input type="number" wire:model.debounce.500ms="advance.{{$key}}" class="form-control @error('advance.'.$key)is-invalid @enderror"
                                                                    placeholder="অগ্রিম.."/></p>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-6">
                                                            <h6 class="text-center border-bottom mb-2 pb-1 @if($key===0) d-block @else d-md-none @endif">@error('total.'.$key)<span class="text-danger">মোটের পরিমান{!!$message!!}</span>
                                                                @else মোট@enderror</h6>
                                                            <p><input type="number" wire:model.debounce.500ms="total.{{$key}}" class="form-control @error('total.'.$key)is-invalid @enderror"
                                                                    placeholder="মোট" required/></p>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-12 @if($key===0)pt-md-4 @endif">
                                                            @if ($key>0)
                                                                <button type="button" class="btn btn-danger btn-sm w-100 decrise-wages" wire:click="remove({{$key}})"><i class="fa fa-minus"></i>Remove</button>
                                                            @else
                                                                <button type="button" class="btn btn-primary btn-sm w-100 increase-wages @if($key===0) mt-md-2 @endif" wire:click="add(1)"><i class="fa fa-plus"></i> Add</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @php
                                                    $subTotal=0;
                                                    foreach (array_filter($total) as $val) {
                                                        $subTotal=$subTotal+$val;
                                                    }
                                                @endphp
                                                <div class="col-md-10 subtotal-wageses-wrapper"><h5 class="border-top text-right"><span>Grand Total= </span><span class="text-info">{{$subTotal}} BDT</span></h5></div>
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
    <div class="clipboard" style="clip-path: polygon(85% 6%, 70% 15%, 30% 15%, 15% 5%, 0% 25%, 10% 45%, 10% 75%, 25% 90%, 40% 95%, 60% 95%, 75% 91%, 90% 75%, 90% 45%, 100% 25%);">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati ad quaerat repellendus temporibus recusandae tenetur repellat optio nostrum? Adipisci voluptates ut dolores ullam alias rerum, ipsum magnam aperiam aliquid distinctio!</div>
    @php
        $uid= array(12,23,12,4,2,5,56);
        $indexes = array_keys($uid, 12); //array(0, 1)
        echo count($indexes);
    @endphp
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function(){
            
        // Delivery Date
            $('#delivery_date').on('change', function (s) {
            @this.set('delivery_date', s.target.value);
        });
        
        //Force previous date
        window.addEventListener('force_previous_date', event => {

        });
        $("#forcePreviousDate").on("change",function () {
            if ($(this).is(":checked")) {
                flickerfun('');
            }else{
                flickerfun('today');
            }
        });
        
        
        function flickerfun(parms=null) {
            $("#delivery_date").flatpickr({
            dateFormat:"Y-m-d",
            defaultDate: "{{$delivery_date}}",
            minDate:parms,
            disable: [
                function(date) {
                if("{{$weekendholiday}}"!=-1 && "{{$weekendholiday}}"<7) return (date.getDay()=="{{$weekendholiday}}");
                }
            ],
        });
        }
        flickerfun('today');
       
        });//end document.ready
    </script>

@endpush


