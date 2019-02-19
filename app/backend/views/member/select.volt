
<div class="page-header">
    <h1>
        View Member
    </h1>
</div>

<form class="form-horizontal" method="get" action="{{ url('dashboard/member/update') }}/{{ id }}">

    <div class="form-group">
        <label for="fieldID" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            {{ id }}
        </div>
    </div>

    <div class="form-group">
        <label for="fieldEmail" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            {{ email }}
        </div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">회원 수정</button>

</form>