<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magmodules\Channable\Block\Adminhtml\System\Config\Button;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magmodules\Channable\Model\Config\Repository as ConfigRepository;

/**
 * Version check button class
 */
class VersionCheck extends Field
{

    /**
     * @var string
     */
    protected $_template = 'Magmodules_Channable::system/config/button/version.phtml';
    /**
     * @var ConfigRepository
     */
    private $configRepository;
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * VersionCheck constructor.
     * @param Context $context
     * @param ConfigRepository $configRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigRepository $configRepository,
        array $data = []
    ) {
        $this->configRepository = $configRepository;
        $this->request = $context->getRequest();
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->configRepository->getExtensionVersion();
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    public function getVersionCheckUrl()
    {
        return $this->getUrl('channable/versioncheck/index');
    }

    /**
     * @return string
     */
    public function getChangeLogUrl()
    {
        return $this->getUrl('channable/versioncheck/changelog');
    }

    /**
     * @return mixed
     */
    public function getButtonHtml()
    {
        try {
            return $this->getLayout()
                ->createBlock(Button::class)
                ->setData(['id' => 'mm-channable-button_version', 'label' => __('Check for latest versions')])
                ->toHtml();
        } catch (Exception $e) {
            return false;
        }
    }
}
