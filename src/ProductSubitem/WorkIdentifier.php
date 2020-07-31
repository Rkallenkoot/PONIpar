<?php

namespace PONIpar\ProductSubitem;

use PONIpar\ProductSubitem\Subitem;
use PONIpar\Exceptions\ONIXException;

/*
   This file is part of the PONIpar PHP Onix Parser Library.
   Copyright (c) 2012, [di] digitale informationssysteme gmbh
   All rights reserved.

   The software is provided under the terms of the new (3-clause) BSD license.
   Please see the file LICENSE for details.
*/

/**
 * A <WorkIdentifier> subitem.
 *
 * https://onix-codelists.io/codelist/16
 */
class WorkIdentifier extends Subitem
{

    // Mapping of constants to types.
    const TYPE_PROPRIETARY  = '01';
    const TYPE_ISBN10       = '02';
    const TYPE_DOI          = '06';
    const TYPE_ISTC         = '11';
    const TYPE_ISBN13       = '15';
    const TYPE_ISRC         = '18';
    const TYPE_GLIMIR       = '32';
    const OWI               = '33';

    /**
     * The type of this work identifier.
     */
    protected $type = null;

    /**
     * The identifier’s value.
     */
    protected $value = null;

    /**
     * Create a new ProductIdentifier.
     *
     * @param mixed $in The <ProductIdentifier> DOMDocument or DOMElement.
     */
    public function __construct($in)
    {
        parent::__construct($in);
        // Retrieve and check the type.
        $this->type = $this->_getSingleChildElementText('WorkIDType');
        if (!preg_match('/^[0-9]{2}$/', $this->type)) {
            throw new ONIXException('wrong format of WorkIDType');
        }
        // Get the value.
        $this->value = $this->_getSingleChildElementText('IDValue');

        // Save memory.
        $this->_forgetSource();
    }

    /**
     * Retrieve the type of this identifier.
     *
     * @return string The contents of <WorkIDType>.
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
}
