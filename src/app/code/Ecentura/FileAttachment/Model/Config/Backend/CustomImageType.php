<?php
 
namespace Ecentura\FileAttachment\Model\Config\Backend;
 
class CustomImageType extends \Magento\Config\Model\Config\Backend\Image
{
    const UPLOAD_DIR = 'upload';
    public function getAllowedExtensions() {
        return ['png', 'jpg'];
    }

    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    protected function _addWhetherScopeInfo()
    {
        return true;
    }
}