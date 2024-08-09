<?php

namespace PONIpar\ProductSubitem;

use PONIpar\ProductSubitem\Title;

/**
 * A <Collection> subitem.
 */
class Collection extends Subitem
{
    public const TYPE_PUBLISHER = "10";
    public const TYPE_ASCRIBED = "20";

    /**
     * The CollectionType of this Collection
     * 
     * CodeList 148
     */
    protected $type = null;

    /**
     * The <Collection> value.
     */
    protected $value = array(
        'identifier' => null,
        'identifierType' => null,
        'title' => null,
        'subtitle' => null,
    );

    public function __construct($in)
    {
        parent::__construct($in);

        // Onix v2 <Series>
        try {
            $this->value['identifierType'] = $this->_getSingleChildElementText('SeriesIdentifier/SeriesIDType');
        } catch (\Exception $e) {
        }

        try {
            $this->value['identifier'] = $this->_getSingleChildElementText('SeriesIdentifier/IDValue');
        } catch (\Exception $e) {
        }

        try {
            $this->value['title'] = $this->_getSingleChildElementText('TitleOfSeries');
        } catch (\Exception $e) {
        }

        // Onix v2 <Set>
        try {
            $this->value['identifierType'] = $this->_getSingleChildElementText('ProductIdentifier/ProductIDType');
        } catch (\Exception $e) {
        }

        try {
            $this->value['identifier'] = $this->_getSingleChildElementText('ProductIdentifier/IDValue');
        } catch (\Exception $e) {
        }

        try {
            $this->value['title'] = $this->_getSingleChildElementText('TitleOfSet');
        } catch (\Exception $e) {
        }

        // Onix v3 <Collection>
        try {
            $this->type = $this->_getSingleChildElementText('CollectionType');
        } catch (\Exception $e) {
        }

        try {
            $this->value['identifierType'] = $this->_getSingleChildElementText('CollectionIdentifier/CollectionIDType');
        } catch (\Exception $e) {
        }

        try {
            $this->value['identifier'] = $this->_getSingleChildElementText('CollectionIdentifier/IDValue');
        } catch (\Exception $e) {
        }

        try {
            $distinctiveTitle = $this->_getSingleChildElement('TitleDetail[TitleType=01]');
            $titleElement = new Title($distinctiveTitle);

            if ($titleElement) {
                $this->value['title'] = $titleElement->getFullTitle();
                $this->value['subtitle'] = $titleElement->getSubtitle();
            }
        } catch (\Exception $e) {
        }
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTitle()
    {
        return $this->value['title'];
    }

    public function getSubtitle()
    {
        return $this->value['subtitle'];
    }
}
