<div class="page-header">
    <h1> list</h1>
    <p>
        <?php echo $this->tag->linkTo(["dashboard/setup/board/create", "추가"]); ?>
    </p>
</div>
<?php $page_num = $page->total_items + ($page->limit * (1-$page->current));?>
<div class="row">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Id</th>
            <th>Name</th>
            <th>Created</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($page->items as $v => $sb_data) { ?>
        <tr>
            <td><?php echo $page_num - $v?></td>
            <td><?php echo $sb_data->id ?></td>
            <td><?php echo $sb_data->name ?></td>
            <td><?php echo $sb_data->created ?></td>
            <td><?php echo $this->tag->linkTo(["dashboard/setup/board/update/".$sb_data->idx, "수정"]); ?></td>
            <td><?php echo $this->tag->linkTo(["dashboard/setup/board/delete/". $sb_data->idx, "삭제"]); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-1">
        <p class="pagination" style="line-height: 1.42857;padding: 6px 12px;">
            <?php echo $page->current, "/", $page->total_pages ?>
        </p>
    </div>

    <div class="col-sm-11">
        <nav>
            <ul class="pagination">
                <li><?php echo $this->tag->linkTo("dashboard/setup/board/" ,"First") ?></li>
                <li><?php echo $this->tag->linkTo("dashboard/setup/board/page/".$page->before, "Previous") ?></li>
                <li><?php echo $this->tag->linkTo("dashboard/setup/board/page/".$page->next, "Next") ?></li>
                <li><?php echo $this->tag->linkTo("dashboard/setup/board/page/".$page->last, "Last") ?></li>
            </ul>
        </nav>
    </div>

</div>