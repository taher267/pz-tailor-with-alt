<div>
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
                    <div class="card card-body px-0">
                    </div>
                  </div>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
                <h2 class="m-0 text-right border-bottom py-2 italic">অর্ডার </h2>
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-users"></i>###</a></li>
                <li class="breadcrumb-item active">নতুন অর্ডার </li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card">
        <div class="col-md-6">
            <select wire:model="order_status" class="custom-select d-block w-100" id="order_status" required>
                <option value="all" class="text-capitalize">সকল</option>
                @foreach ($statuses as $key=> $status)
                    <option value="{{$key}}" class="text-capitalize">{{$status}}</option>
                @endforeach
                <option value="unaccomplished" class="text-capitalize">অসম্পূর্ণ</option>
            </select>
        </div>
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-handshake"></i> সকল অর্ডারসমূহ</h3>
            <div class="card-tools">
                @if (isset($specificorders) && $specificorders->count()>0)
                {!!$specificorders->links()!!}
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
                @forelse ($specificorders as $key=> $order)
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
                        <td>{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</td>
                        <td>
                            <div class="form-group">
                                {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
                                <select class="form-control" wire:model="change_order_status.{{$order->id}}" wire:change='changeOrderStatus({{$order->id}})' id="exampleFormControlSelect1">
                                    <option value="{{$order->status}}" class="text-capitalize">{{$statuses[$order->status]}}</option>
                                    @foreach ($statuses as $k=> $status)
                                        @if($k!==$order->status)
                                            <option value="{{$k}}" class="text-capitalize">{{$status}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td> 
                            <a class="btn btn-success btn-sm" href="{{route('order.new.additem',[$order->id])}}"><i class="fa fa-plus"></i> <i class="fa fa-cart-plus"></i> নতুন আইটেম</a>
                            {{-- <a href="{{route('customers.edit',$order->id)}}"><i class="fa fa-edit"></i></a> --}}
                        </td>
                    </tr>
                    @empty
                <tr><td colspan="5" class="text-center">কোনো অর্ডার পাওয়া যায়নি</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
        </div>
</div>
@push('scripts')
    <script>
        history.pushState({}, 'All JavaScript Tutorials', '{{Request::url()}}');
    </script>
    
@endpush
