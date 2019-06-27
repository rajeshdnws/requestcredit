<?php
namespace Starbucksb2b\RequestCredit\Model\Attribute\Source;

class ProductStatus implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Remind Status values
     */
    const YES = 1;
    const NO = 0;

    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::YES,  'label' => __('Yes')],
            ['value' => self::NO,  'label' => __('No')]
        ];
    }
}
