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
 * A <RelatedWork> subitem.
 */
class RelatedWork extends Subitem
{
    const MANIFESTATION_OF = '01';
    const DERIVED_FROM = '02';
    const RELATED_WORK = '03';
    const OTHER_WORK_IN_SAME_COLLECTION = '03';
    const OTHER_WORK_BY_SAME_CONSTRIBUTOR = '04';

    /**
     * The WorkRelationCode of this RelatedWork
     */
    protected $code = null;

    /**
     * The WorkIdentifier of this RelatedProduct
     */
    protected $value = null;

    /**
     * Create a new Subject.
     *
     * @param mixed $in The <Subject> DOMDocument or DOMElement.
     */
    public function __construct($in)
    {
        parent::__construct($in);

        try {
            $this->value = new WorkIdentifier($this->_getSingleChildElement('WorkIdentifier'));
        } catch (\Exception $e) {
        }
        try {
            $this->code = $this->_getSingleChildElementText('WorkRelationCode');
        } catch (\Exception $e) {
        }

        // Save memory.
        $this->_forgetSource();
    }

    /**
     * Retrieve the code of the RelatedWork
     *
     * @return string The contents of <WorkRelationCode>.
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Retrieve the WorkIdentifier
     *
     * @return WorkIdentifier The contents of <WorkIdentifier>.
     */
    public function getWorkIdentifier()
    {
        return $this->workIdentifier;
    }
};
