<?php

namespace Futhuer;

use Zend\View\Model\ViewModel;

class Layout {

    /**
     * Sets viewModel as terminal.
     * This disables the rendering of the layout.
     * @param \Zend\View\Model\ViewModel $viewModel
     * @return \Zend\View\Model\ViewModel
     */
    public static function disableLayout(ViewModel $viewModel) {
        return $viewModel->setTerminal(true);
    }

}

?>
