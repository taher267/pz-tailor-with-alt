<div>
    <div class="container-fluid">
        @php
            $today =  Carbon\Carbon::now('Asia/Dhaka')->format('Y-m-d');//->format('Y-m-d')
            $searchPrevDays =  Carbon\Carbon::now('Asia/Dhaka')->subDays($prevDay)->format('Y-m-d');
            $searchNextDays =  Carbon\Carbon::now('Asia/Dhaka')->addDays($nextDay)->format('Y-m-d');
            // $compare = $today->eq($orders->delivery_date);
        @endphp
        <div class="row pt-2">
            <div class="col-lg-12"><h3 class=" italic">Order Information</h3></div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$orders->where('order_date', $today)->count()}}</h3>
                        <p>Today Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        @php
                           $completed = $orders->where('status', 'completed')->count(); 
                        @endphp
                        <h3 class="{{!$completed?'text-danger':''}}">{{$completed}}<sup style="font-size: 20px"></sup></h3>
                        <p>Completed Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('orders','completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$customers->count()}}</h3>
                        <p>Customer Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('customers')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$orders->where('status', 'cancled')->count()}}</h3>
                    <p>Cancled Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{route('orders','cancled')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-12"><h3 class="italic">Delivery Information</h3></div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{$orders->whereBetween('delivery_date', [$searchPrevDays,$searchNextDays])->count()}}</h3>
                    <p>Recent Delivery</p>
                    <style>
                        input.prev, input.next{position: relative;}
                        input.prev::before, input.next::before{position: absolute;left: 30%; font-size: 13px;}
                        input.prev::before{transform:rotate(180deg); margin-top:12px; content:"{{$searchPrevDays}}";}
                        input.next::before{margin-top: -16px; content:"{{$searchNextDays}}";}
                    </style>
                    <div class="ml-auto mr-2 date-ranger w-75">
                            <input class="prev w-50" wire:model="prevDay" style="transform: rotate(180deg);" type="range" min="0" max="50" value="0">
                            <input class="next w-50" wire:model="nextDay" type="range" min="0" max="50" value="3" style="margin-left: -7px;"/>
                    </div>
                </div>
                
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#{{route('orders','cancled')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

                
                <div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
