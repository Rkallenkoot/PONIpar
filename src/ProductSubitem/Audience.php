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
 * A <Audience> subitem.
 */
class Audience extends Subitem
{
    protected static $types = [
        '01' => 'ONIX audience codes',
        '02' => 'Proprietary',
        '03' => 'MPAA rating',
        '04' => 'BBFC rating',
        '05' => 'FSK rating',
        '06' => 'BTLF audience code',
        '07' => 'Electre audience code',
        '08' => 'ANELE Tipo',
        '09' => 'AVI',
        '10' => 'USK rating',
        '11' => 'AWS',
        '12' => 'Schulform',
        '13' => 'Bundesland',
        '14' => 'Ausbildungsberuf',
        '15' => 'Suomalainen kouluasteluokitus',
        '16' => 'CBG age guidance',
        '17' => 'Nielsen Book audience code',
        '18' => 'AVI (revised)',
        '19' => 'Lexile measure',
        '20' => 'Fry Readability score',
        '21' => 'Japanese Children’s audience code',
        '22' => 'ONIX Adult audience rating',
        '23' => 'Common European Framework of Reference for Language Learning (CEFR)',
        '24' => 'Korean Publication Ethics Commission rating',
        '25' => 'IoE Book Band',
        '26' => 'FSK Lehr-/Infoprogramm',
        '27' => 'Intended audience language',
        '28' => 'PEGI rating',
        '29' => 'Gymnasieprogram',
    ];

    /**
     * CodeList29 AudienceCodeType
     */
    protected $audienceCodeType = null;

    /**
     * AudienceCodeValue
     */
    protected $audienceCodeValue = null;

    /**
     * Create a new Contributor.
     *
     * @param mixed $in The <Contributor> DOMDocument or DOMElement.
     */
    public function __construct($in)
    {
        parent::__construct($in);

        // Retrieve and check the type.
        try {
            $this->audienceCodeType = $this->_getSingleChildElementText('AudienceCodeType');
        } catch (\Exception $e) {
        }

        try {
            $this->audienceCodeValue = $this->_getSingleChildElementText('AudienceCodeValue');
        } catch (\Exception $e) {
        }

        if (!$this->audienceCodeValue) {
            /**
             * Onix v2 can define <Audience> composite as well as sole <AudienceCode>
             * CodeList 28 
             */
            $this->audienceCodeValue = $in->textContent;
        }

        // Save memory.
        $this->_forgetSource();
    }


    /**
     * Get the audienceCodeType Codelist29
     *
     * @return ?string|null
     */
    public function getType()
    {
        return $this->audienceCodeType;
    }

    /**
     * Get the value of the Audience
     *
     * @return ?string|null
     */
    public function getValue()
    {
        return $this->audienceCodeValue;
    }
}
