<div class="page-header">
    <h1>
        Create
    </h1>
</div>

<form class="form-horizontal" method="post" action="{{ url('/dashboard/setup/board/create') }}">
    <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">

    <div class="form-group">
        <label for="fieldID" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" id="fieldID" class="form-control"  autofocus>
        </div>
    </div>


    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">NAME</label>
        <div class="col-sm-10">
            <input type="text" name="name" id="fieldNAME" class="form-control"  autofocus>
        </div>
    </div>

    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">게시판 스킨</label>
        <div class="col-sm-10">
            <select name="skin" id="fieldSKIN" class="form-control">
                <option value="">스킨을 선택하세요.</option>
                <?php foreach ($_board_skin_list as $k => $v) { ?>
                <option value="<?php echo $v;?>"><?php echo $v;?></option>
                <?php }  ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">첨부파일 사용여부</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary">
                    <input type="radio" name="file" id="file_y" value="Y"> 사용
                </label>
                <label class="btn btn-primary ">
                    <input type="radio" name="file" id="file_n" value="N"> 사용 안함
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">답글 사용여부</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary">
                    <input type="radio" name="reply" id="reply_y" value="Y"> 사용
                </label>
                <label class="btn btn-primary">
                    <input type="radio" name="reply" id="reply_n" value="N"> 사용 안함
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">댓글 사용여부</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary">
                    <input type="radio" name="comment" id="comment_y" value="Y"> 사용
                </label>
                <label class="btn btn-primary">
                    <input type="radio" name="comment" id="comment_n" value="N"> 사용 안함
                </label>
            </div>
        </div>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">글 쓰기</button>

</form>