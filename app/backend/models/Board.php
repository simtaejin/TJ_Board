<?php

namespace Multiple\Backend\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf as PresenceOf;

class Board extends ModelBase
{
    public $idx;
    public $ref_group;
    public $ref_level;
    public $ref_order;
    public $member;
    public $title;
    public $content;
    public $hits;
    public $created;
    public $updated;
    public function initialize()
    {
        $this->setschema("tj_board");
        //$this->allowEmptyStringValues(['title', 'content']);
        //$this->skipAttributes(['idx']);
    }
    public function setSource($source)
    {
        parent::setSource("board_" . $source); // TODO: Change the autogenerated stub
    }
    public function getSource()
    {
        return parent::getSource(); // TODO: Change the autogenerated stub
    }
    public function beforeValidationOnCreate()
    {
        $this->created = date('Y-m-d H:i:s');
    }
    public function validation()
    {
        $validator = new Validation();
        $validator->add(['title', 'content'], new PresenceOf([
            'message' => [
                'title' => 'title을 입력하세요.',
                'content' => 'content을 입력하세요.'
            ],
        ]));
        return $this->validate($validator);
    }
    public function finds($parameters = null)
    {
        $result = parent::find($parameters);
        $this->find_file($result);
        $this->find_comment($result);
        return $result;
    }
    public function find_comment($result)
    {
        $temp_array = array();
        $comments = new Comments();
        $comments->setSource("comment_boards");
        foreach ($result as $index => $item) {
            $comments_data = $comments->find(
                [
                    "board_id = :board_id: AND board_idx = :board_idx:",
                    "bind" => ["board_id" => $this->getSource(), "board_idx" => $item->idx]
                ]
            );
            if ($comments_data->count() > 0) {
                foreach ($comments_data as $k => $v) {
                    $temp_array[$item->idx][$k]["idx"] = $k+1;
                    $temp_array[$item->idx][$k]["comment_idx"] = $comments_data[$k]->idx;
                    $temp_array[$item->idx][$k]["memo"] = $comments_data[$k]->memo;
                    $temp_array[$item->idx][$k]["member"] = $comments_data[$k]->member;
                }
            } else {
                $temp_array[$item->idx] = "";
            }
        }
        $result->comments = $temp_array;
        return $result;
    }
    public function find_file($result)
    {
        $temp_array = array();
        $files = new Files();
        $files->setSource("file_boards");
        foreach ($result as $index => $item) {
            $files_data = $files->find(
                [
                    "board_id = :board_id: AND board_idx = :board_idx:",
                    "bind" => ["board_id" => $this->getSource(), "board_idx" => $item->idx]
                ]
            );
            if ($files_data->count() > 0) {
                foreach ($files_data as $k => $v) {
                    $temp_array[$item->idx][$k]["file_idx"] = $files_data[$k]->idx;
                    $temp_array[$item->idx][$k]["origina_name"] = $files_data[$k]->origina_name;
                    $temp_array[$item->idx][$k]["artifical_name"] = $files_data[$k]->artifical_name;
                }
            } else {
                $temp_array[$item->idx] = "";
            }
        }
        $result->files = $temp_array;
        return $result;
        //return parent::find($parameters);
    }
    public function latest($limit = 0)
    {
        $parameters[0] = "ref_level = '0'";
        $parameters["order"] = "ref_group desc";
        $parameters["limit"] = $limit;
        $board_data = $this->finds($parameters);
        return $board_data;
    }
    public function setTemp($temp)
    {
        //$this->temp = $this->getSource()." ::::  ".$idx;
        $this->temp = $temp;
    }
    public function getTemp()
    {
        return $this->temp;
    }
}