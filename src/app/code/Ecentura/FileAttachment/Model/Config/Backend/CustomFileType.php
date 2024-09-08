<?php
 
namespace Ecentura\FileAttachment\Model\Config\Backend;
 
class CustomFileType extends \Magento\Config\Model\Config\Backend\File
{
    const UPLOAD_DIR = 'upload';
    public function getAllowedExtensions() {
        return ['pdf'];
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