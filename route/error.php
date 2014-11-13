<?php
/**
* @file error.php
* @brief process error, case: 404
* @author ligang
* @version 1.0
* @date 2014-10-30
 */

namespace YueYue\Route;

class Error extends \YueYue\Route\Base
{/*{{{*/
    public function go($ext_params=array())
    {/*{{{*/
        switch($this->_route_params['errno'])
        {
        case \YueYue\Knowledge\Errno::E_SYS_INVALID_REQUEST_URI:
            $this->_process404();
            break;
        }
    }/*}}}*/

    private function _process404()
    {/*{{{*/
        echo "404 Not Found";

        header('HTTP/1.1 404 Not Found');
    }/*}}}*/
}/*}}}*/
