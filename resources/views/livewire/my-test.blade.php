<div>
    @php
        $isPresent='একছাটা';
    @endphp
    {{-- 'apply_on','like', "%{$isPresent}%" --}}
    
        @foreach ($designGroup as $group)
        <div style="border: 1px solid red;display:{{$designsItems->where('type',$group->slug)->count()>0?"":'none'}}">
            <h1>{{$designsItems->where('type',$group->slug)->count()}}</h1>
            @foreach ($designsItems->where('type',$group->slug) as $design)
            <div style="border: 1px solid black">{{$design->name}}</div>
            @endforeach
        </div>
    @endforeach

</div>
