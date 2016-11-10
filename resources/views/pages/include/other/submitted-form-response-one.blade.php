
<?php  $messangeName = (!empty($messangeName)) ? $messangeName : 'status'; ?>


@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif  
@if (session($messangeName))
<div class="alert alert-success">
    {{ session($messangeName) }}
</div>
@endif 
