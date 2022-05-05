<div>
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
                       
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card card-body px-0">
                       
                    </div>
                  </div>
              </div>
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
          <form class="form-horizontal" id="new-order" wire:submit.prevent='updateOrderItem'>
              {{-- Step 2 --}}
              {{-- .measurement, desing and calculation    --}}
              <div class="measurement-design-and-wages-calculation">
                    @php
                        $uperArr=[];
                        if ($upperProductsPart){foreach ($upperProductsPart as $product){array_push($uperArr,$product->id);}}
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
                                    <div class="col-md-6">
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
                                    <!--Upper Readymade size start-->
                                    <div class="col-md-6">
                                        <h4>readymade size</h4>
                                    </div><!--Upper Readymade size start-->
                                </div>
                            </div><!--Upper product name size chart start-->
                            
                            <!--Upper measurement && Design start-->
                            @if($up_products)
                                <div class="col-md-12">
                                    <div class="row">
                                        <!--Upper measurement Start-->
                                        <div class="col-md-6">
                                            <select wire:model="up_status" class="custom-select d-block w-100 @error('up_status')is-invalid @enderror"
                                                id="up_status" required>
                                                @foreach ($statuses as $k=> $status)
                                                    <option value="{{$k}}" class="text-capitalize">{{$status}}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
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
                                                            <div class="col-md-12"><label class="{{--@error('plate')@else{{!$plate?'text-danger':''}}@enderror--}}">প্লেটের ধরণ নির্বাচন করুন</label></div>
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
                                                            <div class="col-md-12"><label class="@error('pocket')text-danger @enderror">পকেটের ধরণ নির্বাচন করুন</label></div>
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
                                            @if ($upper_design_show && $designItems->count()>0 && $desgnGroups->count()>0)
                                                @foreach ($desgnGroups as $group)
                                                    <div class="card card-body fz-13 single-design-group">
                                                        <h5>{{$group->name}}</h5>
                                                        <div class="row">
                                                            @foreach ($designItems->where('type', $group->slug) as $up_design)
                                                                @php
                                                                    $apply_on_obj_upper = json_decode($up_design->apply_on);
                                                                    // $isDesigb = json_encode([$up_products=>1], JSON_UNESCAPED_UNICODE);
                                                                    $isDesign = "$up_products";
                                                                @endphp
                                                                @if (isset($apply_on_obj_upper->$isDesign) && $apply_on_obj_upper->$isDesign)
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
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
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
        window.addEventListener('design_alert', event => {
            Toast.fire({
                icon: event.detail.effect,
                title: event.detail.message
            });
        });
    </script>

@endpush


