<div class="page-header">
    <h1>
        Update
    </h1>
</div>

<form class="form-horizontal" method="post" action="{{ url('dashboard/setup/board/update') }}/{{ idx }}">
    <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
    <input type="hidden" name="idx" value="{{ idx }}">

    <div class="form-group">
        <label for="fieldID" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
           {{ id }}
        </div>
    </div>


    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">NAME</label>
        <div class="col-sm-10">
            <input type="text" name="name" id="fieldNAME" class="form-control" value="{{ name }}" autofocus>
        </div>
    </div>

    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">게시판 스킨</label>
        <div class="col-sm-10">
            <select name="skin" id="fieldSKIN" class="form-control">
                <option value="">스킨을 선택하세요.</option>
                <?php foreach ($_board_skin_list as $k => $v) { ?>
                    <option value="<?php echo $v;?>" <?php if ($skin == $v) { echo "selected"; } ?>  ><?php echo $v;?></option>
                <?php }  ?>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">첨부파일 사용여부</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?php echo ($file == 'Y') ? 'active' : '' ?> ">
                    <input type="radio" name="file" id="file_y" value="Y" <?php echo ($file == 'Y') ? 'checked' : '' ?> > 사용
                </label>
                <label class="btn btn-primary <?php echo ($file == 'N') ? 'active' : '' ?> ">
                    <input type="radio" name="file" id="file_n" value="N" <?php echo ($file == 'N') ? 'checked' : '' ?> > 사용 안함
                </label>
            </div>      
        </div>
    </div>

    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">답글 사용여부</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?php echo ($reply == 'Y') ? 'active' : '' ?> ">
                    <input type="radio" name="reply" id="reply_y" value="Y" <?php echo ($reply == 'Y') ? 'checked' : '' ?> > 사용
                </label>
                <label class="btn btn-primary <?php echo ($reply == 'N') ? 'active' : '' ?> ">
                    <input type="radio" name="reply" id="reply_n" value="N" <?php echo ($reply == 'N') ? 'checked' : '' ?> > 사용 안함
                </label>
            </div>              
        </div>
    </div>

    <div class="form-group">
        <label for="fieldNAME" class="col-sm-2 control-label">댓글 사용여부</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?php echo ($comment == 'Y') ? 'active' : '' ?> ">
                    <input type="radio" name="comment" id="comment_y" value="Y" <?php echo ($comment == 'Y') ? 'checked' : '' ?> > 사용
                </label>
                <label class="btn btn-primary <?php echo ($comment == 'N') ? 'active' : '' ?> ">
                    <input type="radio" name="comment" id="comment_n" value="N" <?php echo ($comment == 'N') ? 'checked' : '' ?> > 사용 안함
                </label>
            </div>
        </div>
    </div>    

    <button class="btn btn-lg btn-primary btn-block" type="submit">글 쓰기</button>

</form>