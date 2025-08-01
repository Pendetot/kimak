<!-- [ Nav ] start -->
<nav class="navbar navbar-expand-md navbar-light default">
    <div class="container">
        <a class="navbar-brand " href="{{ url('index') }}">
            <img src="{{ $website_logo->value ? asset('storage/' . $website_logo->value) : URL::asset('build/images/logo-dark.svg') }}" alt="logo" class="logo-lg landing-logo" />
        </a>
        
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          
            
        </div>
    </div>
</nav>
<!-- [ Nav ] start -->
