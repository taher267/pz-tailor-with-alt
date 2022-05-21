<div>
    <link rel="stylesheet" href="/assets/alt/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <div class="row">
                  <div class="col-sm-6">
                    <div class="card card-body">
                      @if ($errors->any())
                          <ol>
                              @foreach ($errors->all() as $e)
                              <li class="text-danger">{!!$e!!}</li>
                              @endforeach
                          </ol>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card card-body px-">{{$item_group}}
                    </div>
                  </div>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
                <h2 class="m-0 text-right border-bottom py-2 italic">অর্ডার আইটেমসমূহ</h2>
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-person"></i></a></li>
                <li class="breadcrumb-item active">আইটেমসমূহ</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid fz-13">
        <form class="form-horizontal" id="new-order" wire:submit.prevent='updateOrderItem'>
            {{-- .measurement, desing and calculation    --}}
            <div class="measurement-design-and-wages-calculation">
                  @php
                      $lowerArr=[];
                      if ($lowerProductsPart){foreach ($lowerProductsPart as $product){array_push($lowerArr,$product->id);}}
                  @endphp
                
                  <!--Lower part Start-->
                  <div class="lower-part">
                      <div class="row">
                          <!--lower product and measurement start-->
                          <!--lower product name size chart start-->
                          <div class="col-md-12 lower_products_name mb-3">
                              <div class="row">
                                  <div class="col-md-12">সালোয়ার, পাজামা,প্যান্ট ইত্যাদি জাতীয় পোশাক</div>
                                  <!--lower product name start-->
                                  <div class="col-md-6">
                                      <select wire:model="lo_products" wire:change="resetDesignFields('lower')" class="custom-select d-block w-100 @error('lo_products')is-invalid @enderror"
                                              id="up_products" required>
                                              @foreach ($lowerProductsPart as $loProduct)
                                              <option>{{$loProduct->name}}</option>
                                              @endforeach
                                          </select>
                                  </div>
                                  <!--lower product name End-->
                                  <!--lower lower Status start-->
                                  <div class="col-md-6">
                                    <select wire:model="lo_status" class="custom-select d-block w-100 @error('lo_status')is-invalid @enderror"
                                        id="lo_status" required>
                                        @foreach ($statuses as $k=> $status)
                                            <option value="{{$k}}" class="text-capitalize">{{$status}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div><!--lower Status End-->
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
                                              @if ($lower_design_show && $designItems->count()>0 && $desgnGroups->count()>0)
                                                  @foreach ($desgnGroups as $group)
                                                      <div class="card card-body fz-13 single-design-group">
                                                      <h5>{{$group->name}}</h5>
                                                          <div class="row">
                                                      @foreach ($designItems->where('type', $group->slug) as $lo_design)
                                                          @php
                                                              $apply_on_obj_lower = json_decode($lo_design->apply_on);  
                                                          @endphp
                                                          {{-- @if (isset($apply_on_obj_lower->$lo_products) && $apply_on_obj_lower->$lo_products)
                                                              <div class="col-lg-2 col-sm-6 single_design_item design_bg sarwani" style="background:url()">
                                                                  <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                                      <input type="checkbox" wire:model="lo_designs_check.{{$lo_design->id}}"
                                                                          wire:change="lowerFillEmptyStyleField({{$lo_design->id}})"
                                                                          value="{{ $lo_design->id }}"
                                                                          id="style_{{$lo_design->id}}" @if( gettype($lo_designs_check)==='array' && in_array( $lo_design->id, array_keys($lo_design_fields)) && $lo_design_fields[$lo_design->id] !='' &&  in_array( $lo_design->id, array_keys(array_filter($lo_designs_check)))==false ) class="custom-control-input is-invalid" required @else class="custom-control-input" @endif>
                                                                      <label class="custom-control-label"
                                                                          for="style_{{$lo_design->id}}">{{$lo_design->name}}</label>
                                                                              <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                                                                      <textarea rows="1" wire:model="lo_design_fields.{{ $lo_design->id }}" rows="1"
                                                                          class="form-control" value="{{$lo_design->id}}"></textarea>
                                                                  </div>
                                                              </div>
                                                          @endif --}}
                                                          @if (isset($apply_on_obj_lower->$lo_products) && $apply_on_obj_lower->$lo_products)
                                                          <div class="col-lg-2 col-sm-6 single_design_item design_bg sarwani" style="background:url()">
                                                              <div class="custom-control custom-checkbox mb-1 d-inline-block">
                                                                  <input type="checkbox" wire:model="lo_designs_check.{{$lo_design->id}}"
                                                                      wire:change="lowerFillEmptyStyleField({{$lo_design->id}})"
                                                                      value="{{ $lo_design->id }}"
                                                                      id="style_{{$lo_design->id}}" class="custom-control-input @error("lo_designs_check.$lo_design->id")is-invalid @enderror" @error("lo_designs_check.$lo_design->id") required @enderror>
                                                                  <label class="custom-control-label"
                                                                      for="style_{{$lo_design->id}}">{{$lo_design->name}}</label>
                                                                          <div class="invalid-feedback"> <i class="fa fa-check" style="color:#34E3A4"></i> টিক দিন!</div>
                                                                  <textarea rows="1" wire:model="lo_design_fields.{{ $lo_design->id }}" rows="1"
                                                                      class="form-control"></textarea>
                                                              </div>
                                                          </div>
                                                      @endif
                                                      @endforeach
                                                      <!--Card Bottom Start-->
                                                  </div></div>
                                                  <!--Card Bottom end-->
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
              </div><!--Order Sample part End-->
              </div> 
          <button type="submit" class="btn btn-primary">আপডেত আইটেম <i class="fa fa-rotate-right"></i></button>
          </form>
      </div>  
</div>
@push('scripts')
   <script>
       window.addEventListener('design_alert', event => {
            Toast.fire({
                icon: event.detail.effect,
                title: event.detail.message
            });
        });</script> 
@endpush
