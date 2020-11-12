<?php


namespace Scss\Scss;

use \Scss\Scss\scss_formatter;

class scss_formatter_compressed extends scss_formatter
{
    public $open = "{";
    public $tagSeparator = ",";
    public $assignSeparator = ":";
    public $break = "";

    public function indentStr($n = 0) {
        return "";
    }
}
