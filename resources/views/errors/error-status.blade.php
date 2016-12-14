 @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
     @if (session('status'))
        <div class="alert alert-danger">
            <ul>
                <li>
                    {{ session('status') }}
                </li>
            </ul>
        </div>
    @endif