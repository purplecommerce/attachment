<?php
namespace PurpleCommerce\Attachment\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   const MODULE_ENABLE = "attachment/general/enable";
   const ALLOWED_FILE_TYPE = "attachment/general/allowedfiletype";
   

   public function getDefaultConfig($path)
   {
       return $this->scopeConfig->getValue($path, \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
   }

   public function isModuleEnabled()
   {
       return (bool) $this->getDefaultConfig(self::MODULE_ENABLE);
   }

   public function getFileTypes()
   {
       return $this->getDefaultConfig(self::ALLOWED_FILE_TYPE);
   }

   public function getconfig($config_path){
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
   }
 }