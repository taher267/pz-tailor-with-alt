<div>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">New Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('customers')}}">Customers</a></li>
            <li class="breadcrumb-item active">New Customer</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container">
      <form class="form-horizontal" wire:submit.prevent='addCustomer'>
      <div class="row">
        <div class="col-md-10 pl-3">
              <div class="form-group row">
                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="নাম" required>
                  @error('name')<div class="invalid-feedback">{!!'নাম'.$message!!}</div>@enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="mobilePhone" class="col-sm-2 col-form-label">Mobile No</label>
                <div class="col-sm-10">
                  <input type="text" wire:model.debounce.500ms="mobile" class="form-control @error('mobile')is-invalid @enderror" id="mobilePhone" placeholder="019xxxxxxx" required>
                  @error('mobile')<div class="invalid-feedback">{!!'মোবাইল নম্বর'.$message!!}</div>@enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <input type="email"  wire:model.debounce.500ms="email" class="form-control @error('email')is-invalid @enderror" id="inputEmail" placeholder="Email">
                  @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                  <textarea class="form-control @error('address')is-invalid @enderror" wire:model="address" id="address" placeholder="Address"></textarea>
                  @error('address')<div class="invalid-feedback">{{$message}}</div>@enderror
                </div>
              </div>
              
        </div>
        <div class="col-md-2 col-xs-10 offset-xs-2">
          <div class="text-center">
              @if ($photo)
                <img style="max-width: 100%" src="{{$photo->temporaryUrl()}}">
              @else
                <img style="max-width: 100%"src="{{config('app.url').'/assets/alt/dist/img/default-150x150.png'}}">
              @endif
          </div>
          <div class="form-group row">
              <div class="custom-file mt-3">
                <input type="file" class="custom-file-input @error('photo')is-invalid @enderror" wire:model="photo" id="customerphoto" accept="image/*" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="customerphoto"><i class="fa fa-camera-retro" aria-hidden="true"></i> Choose</label>
                @error('photo')<div class="invalid-feedback">{{$message}}</div>@enderror
              </div>
          </div>
        </div>
        <div class="col-md-10 offeset-md-2">
        <div class="form-group row">
          <div class="col-sm-12 text-right">
            <button type="submit" class="btn btn-danger"><i class="fa fa-user-plus"></i> Submit</button>
          </div>
        </div>
      </div>
      </div>
    </form>
    </div>
  </div>
</div>
@push('scripts')
  <script>
    $(document).ready(function(){$('.custom-file-input').change(function () {$('.custom-file-input').next().text(this.files[0].name);});});
  </script>
@endpush