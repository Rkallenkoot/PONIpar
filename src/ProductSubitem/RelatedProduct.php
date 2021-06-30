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
 * A <RelatedProduct> subitem.
 *
 * https://ns.editeur.org/onix/en/51
 */
class RelatedProduct extends Subitem
{
    const UNSPECIFIED = '00';
    const INCLUDES = '01';
    const IS_PART_OF = '02';
    const REPLACES = '03';
    const REPLACED_BY = '05';
    const ALTERNATIVE_FORMAT = '06';
    const HAS_ANCILLARY_PRODUCT = '07';
    const IS_ANCILLARY_TO = '08';
    const IS_REMAINDERED_AS = '09';
    const IS_REMAINDER_OF = '10';
    const IS_OTHER_LANGUAGE_VERSION_OF = '11';
    const PUBLISHER’S_SUGGESTED_ALTERNATIVE = '12';
    const EPUBLICATION_BASED_ON_PRINT_PRODUCT = '13';
    const POD_REPLACEMENT_FOR = '16';
    const REPLACED_BY_POD = '17';
    const IS_SPECIAL_EDITION_OF = '18';
    const HAS_SPECIAL_EDITION = '19';
    const IS_PREBOUND_EDITION_OF = '20';
    const IS_ORIGINAL_OF_PREBOUND_EDITION = '21';
    const PRODUCT_BY_SAME_AUTHOR = '22';
    const SIMILAR_PRODUCT = '23';
    const IS_FACSIMILE_OF = '24';
    const IS_ORIGINAL_OF_FACSIMILE = '25';
    const IS_LICENSE_FOR = '26 ';
    const ELECTRONIC_VERSION_AVAILABLE_AS = '27 ';
    const ENHANCED_VERSION_AVAILABLE_AS = '28';
    const BASIC_VERSION_AVAILABLE_AS = '29';
    const PRODUCT_IN_SAME_COLLECTION = '30';
    const HAS_ALTERNATIVE_IN_A_DIFFERENT_MARKET_SECTOR = '31';
    const HAS_EQUIVALENT_INTENDED_FOR_A_DIFFERENT_MARKET = '32';
    const HAS_ALTERNATIVE_INTENDED_FOR_DIFFERENT_MARKET = '33';
    const CITES = '34';
    const IS_CITED_BY = '35';
    const IS_SIGNED_VERSION_OF = '37 ';
    const HAS_SIGNED_VERSION = '38';
    const HAS_RELATED_STUDENT_MATERIAL = '39';
    const HAS_RELATED_TEACHER_MATERIAL = '40';
    const SOME_CONTENT_SHARED_WITH = '41';
    const IS_LATER_EDITION_OF_FIRST_EDITION = '42';
    const ADAPTED_FROM = '43';
    const ADAPTED_AS = '44';

    /**
     * The ProductRelationCode of this RelatedProduct
     */
    protected $code = null;

    /**
     * The ProductIdentifiers of this RelatedProduct
     */
    protected $productIdentifiers = [];

    /**
     * Create a new Subject.
     *
     * @param mixed $in The <Subject> DOMDocument or DOMElement.
     */
    public function __construct($in)
    {
        parent::__construct($in);

        try {
            $this->productIdentifiers = array_map(
                fn ($d) => new ProductIdentifier($d),
                $this->xpath->query('/*/ProductIdentifier')
            );

            dd($this->productIdentifiers);
            //new ProductIdentifier($this->_getSingleChildElement('ProductIdentifier'));

        } catch (\Exception $e) {
        }
        try {
            $this->code = $this->_getSingleChildElementText('ProductRelationCode');
        } catch (\Exception $e) {
        }

        // Save memory.
        $this->_forgetSource();
    }

    /**
     * Retrieve the type of this identifier.
     *
     * @return string The contents of <ProductRelationCode>.
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getProductIdentifiers() : array
    {
        return $this->productIdentifiers;
    }


    /**
     * Retrieve the ProductIdentifier
     *
     * @return ProductIdentifier The contents of <ProductIdentifier>.
     */
    public function getProductIdentifier()
    {
        foreach ($this->productIdentifiers as $pi) {
            if ($pi->getType() === ProductIdentifier::TYPE_ISBN13) {
                return $pi;
            }
        }
        return null;
    }
}
