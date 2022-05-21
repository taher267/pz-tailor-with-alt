<div>
    @if ($order_management_id)
        @section('title','New Order Item')
    @else
        @section('title','New Order')
    @endif 
<style>
    .ordered_products span:nth-child(even){
        color:#2D88F3;
    }
</style>
    <link rel="stylesheet" href="/assets/alt/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
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
                <h2 class="m-0 text-right border-bottom py-2 italic">নতুন অর্ডার {!!$order_management_id?"<span class='text-primary'>আইটেম</span>":""!!}</h2>
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{$order_management_id?"#":route('customers')}}"><i class="fa fa-users"></i>
                    @if ($order_management_id) অর্ডার আইটেম সমূহঃ @else গ্রাহকসমূহঃ@endif </a></li>
                <li class="breadcrumb-item active">নতুন অর্ডার {!!$order_management_id?"<span class='text-primary'>আইটেম</span>":""!!}</li>
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
          <form class="form-horizontal" id="new-order" wire:submit.prevent='addOrder'>
              @if ($order_management_id==null)
                <div class="delivery-information">
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
                                
                                @if ($delivery_date &&  $weekendholiday && ($delivery_date===$weekendholiday))
                                @php
                                    $selectedDay = Carbon\Carbon::createFromFormat('Y-m-d',$delivery_date)->dayOfWeek;
                                @endphp
                                <p class="mt-3" style="color: #2D88F3">
                                    ({{$delivery_date}}),
                                    নির্বাচিত তারিখটি
                                    @if ($selectedDay=='6') শনিবার
                                    @elseif($selectedDay=='0')রবিবার
                                    @elseif ($selectedDay=='1') সোমবার
                                    @elseif ($selectedDay=='2') মঙ্গলবার
                                    @elseif ($selectedDay=='3')বুধবার
                                    @elseif ($selectedDay=='4') বৃহস্পতিবার
                                    @elseif($selectedDay=='5') শুক্রবার
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
              @endif
              {{-- Step 2 --}}
              {{-- .measurement, desing and calculation    --}}
              <div class="measurement-design-and-wages-calculation">
                    @php
                        $uperArr=[];
                        $lowerArr=[];
                        if ($upperProductsPart){foreach ($upperProductsPart as $product){array_push($uperArr,$product->id);}}
                        if ($lowerProductsPart){foreach ($lowerProductsPart as $product){array_push($lowerArr,$product->id);}}
                    @endphp
                    <!--Upper part-->
                    <div class="upper-part">
                        <div class="row">
                            <!--Upper product and measurement start-->
                            <!--Upper product name size chart start-->
                            <div class="col-md-12 upper_products_name mb-3">
                                <div class="row">
                                    <div class="col-md-12"><h5 class="d-block mb-4">পাঞ্জাবি শার্ট ফতুয়া ইত্যাদি জাতীয় পোশাক</h5></div>
                                    <!--Upper product name start-->
                                    <div class="col-md-{{$up_products && $up_products?4:12}} mb-2">
                                        <div class="@error('up_products')bg-warning @enderror">
                                            <select wire:model="up_products" wire:change="resetDesignFields('upper')" class="custom-select d-block w-100 @error('up_products')is-invalid @enderror"
                                                id="up_products" required>
                                                <option value="0">নির্বচন করুনঃ</option>
                                                @foreach ($upperProductsPart as $upProduct)
                                                <option>{{$upProduct->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--Upper product name End-->
                                    @if($up_products)
                                        <div class="col-md-4 mb-2">
                                            <select wire:model="up_status" class="custom-select d-block w-100 @error('up_status')is-invalid @enderror"
                                                id="up_status" required>
                                                @foreach ($statuses as $k=> $status)
                                                    <option value="{{$k}}" class="text-capitalize">{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--Upper Readymade size start-->
                                        <div class="col-md-4 mb-2">
                                            <h4>readymade size</h4>
                                        </div><!--Upper Readymade size start-->
                                    @endif
                                </div>
                            </div><!--Upper product name size chart start-->
                            
                            <!--Upper measurement && Design start-->
                            @if($up_products)
                                <div class="col-md-12">
                                    <div class="row">
                                        <!--Upper measurement Start-->
                                        <div class="col-md-12 mt-3">
                                            <div class="upper-measurement">
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
                                                            <label for="enclosure">@error('cloth_enclosure')<span class="text-danger">পোশাকের ঘের{!!$message!!}</span> @else<span class="">ঘের</span>@enderror</label>
                                                            <input wire:model.debounce.500ms="cloth_enclosure" type="text" class="form-control"
                                                                id="enclosure" placeholder="ঘের">
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
                                                            <div class="col-md-12"><label class="@error('plate')@else{{!$plate?'text-danger':''}}@enderror">প্লেটের ধরণ নির্বাচন করুন</label></div>
                                                            <div class="col-md-6">
                                                                <div class="card bg-dark text-white p-0">
                                                                    <img src="/assets/alt/dist/img/tailors/flat-plate.png" class="card-img" alt="...">
                                                                    <div class="card-img-overlay p-1">
                                                                        <div class="form-group form-check text-center mt-3">
                                                                            <input type="checkbox" class="form-check-input" wire:model="plate.flat" id="plate_1">
                                                                            <label class="form-check-label" for="plate_1"></label>
                                                                        </div>
                                                                        <textarea class="bg-transparent mw-100" wire:model="plate.flat_field"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card bg-dark text-white p0">
                                                                    <img src="/assets/alt/dist/img/tailors/angle-plate.png" class="card-img" alt="...">
                                                                    <div class="card-img-overlay p-1">
                                                                        <div class="form-group form-check text-center mt-3">
                                                                            <input type="checkbox" class="form-check-input" wire:model="plate.angle" id="plate_2">
                                                                            <label class="form-check-label" for="plate_2"></label>
                                                                        </div>
                                                                        <textarea class="bg-transparent mw-100" wire:model="plate.angle_field"></textarea>
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
                                                                <div class="card bg-dark text-white p-0">
                                                                    <img src="/assets/alt/dist/img/tailors/round-plate.png" class="card-img" alt="...">
                                                                    <div class="card-img-overlay p-1">
                                                                        <div class="form-group form-check text-center mt-3">
                                                                            <input type="checkbox" class="form-check-input" wire:model="pocket.flat" id="pocket_1">
                                                                            <label class="form-check-label" for="pocket_1"></label>
                                                                        </div>
                                                                        <textarea class="bg-transparent mw-100" wire:model="pocket.flat_field"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card bg-dark text-white p0">
                                                                    <img src="/assets/alt/dist/img/tailors/angle-pocket.png" class="card-img" alt="...">
                                                                    <div class="card-img-overlay p-1">
                                                                        <div class="form-group form-check text-center mt-3">
                                                                            <input type="checkbox" class="form-check-input" wire:model="pocket.angle" id="pocket_2">
                                                                            <label class="form-check-label" for="pocket_2"></label>
                                                                        </div>
                                                                        <textarea class="bg-transparent mw-100" wire:model="pocket.angle_field"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 mx-lg-auto mb-3">
                                                        <label for="additional">অতিরিক্ত বিষয়গুলো এখানে লিখুন!</label>
                                                        <textarea type="text" wire:model="cloth_additional" class="form-control"
                                                            placeholder="সংযোজিত"></textarea>
                                                        @error('cloth_additional') <div class="text-danger">{!!$message!!} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--Upper measurement end-->
                                    </div>
                                </div>
                                <!--Upper Design start-->
                                <div class="col-md-12">
                                    <div class="panzabi_shart_fotua_desing_wrapper">
                                        <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                            <input type="checkbox" wire:model="upper_design_show" class="custom-control-input" id="upper-design-show" required/>
                                            <label class="custom-control-label" for="upper-design-show"><h5>ডিজাইন</h5></label>
                                        </div>
                                        <div class="upper-designs-cards-wrapper">
                                            @if ($upper_design_show && $UpDesignItems->count()>0 && $desgnGroups->count()>0)
                                                @foreach ($desgnGroups as $group)
                                                @if ($UpDesignItems->where('type', $group->slug)->count()>0)
                                                    <div class="card card-body fz-13 single-design-group">
                                                        <h5>{{$group->name}}</h5>
                                                        <div class="row">
                                                            @endif
                                                             @foreach ($UpDesignItems->where('type', $group->slug) as $up_design)
                                                                <div class="col-lg-2 col-sm-6 single_design_item design_bg sarwani" style="background:url('')">
                                                                    <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                                        <input type="checkbox" wire:model="up_designs_check.{{$up_design->id}}"
                                                                            wire:change="upperFillEmptyStyleField({{$up_design->id}})"
                                                                            value="{{ $up_design->id }}"
                                                                            id="style_{{$up_design->id}}" @if( in_array( $up_design->id, array_keys($up_design_fields)) && $up_design_fields[$up_design->id] !='' &&  in_array( $up_design->id, array_keys(array_filter($up_designs_check)))==false ) class="custom-control-input is-invalid" required @else class="custom-control-input" @endif>
                                                                        <label class="custom-control-label"
                                                                            for="style_{{$up_design->id}}">{{$up_design->name}}</label>
                                                                                <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                                                                        @error("up_designs_check.$up_design->id") <div class="text-danger">
                                                                            {!!$message!!}</div> @enderror
                                                                        <textarea rows="1" wire:model="up_design_fields.{{ $up_design->id }}" rows="1"
                                                                            class="form-control" value="{{$up_design->id}}"></textarea>
                                                                    </div>
                                                                </div>
                                                            @endforeach 
                                                            @if ($UpDesignItems->where('type', $group->slug)->count()>0)
                                                        
                                                            </div>
                                                        </div>
                                                            @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div><!--Upper Design start-->
                                <!--Upper Wages start-->
                                <div class="col-md-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-6"><h3>মজুরি(WAGES)</h3></div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row wages-item pb-sm-3">
                                                <div class="col-lg-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">পোশাকঃ</h6>
                                                    <p class="text-info">
                                                        
                                                    </p>
                                                </div>
                                                <div class="col-lg-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">@error('upper.quantity')<span class="text-danger">পরিমাণ{!!$message!!}
                                                    </span>@else পরিমাণ @enderror </h6>
                                                    <p><input type="number" min="1" wire:model="upper.quantity"
                                                            class="form-control @error('upper.quantity')is-invalid @enderror" placeholder="পরিমাণ" required/></p>
                                                </div>
                                                <div class="col-lg-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">@error('upper.wages')<span
                                                            class="text-danger">মজুরি{!!$message!!}</span> @else মজুরি
                                                        @enderror </h6>
                                                    <p>
                                                        <input type="number" wire:model="upper.wages" class="form-control @error('upper.wages')is-invalid @enderror"
                                                            placeholder="মজুরি" required/>
                                                    </p>
                                                </div>
                                                <div class="col-md-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">ছাড়
                                                        @error('upper.discount')<span class="text-danger">{!!$message!!}</span>
                                                        @enderror </h6>
                                                    <p><input type="number" wire:model="upper.discount" class="form-control"
                                                            placeholder="ছাড়"></p>
                                                </div>
                                                <div class="col-md-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">অগ্রিম
                                                        @error('upper.advance')<span class="text-danger">{!!$message!!}</span>
                                                        @enderror </h6>
                                                    <p><input type="number" wire:model="upper.advance" class="form-control @error('upper.advance')is-invalid @enderror"
                                                            placeholder="অগ্রিম.."/></p>
                                                </div>
                                                <div class="col-lg-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">@error('upper.total')<span class="text-danger">মোটের পরিমান{!!$message!!}</span>
                                                        @else মোট@enderror</h6>
                                                    <p><input type="number" wire:model="upper.total" class="form-control @error('upper.total')is-invalid @enderror"
                                                            placeholder="মোট" required/></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Upper Wages End-->
                            @endif
                            <!--Upper measurement && Design end-->
                            <!--Upper product and measurement end-->
                            
                        </div>
                    </div>
                    <!--Upper part End-->
                    <!--Lower part Start-->
                    <div class="lower-part">
                        <div class="row">
                            <!--lower product and measurement start-->
                            <!--lower product name size chart start-->
                            <div class="col-md-12 lower_products_name mb-3">
                                <div class="row">
                                    <div class="col-md-12"><h5>সালোয়ার, পাজামা,প্যান্ট ইত্যাদি জাতীয় পোশাক</h5></div>
                                    <!--lower product name start-->
                                    <div class="col-md-{{$lo_products && $lo_products?4:12}}">
                                        <select wire:model="lo_products" wire:change="resetDesignFields('lower')" class="custom-select d-block w-100 @error('lo_products')is-invalid @enderror"
                                                id="up_products" required>
                                                <option value="0">নির্বচন করুনঃ</option>
                                                @foreach ($lowerProductsPart as $loProduct)
                                                <option>{{$loProduct->name}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    @if($lo_products && $lo_products)
                                    <!--lower product name End-->
                                    <div class="col-md-4">
                                        <select wire:model="lo_status" class="custom-select d-block w-100 @error('lo_status')is-invalid @enderror"
                                            id="lo_status" required>
                                            @foreach ($statuses as $k=> $status)
                                                <option value="{{$k}}" class="text-capitalize">{{$status}}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <!--lower Readymade size start-->
                                    <div class="col-md-4">
                                        <h4>readymade size</h4>
                                    </div><!--lower Readymade size start-->
                                    @endif
                                </div>
                            </div><!--lower product name size chart start-->
                            
                            <!--lower measurement && Design start-->
                            @if($lo_products)
                                <div class="col-md-12">
                                    <div class="row">
                                        <!--lower measurement Start-->
                                        <div class="col-md-12">
                                            <div class="lower-measurement">
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
                                                        <label for="clothcrotch">হাই</label>
                                                        <input wire:model.debounce.500ms="crotch" type="text" class="form-control @error('crotch')is-invalid @enderror"
                                                            id="clothcrotch" placeholder="হাই" required>
                                                        @error('crotch')<div class="text-danger">হাই{!!$message!!}</div>@enderror
                                                    </div>
                                                    
                                                    <div class="col-lg-2 mb-3">
                                                        <label for="clothcrotch">কোমর</label>
                                                        <input wire:model.debounce.500ms="waist" type="text" class="form-control @error('waist')is-invalid @enderror"
                                                            id="clothwaist" placeholder="কোমর" required>
                                                        @error('waist')<div class="text-danger">কোমরের পরিমাপ{!!$message!!}</div>@enderror
                                                    </div>
                                                    
                                                    <div class="col-lg-2 mb-3">
                                                        <label for="clothcrotch">রানের লুজ</label>
                                                        <input wire:model.debounce.500ms="thigh_loose" type="text" class="form-control @error('thigh_loose')is-invalid @enderror"
                                                            id="cloththigh_loose" placeholder="রানের লুজ" required>
                                                        @error('thigh_loose')<div class="text-danger">রানের লুজের পরিমাপ{!!$message!!}</div>@enderror
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
                                            </div>
                                        </div><!--lower measurement end-->
                                    </div>
                                </div>
                                <!--lower Design start-->
                                <div class="col-md-12">
                                    <div class="pazama_wrapper">
                                            <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                <input type="checkbox" wire:model.debounce.500ms="lower_design_show" class="custom-control-input" required id="lower-design-show">
                                                <label class="custom-control-label" for="lower-design-show"><h5>ডিজাইন</h5></label>
                                            </div>
                                            <div class="lower-designs-cards-wrapper">
                                                @if ($lower_design_show && $LoDesignItems->count()>0 && $desgnGroups->count()>0)
                                                    @foreach ($desgnGroups as $group)                                                    
                                                    @if ($LoDesignItems->where('type', $group->slug)->count()>0)
                                                    <div class="card card-body fz-13 single-design-group">
                                                        <h5>{{$group->name}}</h5>
                                                        <div class="row">
                                                            @endif
                                                                @foreach ($LoDesignItems->where('type', $group->slug) as $lo_design)
                                                                        <div class="col-lg-2 col-sm-6 single_design_item design_bg sarwani" style="background:url()">
                                                                            <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                                                <input type="checkbox" wire:model="lo_designs_check.{{$lo_design->id}}"
                                                                                    wire:change="lowerFillEmptyStyleField({{$lo_design->id}})"
                                                                                    value="{{ $lo_design->id }}"
                                                                                    id="style_{{$lo_design->id}}" @if( in_array( $lo_design->id, array_keys($lo_design_fields)) && $lo_design_fields[$lo_design->id] !='' &&  in_array( $lo_design->id, array_keys(array_filter($lo_designs_check)))==false ) class="custom-control-input is-invalid" required @else class="custom-control-input" @endif>
                                                                                <label class="custom-control-label"
                                                                                    for="style_{{$lo_design->id}}">{{$lo_design->name}}</label>
                                                                                        <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                                                                                @error("lo_designs_check.$lo_design->id") <div class="text-danger">
                                                                                    {!!$message!!}</div> @enderror
                                                                                <textarea rows="1" wire:model="lo_design_fields.{{ $lo_design->id }}" rows="1"
                                                                                    class="form-control" value="{{$lo_design->id}}"></textarea>
                                                                            </div>
                                                                        </div>
                                                                @endforeach <!--Card Bottom Start-->
                                                                    @if ($LoDesignItems->where('type', $group->slug)->count()>0)
                                                                    </div>
                                                                </div> <!--Card Bottom end-->
                                                            @endif
                                                    @endforeach
                                                    @else @if ($lower_design_show)
                                                            <h5 class="text-muted text-center">দুঃখিত কোন ডিজাইন নেই <i class="fa fa-exclamation-circle text-warning"></i></h5>
                                                        @endif
                                                @endif
                                            </div>
                                        </div>
                                </div><!--lower Design start-->
                                <!--lower Wages start-->
                                <div class="col-md-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-6"><h3>মজুরি(WAGES)</h3></div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row wages-item pb-sm-3">
                                                <div class="col-lg-2 col-sm-6">Dress</div>
                                                <div class="col-lg-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">@error('lower.quantity')<span class="text-danger">পরিমাণ{!!$message!!}
                                                    </span>@else পরিমাণ @enderror </h6>
                                                    <p><input type="number" min="1" wire:model.debounce.500ms="lower.quantity"
                                                            class="form-control @error('lower.quantity')is-invalid @enderror" placeholder="পরিমাণ" required/></p>
                                                </div>
                                                <div class="col-lg-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">@error('lower.wages')<span
                                                            class="text-danger">মজুরি{!!$message!!}</span> @else মজুরি
                                                        @enderror </h6>
                                                    <p>
                                                        <input type="number" wire:model.debounce.500ms="lower.wages" class="form-control @error('lower.wages')is-invalid @enderror"
                                                            placeholder="মজুরি" required/>
                                                    </p>
                                                </div>
                                                <div class="col-md-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">ছাড়
                                                        @error('discount')<span class="text-danger">{!!$message!!}</span>
                                                        @enderror </h6>
                                                    <p><input type="number" wire:model.debounce.500ms="lower.discount" class="form-control @error('lower.discount')is-invalid @enderror""
                                                            placeholder="ছাড়"></p>
                                                </div>
                                                <div class="col-md-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">অগ্রিম
                                                        @error('lower.advance')<span class="text-danger">{!!$message!!}</span>
                                                        @enderror </h6>
                                                    <p><input type="number" wire:model.debounce.500ms="lower.advance" class="form-control @error('lower.advance')is-invalid @enderror"
                                                            placeholder="অগ্রিম.."/></p>
                                                </div>
                                                <div class="col-lg-2 col-sm-6">
                                                    <h6 class="text-center border-bottom mb-2 pb-1">@error('lower.total')<span class="text-danger">মোটের পরিমান{!!$message!!}</span>
                                                        @else মোট@enderror</h6>
                                                    <p><input type="number" wire:model.debounce.500ms="lower.total" class="form-control @error('lower.total')is-invalid @enderror"
                                                            placeholder="মোট" required/></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--lower Wages End-->
                            @endif
                            <!--lower measurement && Design end-->
                            <!--lower product and measurement end-->
                            
                        </div>
                    </div>       
                    <!--Lower part End-->            
                    <!--Order Sample part Start-->
                    <div class="order sample">
                    <div class="row">
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
                    <!--Order Sample part End-->
                    <!--Total wages calculation part Start-->
                    
                <div class="total-wageses">
                    <div class="col-xl-12">
                        <div class="col-md-10 subtotal-wageses-wrapper">
                            @php
                                $upperTotal=isset($upper['total']) && $up_products && $up_products?$upper['total']:0;
                                $lowerTotal=isset($lower['total'])&& $lo_products!=null && $lo_products!=0?$lower['total']:0;
                                $grandTotal = $upperTotal+$lowerTotal;
                            @endphp
                            <h5 class="border-top text-right"><span>মোট মজুরি= {{$grandTotal}}</span><span class="text-info"> টাকা
                                ।</span></h5>
                        </div>
                    </div>         
                </div>
                    <!--Total wages calculation part End-->
                </div> 
            <button type="submit" class="btn btn-primary"> <i class="fa fa-cart-plus" aria-hidden="true"></i> Place</button>
        </form>
        </div>   
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- SweetAlert2 -->
<script src="/assets/alt/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function(){
            
        // Delivery Date
            $('#delivery_date').on('change', function (s) {
            @this.set('delivery_date', s.target.value);
        });
        
   
        $("#forcePreviousDate").on("change",function () {
            if ($(this).is(":checked")) {
                flickerfun('');
            }else{
                flickerfun('today');
            }
        });        
        function disabledDate(date) {
            const d = new Date("{{$weekendholiday}}");
            return (date.getDay()===d.getDay());
        }
        // window.addEventListener('date_disabled_data', event => {
        //     if (!countPush) {
        //         countPush++;
        //         Object.values(event.detail.data).forEach(val => {
        //             console.log(val);
        //     });
        //     }
            
        // });
        function flickerfun(parms=null) {
            $("#delivery_date").flatpickr({
            dateFormat:"Y-m-d",
            defaultDate: "{{$delivery_date}}",
            minDate:parms,
            disable:[
                function (date) {
                    const d = new Date("{{$weekendholiday}}");
                    return (date.getDay()===d.getDay());
                },
            ].concat(`{{$othersHoliday}}`.split(',')),
        }
        );
        }
        flickerfun('today');
       //Toastr
       var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        $('.swalDefaultError').click(function() {
            Toast.fire({
                icon: 'error',
                title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
            })
        });
        window.addEventListener('design_alert', event => {
            Toast.fire({
                icon: event.detail.effect,
                title: event.detail.message
            });
        });

        window.addEventListener('reset_form', event => {
            document.getElementById("new-order").reset();
        });
        // const arr = `$othersHoliday`
        // console.log(typeof arr);
        });//end document.ready
       
    </script>

@endpush


