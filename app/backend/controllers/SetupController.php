<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Db\Column as Column;

class SetupController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setVar("userId", $this->session->get("id"));
    }
    public function indexAction()
    {
     
    }
    public function boardAction()
    {
        $this->persistent->parameters = null;
        if (!$this->dispatcher->getParam('page')) {
            $numberPage = 1;
        } else {
            $numberPage = $this->dispatcher->getParam('page');
        }
        $parameters["order"] = "idx desc";
        $sb = new SetupBoard();
        $sb->setSource("board");
        $sb_data = $sb->find($parameters);
        $paginator = new Paginator([
            'data' => $sb_data,
            'limit' => 10,
            'page' => $numberPage
        ]);   
        $this->view->page = $paginator->getPaginate();
    }
    public function board_createAction()
    {
        if ($this->request->isPost()) {
            $this->view->disable();
            $this->component->helper->csrf("setup/board/create/");
            $board = new SetupBoard();
            $board->setSource("board");
            $board->id = $this->request->getPost("id");
            $board->name = $this->request->getPost("name");
            $board->skin = $this->request->getPost("skin");
            if (!$board->create()) {
                foreach ($board->getMessages() as $message) {
                    echo $message . "<br>";
                }
                return;
            } else {
                $table_id = "board_".$board->id;
                if (!$this->db->tableExists($table_id)) {
                    $this->db->createTable(
                        $table_id,
                        null,
                        [
                            'columns' => [
                                new Column('idx',['type'=> Column::TYPE_INTEGER,'size'=> 11,'notNull'=> true,'autoIncrement' => true,'primary'=> true,]),
                                new Column('ref_group',['type'=> Column::TYPE_INTEGER,'size'=> 11,'notNull'=> true,'default' => 0,]),
                                new Column('ref_level',['type'=> Column::TYPE_INTEGER,'size'=> 11,'notNull'=> true,'default' => 0,]),
                                new Column('ref_order',['type'=> Column::TYPE_INTEGER,'size'=> 11,'notNull'=> true,'default' => 0,]),                                
                                new Column('member',['type'=> Column::TYPE_VARCHAR,'size'=> 50,'notNull' => true,]),
                                new Column('title',['type'=> Column::TYPE_VARCHAR,'size'=> 255,'notNull' => true,]),
                                new Column('content',['type'=> Column::TYPE_TEXT,]),
                                new Column('hits',['type'=> Column::TYPE_INTEGER,'size'=> 11,'notNull'=> true,'default' => 0,]),
                                new Column('created',['type'=> Column::TYPE_DATETIME,'notNull'=> true,'default' => '0000-00-00 00:00:00',]),
                                new Column('updated',['type'=> Column::TYPE_DATETIME,'notNull'=> true,'default' => '0000-00-00 00:00:00',]),
                            ]
                        ]
                    );
                }
                if (!is_dir($this->config->application->dataDir . "/board/" . $board->id)) {
                    mkdir($this->config->application->dataDir, 0777);
                    mkdir($this->config->application->dataDir . "/board/", 0777);
                    mkdir($this->config->application->dataDir . "/board/" . $board->id, 0777);
                }
                if (!is_dir($this->config->application->dataDir . "/board/" . $board->id."/thumbnail/")) {
                    mkdir($this->config->application->dataDir . "/board/" . $board->id."/thumbnail/", 0777);
                }
            }
            $this->component->helper->alert("게시판이 등록 되었습니다.", "/setup/board/");
        }
        $_board_list = scandir($this->view->getViewsDir()."board/");
        foreach ($_board_list as $key => $value) {
            if (is_dir($this->view->getViewsDir()."board/".$value) && !in_array($value, array(".","..")) ) {
                $_board_skin_list[] = $value;
            }
        }
        $this->view->setVar('_board_skin_list', $_board_skin_list);
    }
    public function board_updateAction()
    {
        $idx = $this->dispatcher->getParam('idx');
      
        if ($this->request->isPost()) {
            $this->view->disable();
            $this->component->helper->csrf("setup/board/create/");
            $sb = new SetupBoard();
            $sb->setSource("board");
            $this->request->get('idx');
            $sb_data = $sb->findFirstByIdx($idx);
            $sb_data->name = $this->request->getPost("name");
            $sb_data->skin = $this->request->getPost("skin");
            $sb_data->file = $this->request->getPost("file");
            $sb_data->reply = $this->request->getPost("reply");
            $sb_data->comment = $this->request->getPost("comment");                       
           
            if (!$sb_data->update()) {
                foreach ($sb_data->getMessages() as $message) {
                    echo $message . "<br>";
                }
                return;
            }
            $this->component->helper->alert("게시판이 수정 되었습니다.", "/setup/board/update/".$idx);
        } else {
            $sb = new SetupBoard();
            $sb->setSource("board");
            $sb_data = $sb->findFirstByIdx($idx);
            $this->view->setVar("idx", $sb_data->idx);
            $this->view->setVar("id", $sb_data->id);
            $this->view->setVar("name", $sb_data->name);
            $this->view->setVar("skin", $sb_data->skin);
            $this->view->setVar("file", $sb_data->file);
            $this->view->setVar("reply", $sb_data->reply);
            $this->view->setVar("comment", $sb_data->comment);                        
        }
        $_board_list = scandir($this->view->getViewsDir()."board/");
        foreach ($_board_list as $key => $value) {
            if (is_dir($this->view->getViewsDir()."board/".$value) && !in_array($value, array(".","..")) ) {
                $_board_skin_list[] = $value;
            }
        }
        $this->view->setVar('_board_skin_list', $_board_skin_list);
    }
    public function board_deleteAction()
    {
        $idx = $this->dispatcher->getParam('idx');
        $sb = new SetupBoard();
        $sb->setSource("board");
        $sb_data = $sb->findFirstByIdx($idx);
        if (!$sb_data->delete()) {
            foreach ($sb_data->getMessages() as $message) {
                echo $message . "<br>";
            }
            return;
        }
        $this->db->dropTable("board_".$sb_data->id);
        $this->component->helper->alert("게시판이 삭제 되었습니다.", "/setup/board/");
    }
}