<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3"><h3 class="card-title">পণ্যসমুহঃ</h3></div>
                <div class="col-md-3"><button class="btn btn-primary">both</button></div>
                <div class="col-md-3"><button class="btn btn-info">পণ্যসমুহঃ</button></div>
                <div class="col-md-3">
                    <div class="card card-danger shadow-lg {{$formShow?'maximized-card':''}}">
                      <div class="card-header">
                        <h3 class="card-title">পণ্য-{{$title}}</h3>
                        <div class="card-tools">
                          <button type="button" id="formControl" class="btn btn-tool" wire:click="formControl" data-card-widget="maximize">পণ্য <i class="fas fa-expand"></i></button>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body {{--$formShow?'':'d-none'--}} add-update-from-show-hide" style="display:{{$formShow?'block':'none'}}">
                        <div class="card card-primary">
                            <div class="card-header">
                              <h3 class="card-title">{{$title}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="product-manage-form" wire:submit.prevent="{{$title ==='হালনাগাদ'?'updateProduct':'addProduct'}}">
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="name">@error('name') <span class="text-danger">{!!$message!!}</span>@else পণ্যের নাম @enderror</label>
                                                <input type="name" class="form-control @error('name')is-invalid @enderror" id="name" placeholder="পণ্যের নাম..." wire:model='name'>
                                            </div>
                                      </div>
                                      <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="slug">@error('slug') <span class="text-danger">{!!$message!!}</span>@else পণ্যের স্ল্যাগঃ @enderror</label>
                                                <input type="text" class="form-control @error('slug')is-invalid @enderror" id="slug" placeholder="পণ্যের-স্ল্যাগ" wire:model="slug">
                                            </div>
                                      </div>
                                      <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="status">@error('status') <span class="text-danger">{!!$message!!}</span>@else পণ্যের স্টেটাসঃ(অবস্থা)@enderror</label>
                                                <select class="form-control @error('status')is-invalid @enderror" id="status" wire:model="status">
                                                  <option value="1">অন</option>
                                                  <option value="0">অফ</option>
                                              </select>
                                            </div>
                                      </div>
                                      <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="type">@error('type') <span class="text-danger">{!!$message!!}</span>@else পণ্যের ধরনঃ@enderror</label>
                                                <select class="form-control @error('type')is-invalid @enderror" id="type" wire:model="type">
                                                    <option value="0">নির্বাচন করুনঃ</option>
                                                    <option value="1">পাঞ্জাবী, জুব্বা জাতিয় পোশাক</option>
                                                    <option value="2">পাযামা, সালয়ার জাতিয় পোশাক</option>
                                                </select>
                                            </div>
                                      </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="wages">@error('wages') <span class="text-danger">{!!$message!!}</span>@else পণ্যের মজুরীঃ@enderror</label>
                                            <input type="text" class="form-control @error('wages')is-invalid @enderror" id="wages" placeholder="পণ্যের স্ল্যাগ..." wire:model="wages">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="option">অতিরিক্ত বিষয়ঃ@error('option') <span class="text-danger">{!!$message!!}</span>@else অতিরিক্ত বিষয়ঃ@enderror</label>
                                            <input type="text" class="form-control @error('option')is-invalid @enderror" id="option" placeholder="পণ্যের স্ল্যাগ..." wire:model="option">
                                        </div>
                                    </div>
                                  </div>
                              </div>
                              <!-- /.card-body -->
              
                              <div class="card-footer">
                                <button type="submit" id="product-add-update-btn" class="btn btn-primary">Submit</button>
                              </div>
                            </form><!-- form End -->
                          </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Slug</th>
              <th>Type</th>
              <th>Status</th>
              <th>Wages</th>
              <th>Option</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
            <tr class="table-row-{{$product->id}}">
              <td>{{$product->id}}</td>
              <td>{{$product->name}}</td>
              <td>{{$product->slug}}</td>
              <td>{{$product->type}}</td>
              <td>{{$product->status}}</td>
              <td>{{$product->wages}}</td>
              <td>{{$product->option}}</td>
              <td>
                <button type="button" wire:click="editProduct({{$product->id}})" class="btn btn-warning"><i class="fa fa-edit"></i></button> |
                <button type="button" wire:click="deleteProduct({{$product->id}})" onclick="confirm('আপনিকি পণ্য ডিলিট করতে চাচ্ছেন?') || event.stopImmediatePropagation()" class="btn text-danger"><i class="fa fa-trash"></i></button>
              </td>
            </tr>
            @endforeach
            </tbody>
            
          </table>
          <div class="card card-body">
            {{$products->links()}}
          </div>
        </div>
        <!-- /.card-body -->
      </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.add-update-from-show-hide').hide();
            window.addEventListener('data_alert', event => {
              document.querySelector(".product-manage-form").reset();
                if (event.detail.data) {
                    $('.add-update-from-show-hide').fadeIn();
                }else{
                  $('.add-update-from-show-hide').fadeOut();
                }
                if (event.detail.success_id) {
                  $(`.table-row-${event.detail.success_id}`).addClass('bg-success');
                  setTimeout(() => {
                    $(`.table-row-${event.detail.success_id}`).removeClass('bg-success');
                  }, 1500);
                }
            });
        });
        window.addEventListener('show_large', event => {
            if (event.detail.data===true) {
              document.querySelector('.shadow-lg').classList.add('maximized-card');
            }else{
              document.querySelector('.shadow-lg').classList.remove("maximized-card");
            }
            
        });
    </script>
@endpush
