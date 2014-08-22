<?php
namespace YueYue\Tool;

class Postman
{/*{{{*/
    const CHARSET_UTF8 = 'utf-8';
    const CHARSET_GBK  = 'gb2312';

    const DEF_MIME_VERSION = '1.0';
    const DEF_CONTENT_TYPE = 'text/plain';

    const ADDR_SPR   = ',';
    const HEADER_SPR = "\r\n";

    private $_HEADER = array();

    private $_from        = '';
    private $_to          = array();
    private $_subject     = '';
    private $_msg         = '';
    private $_cc          = array();
    private $_bcc         = array();
    private $_charset     = '';
    private $_mimeVersion = '';
    private $_contentType = '';

    public function __construct()
    {/*{{{*/
        $this->_initHeader();
    }/*}}}*/
    public function sendMail($from='', $to=array(), $subject='', $msg='', $cc=array(), $bcc=array(), $charset=self::CHARSET_UTF8, $mimeVersion='', $contentType='')
    {/*{{{*/
        $this->_initParams($from, $to, $subject, $msg, $cc, $bcc, $charset, $mimeVersion, $contentType);
        if(false === $this->_verifyParams())
        {
            echo "Require params are: from, to, subject, msg\n";
            return ;
        }

        $this->_prepareSend();
        $this->_send();
    }/*}}}*/

    private function _initHeader()
    {/*{{{*/
        $this->_HEADER = array(
            'MIME-Version' => self::DEF_MIME_VERSION,
            'ContentType'  => self::DEF_CONTENT_TYPE,
            'From'         => '',
            'CC'           => '',
            'BCC'          => '',
        );
    }/*}}}*/
    private function _initParams($from, $to, $subject, $msg, $cc, $bcc, $charset, $mimeVersion, $contentType)
    {/*{{{*/
        $this->_from        = $from;
        $this->_to          = $to;
        $this->_subject     = $subject;
        $this->_msg         = $msg;
        $this->_cc          = $cc;
        $this->_bcc         = $bcc;
        $this->_charset     = $charset;
        $this->_mimeVersion = $mimeVersion;
        $this->_contentType = $contentType;
    }/*}}}*/
    private function _verifyParams()
    {/*{{{*/
        if(!is_string($this->_from))
        {
            return false;
        }
        if(!is_array($this->_to) || empty($this->_to))
        {
            return false;
        }
        if(!is_string($this->_subject) || '' == $this->_subject)
        {
            return false;
        }
        if(!is_string($this->_msg) || '' == $this->_msg)
        {
            return false;
        }
        if(!is_array($this->_cc))
        {
            return false;
        }
        if(!is_array($this->_bcc))
        {
            return false;
        }
        if(self::CHARSET_UTF8 !== $this->_charset && self::CHARSET_GBK !== $this->_charset)
        {
            return false;
        }
        if(!is_string($this->_mimeVersion))
        {
            return false;
        }
        if(!is_string($this->_contentType))
        {
            return false;
        }
        return true;
    }/*}}}*/
    private function _prepareSend()
    {/*{{{*/
        $this->_HEADER['From'] = $this->_from;
        if(!empty($this->_cc))
        {
            $this->_HEADER['CC'] = $this->fmtAddr($this->_cc);
        }
        if(!empty($this->_bcc))
        {
            $this->_HEADER['BCC'] = $this->fmtAddr($this->_bcc);
        }
        if('' != $this->_mimeVersion)
        {
            $this->_HEADER['MIME-Version'] = $this->_mimeVersion;
        }
        if('' != $this->_contentType)
        {
            $this->_HEADER['ContentType'] = $this->_contentType;
        }
        $this->_HEADER['ContentType'].= '; '.$this->_charset;
    }/*}}}*/
    private function _fmtAddr($addr)
    {/*{{{*/
        return implode(self::ADDR_SPR, $addr);
    }/*}}}*/
    private function _send()
    {/*{{{*/
        $to      = $this->_fmtAddr($this->_to);
        $subject = (self::CHARSET_UTF8 == $this->_charset) ? $this->_convertSubjectToUtf8() : $this->_subject;
        $msg     = $this->_msg;
        $header  = $this->_getHeader();

        return mail($to, $subject, $msg, $header);
    }/*}}}*/
    private function _convertSubjectToUtf8()
    {/*{{{*/
        return '=?UTF-8?B?'.base64_encode($this->_subject).'?=';
    }/*}}}*/
    private function _getHeader()
    {/*{{{*/
        $result = array();
        foreach($this->_HEADER as $key => $value)
        {
            if('' != $value)
            {
                $result[] = "$key: $value";
            }
        }
        return implode(self::HEADER_SPR, $result);
    }/*}}}*/
}/*}}}*/
