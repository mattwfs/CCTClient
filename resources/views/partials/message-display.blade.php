@if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
@endif

@if(session()->has('message'))
            <div class="alert alert-success">
                <strong>{{ session('message') }}</strong>
            </div>
@endif

@if(session()->has('success'))
            <div class="alert alert-success">
                <strong>{{ session('message') }}</strong>
            </div>
@endif

@if(session()->has('info'))
            <div class="alert alert-info">
                <strong>{{ session('info') }}</strong>
            </div>
@endif

@if(session()->has('warning'))
            <div class="alert alert-warning">
                <strong>{{ session('warning') }}</strong>
            </div>
@endif

@if(session()->has('error'))
            <div class="alert alert-danger">
                <strong>{{ session('error') }}</strong>
            </div>
@endif