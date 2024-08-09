<?php

namespace PONIpar\ProductSubitem;

/*
   This file is part of the PONIpar PHP Onix Parser Library.
   Copyright (c) 2012, [di] digitale informationssysteme gmbh
   All rights reserved.

   The software is provided under the terms of the new (3-clause) BSD license.
   Please see the file LICENSE for details.
*/

/**
 * A <OtherText> subitem.
 */
class OtherText extends Subitem
{
    // List 33
    public const TYPE_MAIN_DESCRIPTION = "01";
    public const TYPE_SHORT_DESCRIPTION = "02";
    public const TYPE_LONG_DESCRIPTION = "03";
    public const TYPE_REVIEW_QUOTE = "08";
    public const TYPE_BIOGRAPHICAL_NOTE = "13";

    // List 153 (onix v3)
    public const TYPE_SHORT_DESCRIPTION_V3 = "02";
    public const TYPE_DESCRIPTION_V3 = "03";
    public const TYPE_TABLE_OF_CONTENTS_V3 = "04";
    public const TYPE_REVIEW_QUOTE_V3 = "06";
    public const TYPE_BIOGRAPHICAL_NOTE_V3 = "12";
    public const TYPE_DESCRIPTION_FOR_COLLECTION_V3 = "17";

    // List 34
    public const FORMAT_HTML = '02';
    public const FORMAT_TEXT = '06';

    /**
     * Text data
     */
    protected $type = null;
    protected $format = null;
    protected $value = null;
    protected $author = null;

    /**
     * Create a new OtherText.
     *
     * @param mixed $in The <OtherText> DOMDocument or DOMElement.
     */
    public function __construct($in)
    {
        parent::__construct($in);

        try {
            $this->type = $this->_getSingleChildElementText('TextTypeCode');
        } catch (\Exception $e) {
        }

        // try 3.0
        if (!$this->type) {
            try {
                $this->type = $this->_getSingleChildElementText('TextType');
            } catch (\Exception $e) {
            }
        }

        try {
            $this->format = $this->_getSingleChildElementText('TextFormat');
        } catch (\Exception $e) {
        }
        try {
            $this->value = $this->_getSingleChildElementText('Text');
        } catch (\Exception $e) {
        }
        try {
            $this->author = $this->_getSingleChildElementText('TextAuthor');
        } catch (\Exception $e) {
        }

        $this->cleanValue();

        // Save memory.
        $this->_forgetSource();
    }

    /**
     * Retrieve the type of this text.
     *
     * @return string The contents of <TextTypeCode>.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Retrieve the format of this text.
     *
     * @return string The contents of <TextFormat>.
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Retrieve the actual value of this text.
     *
     * @return string The contents of <Text>.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Retrieve the actual value of this text.
     *
     * @return string The contents of <TextAuthor>.
     */
    public function getAuthor()
    {
        return $this->author;
    }

    private function cleanValue()
    {
        if (!$this->value) {
            return;
        }
        $this->value = str_replace("<![CDATA[", "", $this->value);
        $this->value = preg_replace("/\]\]>*$/", "", $this->value);
    }
};
