<div class="page-header">
    <h1><?php echo $board_setup_data['name']?> list</h1>
    <p>
        <?php echo $this->tag->linkTo(["dashboard/board/".$board_id."/create/", "추가"]); ?>
    </p>
</div>
<?php $page_num = $page->total_items + ($page->limit * (1-$page->current));?>
<div class="row">

    <table>
        <tr>
            <?php foreach ($page->items as $v => $board) { ?>
            <td >
                <? if (isset($files[$board->idx][0])) { ?>
                    <?php echo $this->tag->linkTo(["dashboard/board/".$board_id."/select/".$board->idx, $this->tag->imageInput(["src" => $this->component->helper->get_thumbnail_images($board_id, $files[$board->idx][0]['artifical_name'])])] );?>
                <? } ?>
            </td>
                <?php if ($v % 4 == 3) { ?> 
                    </tr><tr>
                <?php } ?>
            <?php } ?>
        </tr>
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
                <li><?php echo $this->tag->linkTo("dashboard/board/".$board_id."/" ,"First") ?></li>
                <li><?php echo $this->tag->linkTo("dashboard/board/".$board_id."/".$page->before, "Previous") ?></li>
                <li><?php echo $this->tag->linkTo("dashboard/board/".$board_id."/".$page->next, "Next") ?></li>
                <li><?php echo $this->tag->linkTo("dashboard/board/".$board_id."/".$page->last, "Last") ?></li>
            </ul>
        </nav>
    </div>
</div>