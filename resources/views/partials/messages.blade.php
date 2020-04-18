<div class="container">
    @if (session()->has('success'))
    <div class="alert alert-success">
    	  {!! session()->get('success') !!}						
    </div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger">
    	  {!! session()->get('error') !!}						
    </div>
    @endif
    @if(isset($errors)&&count($errors) > 0)
       <div class="alert alert-danger">
            @if(count($errors) == 1)
                {!! $errors->first() !!}
            @else
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            @endif

        </div>
    @endif
</div>