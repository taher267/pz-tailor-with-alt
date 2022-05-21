<div>
    <style>
        p.text-sm.text-gray-700.leading-5 {
    display: none;
}
    </style>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Customers</h3>
            <div class="card-tools">
                @if ($allCustomers->count()>0)
                {!!$allCustomers->links()!!}
                @endif
            </div>
        </div>
        
        <div class="card-body p-0">
        <table class="table">
            <thead>
            <tr>
                <th style="width: 10px">ID</th>
                <th><i class="fa fa-user"></i></th>
                <th><i class="fa fa-mobile"></i></th>
                <th>Last Order</th>
                <th><i class="fa fa-plus"></i></th>
                <th><i class="fa fa-eye"></i></th>
                <th><i class="fa fa-edit"></i></th>
                <th><i class="fa fa-trash"></i></th>
            </tr>
            </thead>
            <tbody>
                @if ($allCustomers->count()>0)
                    @foreach ($allCustomers as $key=> $customer)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                @if ($customer->photo && $customer->photo)
                                    <img width="35" class="d-inline-block border border-warning rounded-circle" src="{{"/storage/customers/$customer->photo"}}" alt="{{$customer->name}}"/>
                                @endif
                                {{$customer->name}}({{$customer->order_number}})</td>
                            <td>{{$customer->mobile}}</td>
                            <td>Last order</td>
                            <td>
                                @if (!$customer->orders->count())
                                <a class="btn btn-primary btn-sm" href="{{route('order.new',$customer->order_number)}}"><i class="fa fa-plus"></i> <i class="fa fa-cart-plus"></i></a>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('customers.orders',$customer->order_number)}}"><i class="fa fa-eye"></i></a>
                            </td>
                            <td><a href="{{route('customers.edit',$customer->id)}}"><i class="fa fa-edit text-warning"></i></a></td>
                            <td>
                                @if($customer->orders->count()===0)<a href="#" wire:click="deleteCustomer({{$customer->id}})" onclick="return confirm('আপনি কি গ্রাহককে বিলুপ্ত করতে চান?') || event.stopImmediatePropagation()"><i class="fa fa-trash text-danger"></i></a>@endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        </div>
        </div>
        {{-- {{$customer->orders->count()>0 ? var_dump(json_decode($customer->orders[0]->wages)):null}} --}}
</div>
