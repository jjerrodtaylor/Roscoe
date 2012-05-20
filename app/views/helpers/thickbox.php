<?php

class ThickboxHelper extends AppHelper {

    var $helpers = array('Javascript', 'Html');

    /**

     * Set properties – DOM ID, Height and Width, Type of thickbox window – inline or ajax

     *

     * @param array $options

     */
    function setProperties($options = array()) {

        if (!isset($options['type'])) {

            $options['type'] = 'inline';
        }

        $this->options = $options;
    }

    function setPreviewContent($content, $class=null) {

        $this->options['previewContent'] = $content;
		$this->options['previewClass'] = $class;
    }

    function setMainContent($content) {

       $this->options['mainContent'] = $content;
    }

    function reset() {

        $this->options = array();
    }

    function output() {

        extract($this->options);

        if ($type == 'inline') {

            $href = 'TB_inline?';

            $href .= '&amp;inlineId=' . $id;
        } elseif ($type == 'ajax') {

            $ajaxUrl = $this->Html->url($ajaxUrl);

            $href = $ajaxUrl . '?';
        }



        if (isset($height)) {

            $href .= '&amp;height=' . $height;
        }

        if (isset($width)) {

            $href .= '&amp;width=' . $width;
        }
		if (isset($modal)) {

            $href .= '&amp;modal=' . $modal;
        }





        $output = '<a class="thickbox '.$previewClass.'" href="' . $href . '">' . $previewContent . '</a>';



        if ($type == 'inline') {

            $output .= '<div id="' . $id . '" style="display:none;">' . $mainContent . '</div>';
        }

        $out = $this->Html->css('/css/thickbox.css') . '<script type="text/javascript" src="' . $this->Html->url('/js/thickbox.js') . '"></script>';

        $view = & ClassRegistry::getObject('view');

        $view->addScript($out);

        unset($this->options);



        return $output;
    }

    

}
?>
