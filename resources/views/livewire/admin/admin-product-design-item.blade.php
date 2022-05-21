@push('styles')

@endpush
<div class="container-fluid">
    
    <link rel="stylesheet" href="/assets/alt/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/alt/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                            <form class="product-manage-form" wire:submit.prevent="{{$title ==='হালনাগাদ'?'updateProductDesignItem':'addProductDesignItem'}}">
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
                                                <label for="type">@error('type') <span class="text-danger">{!!$message!!}</span>@else পণ্যের ধরনঃ@enderror</label>
                                                <select class="form-control @error('type')is-invalid @enderror" id="type" wire:model="type">
                                                    <option value="0">নির্বাচন করুনঃ</option>
                                                    @foreach ($designGroups as $group)
                                                    <option value="{{$group->slug}}">{{$group->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                      <div class="col-md-6 col-xs-12">
                                          <div class="">
                                              <label for="type">@error('apply_on') <span class="text-danger">{!!$message!!}</span>@else পণ্যের ধরনঃ@enderror</label>
                                          </div>
                                          <div class="form-group" wire:ignore>
                                            {{-- <label for="type">পণ্যের ধরনঃ</label> --}}
                                            <select class="form-control" multiple="multiple" data-placeholder="Select a State" wire:model="apply_on" id="apply_on">
                                                    @foreach ($products as $product)
                                                        <option value="{{$product->slug}}">{{$product->name}}</option>
                                                    @endforeach
                                            </select>
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
                                            <span>@error('image') <span class="text-danger">{!!$message!!}</span>@else পণ্যের ছবিঃ@enderror</span>
                                            <div class="custom-file mt-3">
                                                <input type="file" class="custom-file-input " wire:model="image" id="image" accept="image/*">
                                                <label class="custom-file-label" for="photo"><i class="fa fa-camera-retro" aria-hidden="true"></i> Choose</label>
                                            </div>
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
              <th>Type</th>
              <th>Apply On</th>
              <th>Status</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($designItems as $design)
            <tr class="table-design-item-row-{{$design->id}}">
              <td>{{$design->id}}</td>
              <td>{{$design->name}}</td>
              <td>{{$design->type}}</td>
              <td>
                  @php
                      $apply = json_decode($design->apply_on);
                      $c=0;
                  @endphp
                  @foreach ($apply as $key=> $item)

                  <?php $c++; ?>
                      <span>{!!$key!!} <span class="text-warning">{!!$c===count(get_object_vars($apply))?"":"|"!!}</span> </span>
                  @endforeach
              </td>
              <td>{{$design->status}}</td>
              <td>{{$design->image}}</td>
              <td>
                <button type="button" wire:click="editProductDesignItem({{$design->id}})" class="btn btn-warning"><i class="fa fa-edit"></i></button> |
                <button type="button" wire:click="deleteProductDesignItem({{$design->id}})" onclick="confirm('আপনিকি পণ্যের নকশা ডিলিট করতে চাচ্ছেন?') || event.stopImmediatePropagation()" class="btn text-danger"><i class="fa fa-trash"></i></button>
              </td>
            </tr>
            @endforeach
            </tbody>
            
          </table>
          <div class="card card-body">
            {{$designItems->links()}}
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      
</div>
@push('scripts')
<script src="/assets/alt/plugins/select2/js/select2.full.js"></script>
    <script>
        $(document).ready(function(){
          const UlLi = `<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="Select a State" style="width: 0px;"></li>`;

            $('.add-update-from-show-hide').hide();
            window.addEventListener('data_alert', event => {
              removeDangerBorder();//remove, select2 input box error border
              setTimeout(() => {
                if ($('.select2-selection__rendered')[0]) {
                  $('.select2-selection__rendered').html(UlLi)
                }
              }, 0);
              document.querySelector(".product-manage-form").reset();
                if (event.detail.data) {
                    $('.add-update-from-show-hide').fadeIn();
                }else{
                  $('.add-update-from-show-hide').fadeOut();
                }
                if (event.detail.success_id) {
                  $(`.table-design-item-row-${event.detail.success_id}`).addClass('bg-success');
                  setTimeout(() => {
                    $(`.table-design-item-row-${event.detail.success_id}`).removeClass('bg-success');
                  }, 1500);
                }
            });
            //Select2 start
            //Initialize Select2 Elements
            $('#apply_on').select2().on('change',function () {
                @this.set('apply_on', $(this).val());
                errorHandler();
            })

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
            //Select2 End

        });
        function errorHandler() {
            setTimeout(() => {
              const li = $('.select2-selection__choice');
              if (!li.length) {
                addDangerBorder();
              }else{
                removeDangerBorder();
              }
            }, 0);
            
          }
        window.addEventListener('extending_form', event => {
            if (event.detail.data===true) {
              document.querySelector('.shadow-lg').classList.add('maximized-card');
            }else{
              document.querySelector('.shadow-lg').classList.remove("maximized-card");
            }
            
        });
        //Select2 error handler helper
        const addDangerBorder = ()=>$('.select2-selection.select2-selection--multiple').addClass('border-danger');
        const removeDangerBorder = ()=>$('.select2-selection.select2-selection--multiple').removeClass('border-danger');


        window.addEventListener('apply_on_data', event => {
            if (event.detail.status===true) {
              $('#apply_on').select2();
            }
            if (event.detail.apply_on===true) {
              errorHandler();
            }
            
        });

    </script>
@endpush
