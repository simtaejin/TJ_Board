<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class BoardController extends ControllerBase
{
    public $board_setup_data;
    public $board_id;
    public function initialize()
    {
        parent::initialize();
        
        $this->view->setVar("userId", $this->session->get("id"));
        $board_id = $this->dispatcher->getParam('board_id');
        $board_setup = new \Multiple\Backend\Models\SetupBoard();        
        $board_setup->setSource("board");
        $board_setup_data = $board_setup->findFirstById($board_id);
        if ($board_setup_data) {
            try {
                $board = new \Multiple\Backend\Models\Board();
            } catch (Exception   $e) {
            }
            $this->board_id = $board_setup_data->id;
            $this->board_setup_data = get_object_vars($board_setup_data);
            $this->view->setVar('board_setup_data', $this->board_setup_data);
        } else {
            $this->component->ComponentsPlugin->alert("board_id 값을 확인 해주세요.", "/dashboard/");
        }
    }
    /**
     * 게시판 리스트
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        if (!$this->dispatcher->getParam('page')) {
            $numberPage = 1;
        } else {
            $numberPage = $this->dispatcher->getParam('page');
        }
        $parameters["order"] = "ref_group desc, ref_order asc";
        $board = new \Multiple\Backend\Models\Board();
        $board->setSource($board_id);
        $board_data = $board->finds($parameters);
        $paginator = new Paginator([
            'data' => $board_data,
            'limit' => 10,
            'page' => $numberPage
        ]);
        $this->view->setVar('board_id', $board_id);
        $this->view->setVar('page', $paginator->getPaginate());
        $this->view->setVar('files', $board_data->files);
        $this->view->setVar('comments', $board_data->comments);
        $this->view->pick('board/'.$this->board_setup_data['skin'].'/'.$this->router->getActionName());
    }
    /**
     * 게시판 글쓰기
     */
    public function createAction()
    {
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        if ($this->request->isPost()) {
            $this->view->disable();
            $this->component->ComponentsPlugin->csrf("/dashboard/board/".$board_id."/create/");
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $board->title = $this->request->getPost("title");
            $board->content = $this->request->getPost("content");
            $board->member = $this->session->get("id");
            if (!$board->create()) {
                foreach ($board->getMessages() as $message) {
                    if ($message == "title is required") {
                    }
                    if ($message == "content is required") {
                    }
                }
                return;
            } else {
                $temp = new \Multiple\Backend\Models\Board();
                $temp->setSource($board_id);
                $temp_data = $temp->findFirstByIdx($board->idx);
                $temp_data->ref_group = $board->idx;
                $temp_data->update();
                if ($this->request->hasFiles()) {
                    foreach ($this->request->getUploadedFiles() as $k => $v) {
                        $files = new \Multiple\Backend\Models\Files();
                        $files->setSource("file_boards");
                        $files->board_id = $board->getSource();
                        $files->board_idx = $board->idx;
                        $files->file_type = $v->getType();
                        $files->file_size = $v->getSize();
                        $files->origina_name = $v->getName();
                        $files->artifical_name = Phalcon\Text::random(Phalcon\Text::RANDOM_ALNUM) . "." . $v->getExtension();
                        $files->create();
                        $v->moveTo($this->config->application->dataDir . "/board/" . $board_id . "/" . $files->artifical_name);
                        if ($k == 0 && ($v->getType() == "image/jpeg" || $v->getType() == "image/png" || $v->getType() == "image/gif") ) {
                            $this->component->ComponentsPlugin->set_thumbnail_images($board_id, $files->artifical_name, "140", "140");
                        }
                    }
                }
            }
            $this->component->ComponentsPlugin->alert("글 등록 되었습니다.", "/dashboard/board/" . $board_id . "/");
        }
        $this->view->setVar('board_id', $board_id);
        $this->view->pick('board/skin/'.$this->router->getActionName());
    }
    /**
     * 게시판 글뷰
     */
    public function selectAction()
    {              
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        $board_idx = $this->dispatcher->getParam('idx');
        $board = new \Multiple\Backend\Models\Board();
        $board->setSource($board_id);
        //$board_data = $board->findFirstByIdx($board_idx);
        $board_data = $board->finds([
            "idx = :idx: ",
            "bind" => ["idx" => $board_idx]
        ]);
        $sess = "sess_" . $board_id . "_" . $board_idx;
        if (!$this->session->has($sess)) {
            $this->session->set($sess, $sess);
            $result = $this->db->execute(
                "update `board_" . $board_id . "` set  `hits` = `hits` + 1 where `idx` = ? ",
                [$board_idx]
            );
        }
        $this->view->setVar("board_id", $board_id);
        $this->view->setVar("board_idx", $board_idx);
        $this->view->setVar("title", $board_data[0]->title);
        $this->view->setVar("content", $board_data[0]->content);
        $this->view->setVar("files", $board_data->files);
        $this->view->setVar("comments", $board_data->comments);
        $this->view->pick('board/'.$this->board_setup_data['skin'].'/'.$this->router->getActionName());
    }
    /**
     * 게시판 글수정
     */
    public function updateAction()
    {
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        $board_idx = $this->dispatcher->getParam('idx');
        if ($this->request->isPost()) {
            $this->view->disable();
            $this->component->ComponentsPlugin->csrf("/dashboard/board/".$board_id."/update/". $board_idx);
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $board_data = $board->findFirstByIdx($board_idx);
            $board_data->title = $this->request->getPost("title");
            $board_data->content = $this->request->getPost("content");
            if (!$board_data->update()) {
                foreach ($board_data->getMessages() as $message) {
                    echo $message . "<br>";
                }
                return;
            }
            $this->component->ComponentsPlugin->alert("글 수정 되었습니다.", "/dashboard/board/" . $board_id . "/select/". $board_idx);
        } else {
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $board_data = $board->findFirstByIdx($board_idx);
            $this->view->setVar("board_id", $board_id);
            $this->view->setVar("board_idx", $board_idx);
            $this->view->setVar("title", $board_data->title);
            $this->view->setVar("content", $board_data->content);
        }
        $this->view->pick('board/'.$this->board_setup_data['skin'].'/'.$this->router->getActionName());
    }
    /**
     * 게시판 글삭제
     */
    public function deleteAction()
    {
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        $board_idx = $this->dispatcher->getParam('idx');
        $board = new \Multiple\Backend\Models\Board();
        $board->setSource($board_id);
        $board_data = $board->findFirstByIdx($board_idx);
        if (!$board_data->delete()) {
            foreach ($board->getMessages() as $message) {
                echo $message . "<br>";
            }
            return;
        }
        $this->component->ComponentsPlugin->alert("글 삭제 되었습니다.", "/dashboard/board/" . $board_id . "/");
        $this->view->pick('board/'.$this->board_setup_data['skin'].'/'.$this->router->getActionName());
    }
    /**
     * 리플 글쓰기
     */
    public function replycreateAction()
    {
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        $board_idx = $this->dispatcher->getParam('idx');
        $this->view->setVar('board_id', $board_id);
        if ($this->request->isPost()) {
            $this->view->disable();
            $ref_group = $this->request->getPost("ref_group");
            $ref_level = $this->request->getPost("ref_level");
            $ref_order = $this->request->getPost("ref_order");
            //$this->component->helper->csrf("board/replycreate");
            $this->component->ComponentsPlugin->csrf("/dashboard/board/" . $board_id . "/select/". $board_idx);
            $result = $this->db->execute(
                "update `board_" . $board_id . "` set  `ref_order` = `ref_order` + 1 where `ref_group` = ? and `ref_order` > ?",
                [$ref_group, $ref_order]
            );
            $ref_level = $ref_level + 1;
            $ref_order = $ref_order + 1;
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $board->ref_group = $ref_group;
            $board->ref_level = $ref_level;
            $board->ref_order = $ref_order;
            $board->title = $this->request->getPost("title");
            $board->content = $this->request->getPost("content");
            $board->member = $this->session->get("id");
            if (!$board->create()) {
                foreach ($board->getMessages() as $message) {
                    echo $message . "<br>";
                }
                return;
            }
            $this->component->ComponentsPlugin->alert("글 등록 되었습니다.","/dashboard/board/" . $board_id . "/select/". $board_idx);
        } else {
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $board_data = $board->findFirstByIdx($board_idx);
            $this->view->setVar("board_id", $board_id);
            $this->view->setVar("board_idx", $board_idx);
            $this->view->setVar("ref_group", $board_data->ref_group);
            $this->view->setVar("ref_level", $board_data->ref_level);
            $this->view->setVar("ref_order", $board_data->ref_order);
            $this->view->setVar("title", $board_data->title);
            $this->view->setVar("content", $board_data->content);
        }
        $this->view->pick('board/'.$this->board_setup_data['skin'].'/'.$this->router->getActionName());
    }
    /**
     * 댓글 글쓰기
     */
    public function commnetcreateAction()
    {
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        $board_idx = $this->dispatcher->getParam('idx');
        if ($this->request->isAjax()) {
            $this->view->disable();
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $comments = new \Multiple\Backend\Models\Comments();
            $comments->setSource("comment_boards");
            $comments->board_id = $board->getSource();
            $comments->board_idx = $board_idx;
            $comments->memo = $this->request->getPost("memo");
            $comments->member = $this->session->get("id");
            if ($comments->create()) {
                $comment_data = \Multiple\Backend\Models\Comments::find(
                    [
                        "board_id = :board_id: AND board_idx = :board_idx:",
                        "bind" => ["board_id" => $board->getSource(), "board_idx" => $board_idx]
                    ]
                );
                $result['code'] = "00";
                $result['msg'] = "등록 되었습니다.";
                $result['value'] = $this->commend_list($comment_data);
                echo json_encode($result);
            }
            exit;
        }
    }
    /**
     * 댓글 글수정
     */
    public function commnetupdateAction()
    {
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        $board_idx = $this->dispatcher->getParam('idx');
        if ($this->request->isAjax()) {
            $this->view->disable();
            $select_comment_idx = $this->request->getPost("select_comment_idx");
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $comments = new \Multiple\Backend\Models\Comments();
            $comments->setSource("comment_boards");
            $comments_date = $comments->findFirstByIdx($select_comment_idx);
            $comments_date->memo = $this->request->getPost("memo");
            if ($comments_date->update()) {
                $comment_data = \Multiple\Backend\Models\Comments::find(
                    [
                        "board_id = :board_id: AND board_idx = :board_idx:",
                        "bind" => ["board_id" => $board->getSource(), "board_idx" => $board_idx]
                    ]
                );  
                $result['code'] = "00";
                $result['msg'] = "수정 되었습니다.";             
                $result['value'] = $this->commend_list($comment_data);
                echo json_encode($result);
            }
            exit;
        }
    }
    /**
     * 댓글 
     */
    public function commentdeleteAction()
    {
        //$board_id = $this->dispatcher->getParam('board_id');
        $board_id = $this->board_id;
        $board_idx = $this->dispatcher->getParam('idx');
        if ($this->request->isAjax()) {
            $this->view->disable();
            $comment_idx = $this->request->getPost("comment_idx");
            $board = new \Multiple\Backend\Models\Board();
            $board->setSource($board_id);
            $comments = new \Multiple\Backend\Models\Comments();
            $comments->setSource("comment_boards");
            $comments_date = $comments->findFirstByIdx($comment_idx);
            if ($comments_date->delete()) {
                $comment_data = \Multiple\Backend\Models\Comments::find(
                    [
                        "board_id = :board_id: AND board_idx = :board_idx:",
                        "bind" => ["board_id" => $board->getSource(), "board_idx" => $board_idx]
                    ]
                );
                $result['code'] = "00";
                $result['msg'] = "삭제 되었습니다.";
                $result['value'] = $this->commend_list($comment_data);
                echo json_encode($result);
            }
            exit;
        }
    }
    /**
     * 댓글 리스트 출력
     */
    private function commend_list($comment_data)
    {
        $temp_table = "";
        if ($comment_data) { 
            $temp_table .= "<table class=\"table table-bordered\">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>memo</th>
                                            <th>Member</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>";   
            foreach ($comment_data as $k => $v) {
                $k = $k+1;                    
                $temp_table .= "<tr>
                                        <td>{$k}</td>
                                        <td><span id=\"txt_comment_selete_".$v->idx."\">".nl2br($v->memo)."</span></td>
                                        <td>{$v->member}</td>
                                        <td><span id=\"btn_comment_selete_".$v->idx."\" onClick=\"btn_comment_selete('btn_comment_selete_".$v->idx."')\" >수정</span></td>
                                        <td><span id=\"btn_comment_delete_".$v->idx."\" onClick=\"btn_comment_delete('btn_comment_delete_".$v->idx."')\" >삭제</span></td>
                                    </tr>";
            }                                 
            $temp_table .= "        </tbody>
                            </table>";
        }
        return $temp_table;
    }
}