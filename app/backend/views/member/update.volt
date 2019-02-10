
<div class="page-header">
    <h1>
        Update Member
    </h1>
</div>

<form class="form-horizontal" method="post" action="{{ url('dashboard/member/update') }}/{{ id }}">
    <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
    <?php echo $this->tag->hiddenField("id") ?>

    <div class="form-group">
        <label for="fieldID" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            {{ id }}
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
            <input type="text" name="email" id="fieldEmail" class="form-control" placeholder="Email" size="30" value="{{ email }}" >
        </div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">회원 수정</button>

</form>