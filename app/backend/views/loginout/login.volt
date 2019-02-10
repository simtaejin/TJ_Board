

{{ this.assets.outputCss('extra') }}


<div class="container">

    <form class="form-signin" method="post" action="{{ url('dashboard/loginout/dologin') }}">
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">

        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputId" class="sr-only">Email address</label>
        <input type="text" id="inputId" name="inputId" class="form-control" placeholder="ID"  autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" >
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div>