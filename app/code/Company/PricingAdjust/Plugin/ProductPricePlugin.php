<?php
namespace Company\PricingAdjust\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ProductPricePlugin
{
    const XML_PATH_MARKUP = 'Company_PricingAdjust/pricing_adjustments/markup_percentage';

    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        return $this->applyMarkup($result);
    }

    public function afterGetFinalPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        return $this->applyMarkup($result);
    }

    private function applyMarkup($price)
    {
        $markup = (float)$this->scopeConfig->getValue(self::XML_PATH_MARKUP, ScopeInterface::SCOPE_STORE);
        if ($markup > 0 && $price > 0) {
            $price += $price * ($markup / 100);
        }
        return $price;
    }
}
