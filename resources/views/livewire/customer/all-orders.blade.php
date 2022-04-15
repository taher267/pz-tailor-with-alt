<div>
    <style>
        p.text-sm.text-gray-700.leading-5 {
    display: none;
}
    </style>
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
                <th>Last Order</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @if (isset($orders) && $orders->count()>0)
                    @foreach ($orders->where('created_at', '>=', Carbon\Carbon::today()) as $key=> $order)
                        <tr class="{{Carbon\Carbon::now()->format('Y-m-d')===$order->order_date?'pz-bg':''}}">
                            {{$order}}
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
{{-- {{print_r($itemSummary)}} --}}
                                
                            </td>
                            <td>{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</td>
                            <td>{{ucfirst($order->status)}}</td>
                            <td> 
                                <a class="btn btn-primary btn-sm" href="{{route('order.new.additem',[$order->order_number, $order->id])}}"><i class="fa fa-plus"></i> <i class="fa fa-cart-plus"></i> New Item</a>|
                                {{-- <a href="{{route('customers.edit',$order->id)}}"><i class="fa fa-edit"></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        </div>
        </div>
</div>
