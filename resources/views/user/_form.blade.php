@section('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
     <style type="text/css">
         .hide{
            display: none;
         }
     </style>
@endsection
@csrf
    <br>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"  required autocomplete="name" autofocus value="{{ (old('name'))?old('name'):(isset($user)?$user->name:'') }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" value="{{ (old('email'))?old('email'):(isset($user)?$user->email:'') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"  autocomplete="new-password" >
        </div>
    </div>

    @php
        if(old() && old('roles')){
            $old_roles = old('roles');
        }elseif (isset($user)) {
            $old_roles = $user->roles()->pluck('roles.id')->toArray();
        }else{
            $old_roles = [];
        }
        $hideRole = 'hide';
        
        if(Auth::check() && Auth::user()->isRole('admin')){
            $hideRole = '';
        }

    @endphp

    <div class="form-group row {{ $hideRole }}">
        <label for="roles[]" class="col-md-4 col-form-label text-md-right">{{ __('Select Role') }}</label>

        <div class="col-md-6">
            <select name="roles[]" multiple="multiple"  id="roles" class="form-control @error('roles') is-invalid @enderror">
                @foreach($roles as $role)
                    <option {{ (in_array($role->id, $old_roles))? 'selected':'' }} value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="phone-number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

        <div class="col-md-6">
            <input id="phone-number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" required autocomplete="number" value="{{ (old('phone_number'))?old('phone_number'):(isset($user)?$user->phone_number:'') }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

        <div class="col-md-6">
            <textarea id="address" autocomplete="address" class="form-control @error('address') is-invalid @enderror" name="address" required="">{{ (old('address'))?old('address'):(isset($user)?$user->address:'') }}</textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="zip-code" class="col-md-4 col-form-label text-md-right">{{ __('Zip Code') }}</label>

        <div class="col-md-6">
            <input id="zip-code" type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" required autocomplete="off" value="{{ (old('zip_code'))?old('zip_code'):(isset($user)?$user->zip_code:'') }}">
        </div>
    </div>

    <div class="form-group row avatar-div">
        <label for="zip-code" class="col-md-4 col-form-label text-md-right">{{ __('Profile Picture') }}</label>

        <div class="col-md-6">
            <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" >
        </div>
    </div>

    @section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            displayAvatarDiv();
            $('#roles').multiselect({
                includeSelectAllOption: true,

            });

            $('body').on('change', '#roles', function () {
                displayAvatarDiv();
            });

            function displayAvatarDiv(){
                var roles = $('#roles').val();
                var admin_role_id = '{{ $admin_role->id }}';
                if(roles){
                    if(roles.includes(admin_role_id)){
                        $('.avatar-div').removeClass('hide');
                    
                    }else{
                        $('.avatar-div').addClass('hide');

                    }
                }else{
                    $('.avatar-div').addClass('hide');
                }
            }
        });
    </script>
    @endsection
