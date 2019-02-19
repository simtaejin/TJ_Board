
<div class="page-header">
    <h1>
        Create Member
    </h1>
</div>

<form class="form-horizontal" method="post" action="{{ url('dashboard/member/create') }}">
    <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">

    <div class="form-group">
        <label for="fieldID" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" id="fieldID" class="form-control" placeholder="ID" size="30" autofocus>
        </div>
    </div>

    <div class="form-group">
        <label for="fieldPassword" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" name="password" id="fieldPassword" class="form-control" placeholder="Password" size="30">
        </div>
    </div>

    <div class="form-group">
        <label for="fieldEmail" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="text" name="email" id="fieldEmail" class="form-control" placeholder="Email" size="30">
        </div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">회원 가입</button>

</form>