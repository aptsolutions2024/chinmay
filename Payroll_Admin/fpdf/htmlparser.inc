<?php

define ("NODE_TYPE_START",0);
define ("NODE_TYPE_ELEMENT",1);
define ("NODE_TYPE_ENDELEMENT",2);
define ("NODE_TYPE_TEXT",3);
define ("NODE_TYPE_COMMENT",4);
define ("NODE_TYPE_DONE",5);

class HtmlParser {

    public $iNodeType;
    public $iNodeName = "";
    public $iNodeValue = "";
    public $iNodeAttributes;

    private $iHtmlText;
    private $iHtmlTextLength;
    private $iHtmlTextIndex = 0;
    private $iHtmlCurrentChar;
    private $BOE_ARRAY;
    private $B_ARRAY;
    private $BOS_ARRAY;
    
    function __construct($aHtmlText) {
        $this->iHtmlText = $aHtmlText;
        $this->iHtmlTextLength = strlen($aHtmlText);
        $this->iNodeAttributes = [];
        $this->setTextIndex(0);

        $this->BOE_ARRAY = [" ", "\t", "\r", "\n", "="];
        $this->B_ARRAY = [" ", "\t", "\r", "\n"];
        $this->BOS_ARRAY = [" ", "\t", "\r", "\n", "/"];
    }

    function parse() {
        $text = $this->skipToElement();
        if ($text != "") {
            $this->iNodeType = NODE_TYPE_TEXT;
            $this->iNodeName = "Text";
            $this->iNodeValue = $text;
            return true;
        }
        return $this->readTag();
    }

    function clearAttributes() {
        $this->iNodeAttributes = [];
    }

    function readTag() {
        if ($this->iCurrentChar != "<") {
            $this->iNodeType = NODE_TYPE_DONE;
            return false;
        }
        $this->clearAttributes();
        $this->skipMaxInTag("<", 1);
        if ($this->iCurrentChar == '/') {
            $this->moveNext();
            $name = $this->skipToBlanksInTag();
            $this->iNodeType = NODE_TYPE_ENDELEMENT;
            $this->iNodeName = $name;
            $this->iNodeValue = "";            
            $this->skipEndOfTag();
            return true;
        }
        $name = $this->skipToBlanksOrSlashInTag();
        if (!$this->isValidTagIdentifier($name)) {
            if (str_starts_with($name, "!--")) {
                $rest = $this->skipToStringInTag("-->");
                if ($rest != "") {
                    $this->iNodeType = NODE_TYPE_COMMENT;
                    $this->iNodeName = "Comment";
                    $this->iNodeValue = "<" . $name . $rest;
                    return true;
                }
            }
            $this->iNodeType = NODE_TYPE_TEXT;
            $this->iNodeName = "Text";
            $this->iNodeValue = "<" . $name;
            return true;
        }
        $this->iNodeType = NODE_TYPE_ELEMENT;
        $this->iNodeValue = "";
        $this->iNodeName = $name;
        while ($this->skipBlanksInTag()) {
            $attrName = $this->skipToBlanksOrEqualsInTag();
            if ($attrName != "" && $attrName != "/") {
                $this->skipBlanksInTag();
                if ($this->iCurrentChar == "=") {
                    $this->skipEqualsInTag();
                    $this->skipBlanksInTag();
                    $value = $this->readValueInTag();
                    $this->iNodeAttributes[strtolower($attrName)] = $value;
                } else {
                    $this->iNodeAttributes[strtolower($attrName)] = "";
                }
            }
        }
        $this->skipEndOfTag();
        return true;            
    }

    function isValidTagIdentifier($name) {
        return preg_match("/^[A-Za-z0-9_\\-]+$/", $name);
    }

    function skipBlanksInTag() {
        return "" != ($this->skipInTag($this->B_ARRAY));
    }

    function skipToBlanksOrEqualsInTag() {
        return $this->skipToInTag($this->BOE_ARRAY);
    }

    function skipToBlanksInTag() {
        return $this->skipToInTag($this->B_ARRAY);
    }

    function skipToBlanksOrSlashInTag() {
        return $this->skipToInTag($this->BOS_ARRAY);
    }

    function skipEqualsInTag() {
        return $this->skipMaxInTag("=", 1);
    }

    function readValueInTag() {
        $ch = $this->iCurrentChar;
        $value = "";
        if ($ch == "\"") {
            $this->skipMaxInTag("\"", 1);
            $value = $this->skipToInTag("\"");
            $this->skipMaxInTag("\"", 1);
        } else if ($ch == "'") {
            $this->skipMaxInTag("'", 1);
            $value = $this->skipToInTag("'");
            $this->skipMaxInTag("'", 1);
        } else {
            $value = $this->skipToBlanksInTag();
        }
        return $value;
    }

    function setTextIndex($index) {
        $this->iHtmlTextIndex = $index;
        if ($index >= $this->iHtmlTextLength) {
            $this->iCurrentChar = -1;
        } else {
            $this->iCurrentChar = $this->iHtmlText[$index];
        }
    }

    function moveNext() {
        if ($this->iHtmlTextIndex < $this->iHtmlTextLength) {
            $this->setTextIndex($this->iHtmlTextIndex + 1);
            return true;
        }
        return false;
    }

    function skipEndOfTag() {
        while (($ch = $this->iCurrentChar) !== -1) {
            if ($ch == ">") {
                $this->moveNext();
                return;
            }
            $this->moveNext();
        }
    }

    function skipInTag($chars) {
        $sb = "";
        while (($ch = $this->iCurrentChar) !== -1) {
            if ($ch == ">") {
                return $sb;
            }
            if (in_array($ch, $chars)) {
                $sb .= $ch;
                $this->moveNext();
            } else {
                return $sb;
            }
        }
        return $sb;
    }

    function skipMaxInTag($chars, $maxChars) {
        $sb = "";
        $count = 0;
        while (($ch = $this->iCurrentChar) !== -1 && $count++ < $maxChars) {
            if ($ch == ">") {
                return $sb;
            }
            if (in_array($ch, $chars)) {
                $sb .= $ch;
                $this->moveNext();
            } else {
                return $sb;
            }
        }
        return $sb;
    }

    function skipToInTag($chars) {
        $sb = "";
        while (($ch = $this->iCurrentChar) !== -1) {
            if ($ch == ">" || in_array($ch, $chars)) {
                return $sb;
            }
            $sb .= $ch;
            $this->moveNext();
        }
        return $sb;
    }

    function skipToElement() {
        $sb = "";
        while (($ch = $this->iCurrentChar) !== -1) {
            if ($ch == "<") {
                return $sb;
            }
            $sb .= $ch;
            $this->moveNext();
        }
        return $sb;             
    }

    function skipToStringInTag($needle) {
        $pos = strpos($this->iHtmlText, $needle, $this->iHtmlTextIndex);
        if ($pos === false) {
            return "";
        }
        $top = $pos + strlen($needle);
        $retvalue = substr($this->iHtmlText, $this->iHtmlTextIndex, $top - $this->iHtmlTextIndex);
        $this->setTextIndex($top);
        return $retvalue;
    }
}

function HtmlParser_ForFile($fileName) { 
    return HtmlParser_ForURL($fileName);
}

function HtmlParser_ForURL($url) {
    $content = @file_get_contents($url);
    if ($content === false) {
        throw new Exception("Could not open URL: $url");
    }
    return new HtmlParser($content);
}

?>
