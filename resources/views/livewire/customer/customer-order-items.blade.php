<div>
    @section('title', 'সকল অর্ডার আইটেমসমূহ')
    <style>
        p.text-sm.text-gray-700.leading-5 {
            display: none;
        }
        .pip-do-not-print{display: none !important;}
    </style>
    <link rel="stylesheet" href="/css/panzabi-dot-com-print-layout.css">
    <div>
        @if (Session::has('success'))
        <div class="container p-3" id="delete-message">
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        </div>
        <script src="'/assets/alt/plugins/jquery/jquery.min.js"></script>
        <script>
            setTimeout(() => {
                $('#delete-message').fadeOut();
            }, 2500);
        </script>
        @endif
        
    </div>
    @php $grandTotal = 0; foreach ($orderItems as $item) { $grandTotal += json_decode($item->item_summary)->wages->total;} @endphp
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <div class="row">
                  <div class="col-sm-6">
                    <div class="card card-body">
                       Lorem ipsum dolor sit amet.
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card card-body px-">
                        মোট মজুরীঃ {{$grandTotal}}টাকা।
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
    <div class="card">
        <div class="col-md-6">
        </div>
        <div class="card-header mb-2">
            <h3 class="card-title"><i class="fa-solid fa-handshake"></i> সকল অর্ডারসমূহ</h3>
            <div class="card-tools">
                {{-- @if (isset($specificorders) && $specificorders->count()>0)
                {!!$specificorders->links()!!}
                @endif --}}
                
            </div>
        </div>
        
        <div class="card-body pt-0 border-5">
            {{-- {{print_r($orderItems)}} --}}
            @foreach ($orderItems as $ik => $item)
                    @php
                        $itemSummary = json_decode($item->item_summary);
                    @endphp
                    
                    <!--Per item calculation and print and edit start-->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4 bg-success">
                                <div class="card-body">
                                    মোট <span class="bg-warning text-white text-bold p-1">{!!$itemSummary->quantity>0 && $itemSummary->quantity<10?0:''!!}{!!$itemSummary->quantity!!}</span>টি পোশাক। মজুরীঃ {!!$itemSummary->quantity!!} X {!!($itemSummary->wages->total+$itemSummary->wages->discount)/$itemSummary->quantity!!} = {{$itemSummary->wages->discount? '(ছাড়'. $itemSummary->wages->discount.'), ':''}}{{$itemSummary->wages->total}}টাকা।
                                </div>
                            </div>
                            <div class="col-md-4 bg-primary">
                                <div class="card-body">
                                    অগ্রিমঃ <span class="text-white p-1">{!!$itemSummary->wages->advance!!}</span>টাকা, 
                                    বাকিঃ <span class="text-warning">{{$itemSummary->wages->total-$itemSummary->wages->advance}} </span>টাকা।
                                </div> 
                            </div>
                            
                            <div class="col-md-2 bg-danger">
                                <div class="card-body" title="অডারগ্রুপ ও অর্ডার আইটেমের স্ট্যাটাস(অবস্থা) পরিবর্তন। শুধুমাত্র পরিবরতনেই আপডেট হয়ে যাবে">
                                    <select class="form-control" wire:model="change_order_item_status.{{$item->id}}" wire:change='changeOrderItemStatus({{$item->id}})' id="exampleFormControlSelect1">
                                        <option value="{{$item->status}}" class="text-capitalize">{{$statuses[$item->status]}}</option>
                                        @foreach ($statuses as $k=> $status)
                                            @if($k!==$item->status)
                                                <option value="{{$k}}" class="text-capitalize">{{$status}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label class="fz-10">স্ট্যাটাস পরিবর্তন</label>
                                </div>
                            </div>
                            
                            <div class="col-md-2 bg-warning">
                                <div class="card-body">
                                    <a title="Edit" href="{{route("customer.order.edit$item->type"."item",$item->id)}}"><i class="fa fa-edit"></i></a> | 
                                    <a title="Print" class="click-to-print print-area-{{$item->id}}" href="#"><i class="fa fa-print"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Per item calculation and print and edit End-->
                        <div class="my-2 measurementPrint-1-{{$item->id}}">
                                {{-- <div class="row print-date-time- d-none" style="display: flex">
                                    <div class="col-md-2"><span>অর্ডার নং-<b>{{$order_number}}</b>-<i>({{$order_management_id}}-{{$item->id}})</i> </span></div>
                                    <div class="col-md-3"><i class="fa fa-truck"></i> <span>{{$item->itemGroup->delivery_date}}</span></div>
                                    <div class="col-md-3"><i class="fa fa-print"></i> <span>{{Carbon\Carbon::now()}}</span></div>
                                    <div class="col-md-3"><i class="fa fa-print"></i> <span>{{Carbon\Carbon::now()}}</span></div>
                                </div> --}}
                                @php
                                    $measurement = json_decode($item->measurement);
                                 $u_desings = json_decode($item->designs);
                                @endphp
                            @if ($item->type==='upper')
                            @php
                                $strCollar = $measurement->cloth_collar;
                                $jsonCollar = json_decode($measurement->cloth_collar);
                                $viewCollar=null;
                                if ($strCollar && gettype($jsonCollar)) {
                                    $viewCollar = $jsonCollar->collar."-".$jsonCollar->type==='1'?'মোট':'Something going Wrong';
                                }elseif($strCollar) {
                                    $viewCollar= $strCollar;
                                }
                            @endphp

                            <div class="panzabi-dot-com-tailots printing-area-{{$item->id}} measurementPrint-{{$item->id}}">
                                <div class="order-card-wrapper pt-4 pl-1">
                                    <div class="left-part">
                                        <div class="name-part">
                                            <p><span>{!!$measurement->product!!}-{{$itemSummary->quantity}} টি</span></p>
                                            <p><span><input type="text" class="form-control fz-11 text-right font-weight-bold p-0 border-0" style="height: 25px"/></span></p>
                                            <p><span><input type="text" class="form-control fz-11 text-right font-weight-bold p-0 border-0" style="height: 25px"/></span></p>
                                            <p><span><input type="text" class="form-control fz-11 text-right font-weight-bold p-0 border-0" style="height: 25px"/></span></p>
                                        </div>
                                    </div>
                                    <div class="right-part">
                                        <table>
                                            <tbody>
                                                <tr class="empty-tr"></tr>
                                                <tr class="">
                                                    <td></td>
                                                    <td colspan="3"><!--অর্ডার নং--><b>{{$order_number}}</b>-<i>({{$order_management_id}}-{{$item->id}})</i></td>
                                                    <td colspan="4"><!--তারিখঃ--> &nbsp; &nbsp; <i class='fa fa-print'></i> {{Carbon\Carbon::now()->format('Y-m-d')}}</td>
                                                </tr>
                                                <tr>
                                                    <!-- <td>লম্বা</td> -->
                                                    <td>{{$measurement->cloth_long}}</td>
                                                    <!-- <td>বডি</td> -->
                                                    <td>{!!$measurement->cloth_body?$measurement->cloth_body:"X"!!}</td>
                                                    <!-- <td>পুট</td> -->
                                                    <td>{!!$measurement->cloth_shoulder!!}</td>
                                                    <!-- <td>হাতা</td> -->
                                                    <td>{!!$measurement->hand_long!!}</td>
                                                    <!-- <td>কলার</td> -->
                                                    <td>{!!$viewCollar && $viewCollar ? $viewCollar : $measurement->cloth_throat!!}</td>
                                                    
                                                    <!-- <td>হাতার মুহুরী</td> -->
                                                    <td>{!!$measurement->sleeve_enclosure!!}</td>
                                                    <td>{{--বুতাম--}}</td>
                                                    <!-- <td>হাতায় পেস্টিং</td> -->
                                                    <td>{!!$measurement->sleeve_pasting!!}</td>
                                                </tr>
                                                <tr><td></td><td>{!!$measurement->body_loose?$measurement->body_loose:"X"!!}</td><td rowspan="4" colspan="3"><span class="fz-12"> একটা বাসের মোট খরচের মধ্যে যদি ৩০% ডিজেল খরচ হয়, তাহলে ১০০০ টাকারএকটা বাসের মোট খরচের মধ্যে যদি ৩০% ডিজেল খরচ হয়,</span></td><td></td><td></td><td></td></tr>
                                                <tr><td>@isset($measurement->plate_length)
                                                    {{$measurement->plate_length}}
                                                @endisset</td><td>{!!$measurement->cloth_belly?$measurement->cloth_belly:"X"!!}</td><td></td><td></td><td>f3</td></tr>
                                                <tr><td></td><td>{!!$measurement->belly_loose!!}</td><td></td><td></td><td rowspan="2">p2</td></tr>
                                                <tr><td></td><td>{!!$measurement->cloth_enclosure!!}</td><td></td><td></td></tr>
                                            </tbody>
                                        </table>
                                        <div class="mt-1 fz-12">
                                            {{-- <i class='fa fa-arrow-right'></i> --}}
                                            @php $uc = 1; @endphp
                                            @foreach ($u_desings as $key=> $design)
                                            @php $storeuC=$uc++; @endphp
                                                <span class="">{{$itemsDesings->find($key)->name}}</span><span>{!!$design?" - ".$design:''!!}</span>
                                                {{ $storeuC=== count(get_object_vars($u_desings))?'':'|'}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none-">
                                    <div class="col-md-1">
                                        {!!$measurement->product!!}
                                    </div>
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-lg-2 mb-3">
                                                <span for="clothlong">লম্বা</span>
                                                <div class="">
                                                    {{$measurement->cloth_long}}
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-3 col-md-6 mb-3">
                                                <div class="mb-2">
                                                    <span for="clothbody">বডি</span>
                                                    <div>
                                                        {!!$measurement->cloth_body!!}
                                                    </div>
                                                </div>
                                        
                                                <div class="mb-2"><span for="bodyloose">বডির লুজ</span>
                                                    <div>
                                                        {!!$measurement->cloth_body!!}
                                                    </div>
                                                </div>
                                        
                                                <div class="mb-2">
                                                    <span for="clothbelly">পেট</span>
                                                    <div>
                                                        {!!$measurement->cloth_belly!!}
                                                    </div>
                                                </div>
                                        
                                                <div class="mb-2">
                                                    <span for="bodyloose">পেটের লুজ</span>
                                                    <div>
                                                        {!!$measurement->body_loose!!}
                                                    </div>
                                                </div>
                                        
                                                <div class="mb-2">
                                                    <span for="enclosure"><span class="">ঘের</span></span>
                                                    <div>
                                                        {!!$measurement->cloth_enclosure!!}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-lg-3 col-md-6 mb-3">
                                                <div class="mb-2">
                                                    <span for="handlong">হাতা</span>
                                                    <div>
                                                        {!!$measurement->hand_long!!}
                                                    </div>                                                
                                                </div>
                                                <div class="mb-2">
                                                    <span for="sleeveenclosure">হাতার মুহুরী<span>
                                                        <div>
                                                            {!!$measurement->sleeve_enclosure!!}
                                                        </div>                                                           
                                                </div>
                                                <div class="mb-2">
                                                    <span for="clothmora">মোরা</span>
                                                    <div>
                                                        {!!$measurement->cloth_mora!!}
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <span for="SleevePasting">হাতায় পেস্টিং</span>
                                                    <div>
                                                        {!!$measurement->sleeve_pasting!!}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                            <div class="col-lg-2 col-md-6 mb-3">
                                                <div class="mb-2">
                                                    <span for="clothcollar">{!!$measurement->cloth_collar?'কলার':'গলা'!!}</span>
                                                    <div>
                                                        
                                                        {{-- @if ($strCollar && gettype($jsonCollar))
                                                        {{$jsonCollar->collar}}-{{$jsonCollar->type==='1'?'মোট':'Something going Wrong'}}
                                                        @elseif($strCollar)
                                                            {!!$strCollar!!}
                                                        @endif --}}

                                                        {{$viewCollar}}
                                                        
                                                        {{-- {!!gettype(json_decode($measurement->cloth_collar))!!} --}}
                                                        {!!$measurement->cloth_throat!!}
                                                    </div>
                                                </div>
                                                <div class="row mt-3 p-2 ">
                                                    <div class="col-md-12">বোতাম প্লেটের ধরণ</div>
                                                    @if ($measurement->plate===1)
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white p-0">
                                                                <img src="/assets/alt/dist/img/tailors/flat-plate.png" class="card-img" alt="...">
                                                                <div class="card-img-overlay p-1">
                                                                    <div class="form-group form-check text-center mt-3">
                                                                        <span class="form-check-span" for="plate_1"></span>
                                                                    </div>
                                                                    <textarea class="bg-transparent mw-100"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($measurement->plate===2)
                                                    <div class="col-md-6">
                                                        <div class="card bg-dark text-white p0">
                                                            <img src="/assets/alt/dist/img/tailors/angle-plate.png" class="card-img" alt="...">
                                                            
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 mb-3">
                                                <div class="mb-2">
                                                    <span for="clothshoulder">পুট</span>
                                                    <div>{!!$measurement->cloth_shoulder!!}</div>
                                                </div>
                                        
                                                <div class="mb-3">
                                                    <span for="nokeshoho">নক সহ</span>
                                                    <div>{!!$measurement->noke_shoho!!}</div>
                                                </div>
                                                <div class="row mt-3 p-2 ">
                                                    <div class="col-md-12"><span class="">পকেটের ধরণ</span></div>
                                                    @if ($measurement->pocket===1)
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white p-0">
                                                                <img src="/assets/alt/dist/img/tailors/round-plate.png" class="card-img" alt="...">
                                                                <div class="card-img-overlay p-1">
                                                                    <div class="form-group form-check text-center mt-3">
                                                                        
                                                                        <span class="form-check-span" for="pocket_1"></span>
                                                                    </div>
                                                                    <textarea class="bg-transparent mw-100"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($measurement->pocket===2)
                                                        <div class="col-md-6">
                                                            <div class="card bg-dark text-white p0">
                                                                <img src="/assets/alt/dist/img/tailors/angle-pocket.png" class="card-img" alt="...">
                                                                <div class="card-img-overlay p-1">
                                                                    <div class="form-group form-check text-center mt-3">
                                                                        <span class="form-check-span" for="pocket_2"></span>
                                                                    </div>
                                                                    <textarea class="bg-transparent mw-100"></textarea>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 mx-lg-auto mb-3">
                                                <label for="additional">অতিরিক্ত বিষয়গুলো</label>
                                                <textarea type="text" class="form-control" placeholder="সংযোজিত">{!!$measurement->cloth_additional!!}</textarea>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 mx-lg-auto designs fz-12">
                                                @php $count2 = 1; @endphp
                                                @foreach ($u_desings as $key=> $design)
                                                @php $storeCount=$count2++; @endphp
                                                    <span class="">{{$itemsDesings->find($key)->name}}</span><span>{{$design?'-'.$design:''}}</span>
                                                    {{ $storeCount=== count(get_object_vars($u_desings))?'':'|'}}
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-1">
                                    {!!$itemSummary->products!!} <i class="fa fa-check"></i>
                                </div>
                                <div class="col-md-11">
                                    <div class="row">
                                        <div class="col-lg-2 mb-3">
                                            <span for="clothlength">লম্বা</span>
                                            <div>
                                                {!!$measurement->length!!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2 mb-3">
                                            <span for="clothlength">পায়ের মুহুরী</span>
                                            <div>
                                                {!!$measurement->around_ankle!!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2 mb-3">
                                            <span for="clothcrotch">হাই</span>
                                            <div>
                                                {!!$measurement->crotch!!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2 mb-3">
                                            <span for="clothcrotch">কোমর</span>
                                            <div>
                                                {!!$measurement->waist!!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2 mb-3">
                                            <span for="clothcrotch">রানের লুজ</span>
                                            <div>
                                                {!!$measurement->thigh_loose!!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2 mb-3">
                                            <span for="clothcrotch">রাবার</span>
                                            <div>
                                                {!!$measurement->rubber!!}
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 mx-lg-auto mb-3">
                                            <span for="additional">অতিরিক্ত বিষয়গুলো এখানে লিখুন!</span>
                                            <textarea type="text" class="form-control" placeholder="সংযোজিত"></textarea>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 mx-lg-auto designs fz-12">
                                            @php $l_desings = json_decode($item->designs);$count = 1; @endphp
                                            @foreach ($l_desings as $key=> $design)
                                            @php $storeCount=$count++; @endphp
                                            <i class="fa-duotone fa-aperture"></i> <span class="">{{$itemsDesings->find($key)->name}}</span><span>{{$design?'-'.$design:''}}</span>
                                                {{$storeCount=== count(get_object_vars($l_desings))?'':'|'}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
            @endforeach
        </div>
    </div>
</div>
@push('scripts')
    <script data-main="/assets/print/main" src="/assets/print/require.js"></script>
@endpush

