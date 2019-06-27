<?php

namespace Starbucksb2b\RequestCredit\Model\Attribute\Source;

class SelectOption implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Remind Status values
     */
    const ENABLE = 0;
    const DISABLE = 1;

    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::ENABLE,  'label' => __('Enable')],
            ['value' => self::DISABLE,  'label' => __('Disable')]
        ];
    }
}
