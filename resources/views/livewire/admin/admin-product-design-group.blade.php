<div class="container-fluid">
  <style>
    #product-design-group tr th, #product-design-group tr td{
      text-align: center;
    }
    
  </style>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3"><h3 class="card-title">নকশা গুচ্ছসমুহঃ</h3></div>
                <div class="col-md-3"><button class="btn btn-primary">both</button></div>
                <div class="col-md-3"><button class="btn btn-info">নকশা গুচ্ছসমুহঃ</button></div>
                <div class="col-md-3">
                    <div class="card card-danger shadow-lg {{$formShow?'maximized-card':''}}">
                      <div class="card-header">
                        <h3 class="card-title">নকশা গুচ্ছ-{{$title}}</h3>
                        <div class="card-tools">
                          <button type="button" id="formControl" class="btn btn-tool" wire:click="formControl" data-card-widget="maximize">নকশা গুচ্ছ <i class="fas fa-expand"></i></button>
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
                            <form class="product-manage-form" wire:submit.prevent="{{$title ==='হালনাগাদ'?'updateProductDisgnGroup':'addProductDisgnGroup'}}">
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
          <table id="product-design-group" class="table table-bordered table-striped">
            <thead>
            <tr class="text-canter">
              <th>ID</th>
              <th>Name</th>
              <th>Slug</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($designGroups as $group)
                    <tr class="text-canter table-design-row-{{$group->id}}">
                      <td>{{$group->id}}</td>
                      <td>{{$group->name}}</td>
                      <td>{{$group->slug}}</td>
                      <td>
                        <button type="button" wire:click="editProductDisgnGroup({{$group->id}})" class="btn btn-warning"><i class="fa fa-edit"></i></button> |
                        <button type="button" wire:click="deleteProductDesignGroup({{$group->id}})" onclick="confirm('আপনিকি পণ্য নকশা গুচ্ছ ডিলিট করতে চাচ্ছেন?') || event.stopImmediatePropagation()" class="btn text-danger"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                  @endforeach
            </tbody>
            
          </table>
          <div class="card card-body">
            {{$designGroups->links()}}
          </div>
        </div>
        <!-- /.card-body -->
      </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.add-update-from-show-hide').hide();
            window.addEventListener('data_form_design', event => {
              document.querySelector(".product-manage-form").reset();
                if (event.detail.data) {
                    $('.add-update-from-show-hide').fadeIn();
                }else{
                  $('.add-update-from-show-hide').fadeOut();
                }
                if (event.detail.success_id) {
                  $(`.table-design-row-${event.detail.success_id}`).addClass('bg-success');
                  setTimeout(() => {
                    $(`.table-design-row-${event.detail.success_id}`).removeClass('bg-success');
                  }, 1500);
                }
            });
        });
        window.addEventListener('add_update_form_extend', event => {
            if (event.detail.data===true) {
              document.querySelector('.shadow-lg').classList.add('maximized-card');
            }else{
              document.querySelector('.shadow-lg').classList.remove("maximized-card");
            }
            
        });
    </script>
@endpush
