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
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @if ($allCustomers->count()>0)
                    @foreach ($allCustomers as $key=> $customer)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->mobile}}</td>
                            <td>Last order</td>
                            <td>
                                <a href="{{route('customers.edit',$customer->id)}}"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        </div>
        
        </div>
</div>
