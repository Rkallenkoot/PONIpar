<?php

namespace PONIpar\ProductSubitem;

use PONIpar\Exceptions\ONIXException;

/*
   This file is part of the PONIpar PHP Onix Parser Library.
   Copyright (c) 2012, [di] digitale informationssysteme gmbh
   All rights reserved.

   The software is provided under the terms of the new (3-clause) BSD license.
   Please see the file LICENSE for details.
*/

/**
 * A <Title> subitem.
 */
class Title extends Subitem
{
    // TODO - add more type constants
    public const TYPE_DISTINCTIVE_TITLE = "01";

    /**
     * The type of this product identifier.
     */
    protected $type = null;

    /**
     * The title's values
     */
    protected $value = array(
        'title' => null,
        'subtitle' => null,
        'titlePrefix' => null,
        'titleWithoutPrefix' => null,
    );

    /**
     * Create a new Title.
     *
     * @param mixed $in The <Title> DOMDocument or DOMElement.
     */
    public function __construct($in)
    {
        parent::__construct($in);

        // Retrieve and check the type.
        $type = $this->_getSingleChildElementText('TitleType');

        if (!preg_match('/^[0-9]{2}$/', $type)) {
            throw new ONIXException('wrong format of TitleType');
        }
        $this->type = $type;

        try {
            $this->value['title'] = $this->_getSingleChildElementText('TitleText');
        } catch (\Exception $e) {
        }
        try {
            $this->value['subtitle'] = $this->_getSingleChildElementText('Subtitle');
        } catch (\Exception $e) {
        }

        try {
            $this->value['titlePrefix'] = $this->_getSingleChildElementText('TitlePrefix');
        } catch (\Exception $e) {
        }

        try {
            $this->value['titleWithoutPrefix'] = $this->_getSingleChildElementText('TitleWithoutPrefix');
        } catch (\Exception $e) {
        }

        // try 3.0 structure
        if (!$this->value['title']) {
            try {
                $this->value['title'] = $this->_getSingleChildElementText('TitleElement/TitleText');
            } catch (\Exception $e) {
            }
            try {
                $this->value['subtitle'] = $this->_getSingleChildElementText('TitleElement/Subtitle');
            } catch (\Exception $e) {
            }
            try {
                $this->value['titlePrefix'] = $this->_getSingleChildElementText('TitleElement/TitlePrefix');
            } catch (\Exception $e) {
            }

            try {
                $this->value['titleWithoutPrefix'] = $this->_getSingleChildElementText('TitleElement/TitleWithoutPrefix');
            } catch (\Exception $e) {
            }
        }

        // Save memory.
        $this->_forgetSource();
    }

    /**
     * Retrieve the type of this identifier.
     *
     * @return string The contents of <ProductIDType>.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Retrieve the actual value of this identifier.
     *
     * @return string The contents of <IDValue>.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Retrieve the subtitle
     *
     * @return string The contents of <Subtitle>.
     */
    public function getSubtitle()
    {
        return $this->value['subtitle'];
    }

    /**
     * Retrieve the full title
     * 
     * Full title is value of <TitleText> or values of <TitlePrefix> and <TitleWithoutPrefix> concatenated
     *
     * @return string|null The contents of <Subtitle>.
     */
    public function getFullTitle()
    {
        if (!empty($this->value['title'])) {
            return $this->value['title'];
        }

        if (!empty($this->value['titlePrefix']) && !empty($this->value['titleWithoutPrefix'])) {
            return $this->value['titlePrefix'] . ' ' . $this->value['titleWithoutPrefix'];
        }

        return null;
    }

    /**
     * Retrieve the title prefix
     * 
     * @return string|null The contents of <TitlePrefix>.
     */
    public function getTitlePrefix()
    {
        return $this->value['titlePrefix'];
    }

    /**
     * Retrieve the title without prefix
     * 
     * @return string|null The contents of <TitleWithoutPrefix>.
     */
    public function getTitleWithoutPrefix()
    {
        return $this->value['titleWithoutPrefix'];
    }
};
