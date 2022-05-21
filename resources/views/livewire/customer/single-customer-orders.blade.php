<div class="container-fluid">
    <style>
        p.text-sm.text-gray-700.leading-5 {
    display: none;
}
    </style>
    <div class="row">
        <div class="col-sm-8">
          <div class="row">
              <div class="col-sm-6">
                <div class="card card-body">
                    <div class="row"><div class="col-sm-6 text-primary">অর্ডার নম্বরঃ</div><div class="col-sm-6">{{$order_number}}</div></div>
                    <div class="row"><div class="col-sm-6 text-primary">মোবাইল </div><div class="col-sm-6">{{$mobile}}</div></div>
                    <div class="row"><div class="col-sm-6 text-primary">গত ডেলিভেরীঃ</div><div class="col-sm-6">@if($orders && $orders->count()>0){{$orders->first()->delivered_date}} @endif</div></div>
                    
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card card-body px-0">
                    <div class="row"><div class="col-sm-6 text-right text-primary">নামঃ </div><div class="col-sm-6">{{$name}}</div></div>
                    <div class="row"><div class="col-sm-6 text-right text-primary">মোবাইল নম্বরঃ</div><div class="col-sm-6">{{$mobile}}</div></div>
                    <div class="row"><div class="col-sm-6 text-right text-primary">ডেলিভেরীঃ</div><div class="col-sm-6"></div></div>
                    
                </div>
              </div>
          </div>
        </div><!-- /.col -->
        <div class="col-sm-4">
            <h2 class="m-0 text-right border-bottom py-2 italic">{{$name}} এর অর্ডার</h2>
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="http://localhost:8000/manage/customers"><i class="fa fa-users"></i>
                 গ্রাহকসমূহঃ </a></li>
            <li class="breadcrumb-item active">নতুন অর্ডার </li>
          </ol>
        </div><!-- /.col -->
      </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-handshake"></i> সকল অর্ডারসমূহ</h3>
            <div class="card-tools">
                @if (isset($orders) && $orders->count()>0)
                {!!$orders->links()!!}
                @endif
            </div>
        </div>
        
        <div class="card-body p-0">
        <table class="table">
            <thead>
            <tr>
                <th style="width: 10px">Order</th>
                <th><i class="fa-solid fa-truck"></i></th>
                <th>Details</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @if (isset($orders) && $orders->count()>0)
                    @foreach ($orders as $key=> $order)
                    {{-- @foreach ($orders->where('created_at', '>=', Carbon\Carbon::today()) as $key=> $order) --}}
                    
                        <tr class="{{Carbon\Carbon::now()->format('Y-m-d')===$order->order_date?'pz-bg':''}}">
                            <td>{{$order->order_number}}</td>
                            <td>{{$order->delivery_date}}</td>
                            <td>
                                <!--details-->
                                @php
                                    $order_summary = json_decode($order->order_summary, JSON_UNESCAPED_UNICODE);
                                    $upper=$order_summary['upper'];
                                    $lower=$order_summary['lower'];
                                    $itemSummary = $order->orderItems;
                                @endphp
                                <p class="d-inline-block upper-products">
                                    @foreach ($itemSummary->where('type', 'upper') as $iSummary)
                                        <span>{{json_decode($iSummary->item_summary, JSON_UNESCAPED_UNICODE)['products']}},</span>
                                    @endforeach
                                </p>
                                {{$upper}}টি |
                                    <p class="d-inline-block lower-products">
                                        @foreach ($itemSummary->where('type', 'lower') as $iSummary)
                                            <span>{{json_decode($iSummary->item_summary, JSON_UNESCAPED_UNICODE)['products']}} |</span>
                                        @endforeach
                                    </p>
                                {{$lower}}টি |
                                মোটঃ {{$upper+$lower}}টি, <span>মোট মজুরীঃ {{json_decode($order->wageses)->subtotal}}</span>
                                
                            </td>
                            <td class="text-warning">{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</td>
                            @php
                                $today =  Carbon\Carbon::now(new \DateTimeZone('Asia/Dhaka'));
                                $compare = $today->lt($order->delivery_date);
                                // dd($compare);
                            @endphp
                            <td class="@if($compare && $order->status=='completed')text-warning @else text-danger @endif">{{ucfirst($order->status)}}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{route('order.new.additem',$order->id)}}"><i class="fa fa-plus"></i> <i class="fa fa-cart-plus"></i> New Item</a>|
                                <a href="{{route('customer.order.items',[$order->order_number, $order->id])}}"><i class="fa fa-eye"></i></a>
                                {{-- <a class="btn btn-success btn-sm" href="{{route('order.new.additem',[$order->order_number, $order->id])}}"><i class="fa fa-plus"></i> <i class="fa fa-cart-plus"></i> New Item</a>|
                                <a href="{{route('customer.order.items',[$order->order_number, $order->id])}}"><i class="fa fa-eye"></i></a> --}}
                            </td>
                        </tr>
                   
                    @endforeach
                @endif
            </tbody>
        </table>
        </div>
        </div>
</div>
