<?php
    namespace xbweb;

    use xbweb\lib\Content;

    abstract class Mailer extends BasicObject {
        const MIME_VERSION = '1.0';

        protected $_config   = null;
        protected $_from     = null;
        protected $_reply    = null;
        protected $_to       = array();
        protected $_cc       = array();
        protected $_bcc      = array();
        protected $_splitter = '';

        protected function __construct($config) {
            $def = array(
                'version' => static::MIME_VERSION,
                'type'    => 'html',
                'charset' => 'utf-8'
            );
            foreach ($def as $k => $d) if (!isset($config[$k])) $config[$k] = $d;
            $this->_config = $this->config($config);
            $dtn = new \DateTime();
            $this->_splitter = md5($dtn->format('Y-m-d H:i:s.u'));
        }

        protected function get_headers($subject) {
            $headers = array(
                'MIME-Version' => $this->_config['version'],
                'Content-Type' => 'text/'.$this->_config['type'].'; charset="'.$this->_config['charset'].'"',
                'Content-Transfer-Encoding' => '8bit',
                'From'         => $this->_from,
                'Reply-To'     => $this->_reply,
                'Subject'      => $this->encode($subject),
                'To'           => implode(',', $this->_to)
            );
            if (!empty($this->_cc))  $headers['CC']  = implode(',',$this->_cc);
            if (!empty($this->_bcc)) $headers['BCC'] = implode(',',$this->_bcc);
            $headers['X-Mailer']   = 'XBWeb CMF mailer';
            $headers['X-Priority'] = $this->_config['priority'];
            $headers['Message-ID'] = $this->messageID($subject);
            return $headers;
        }

        public function messageID($subject) {
            $d = new \DateTime();
            $s = $this->_from.' '.implode(',', $this->_to).' '.$subject;
            return $d->format('YmdHis').'.'.md5($s);
        }

        /**
         * @param $mail
         * @param null $name
         * @return $this
         * @throws Error
         */
        public function from($mail, $name = null) {
            $address = trim($mail);
            if (false === strrpos($mail, '@')) throw new Error('Invalid from mail address');
            if (empty($name)) {
                $this->_from = $address;
            } else {
                $name = trim(preg_replace('/[\r\n]+/', '', $name));
                $this->_from = $this->encode($name)." <{$address}>";
            }
            return $this;
        }

        /**
         * @param $mail
         * @return $this
         * @throws Error
         */
        public function reply($mail) {
            $address = trim($mail);
            if (false === strrpos($mail, '@')) throw new Error('Invalid reply-to mail address');
            $this->_reply = $address;
            return $this;
        }

        public function to($mail, $name = null) {
            $this->_to[] = $this->address($mail, $name);
            return $this;
        }

        public function cc($mail, $name = null) {
            $this->_cc[] = $this->address($mail, $name);
            return $this;
        }

        public function bcc($mail, $name = null) {
            $this->_bcc[] = $this->address($mail, $name);
            return $this;
        }

        public function address($mail, $name = null) {
            $address = trim($mail);
            if (false === strrpos($mail, '@')) return false;
            $address = "<{$address}>";
            if (empty($name)) return $address;
            $name = trim(preg_replace('/[\r\n]+/', '', $name));
            return $this->encode($name).' '.$address;
        }

        public function encode($s) {
            $s = base64_encode($s);
            return "=?{$this->_config['charset']}?B?{$s}?=";
        }

        public function file($fn) {
            $fid = md5(basename($fn));
            $msg = 'Content-Type: application/octet-stream; name="'.$fid.'"'."\r\n";
            $msg.= "Content-transfer-encoding: base64\r\n";
            $msg.= 'Content-Disposition: attachment; filename="'.$fid.'"'."\r\n\r\n";
            $f   = fopen($fn, "rb");
            $msg.= chunk_split(base64_encode(fread($f, filesize($fn))));
            fclose($f);
            $msg.= "\r\n" . $this->_splitter;
            return $msg;
        }

        abstract public function config($config);
        abstract public function send($template, $subject, $data = array(), $attach = null);

        public static function letter($template, $data) {
            $template = explode('/', $template);
            $module   = array_shift($template);
            $template = implode('/', $template);
            $fnt = Content::file($template.'.'.Content::EXT_TPL, 'templates/mail', $module, false, $fl);
            if (empty($fnt)) return true;
            return Content::render($fnt, $data, $fl);
        }

        /**
         * @param null $config
         * @return Mailer
         * @throws Error
         */
        public static function create($config = null) {
            if ($config === null) $config = Config::get('mailer');
            if (empty($config)) throw new Error('No mailer configuration');
            $type = empty($config['type']) ? 'sendmail' : $config['type'];
            $cn = '\\xbweb\\mailers\\'.$type;
            return new $cn($config);
        }
    }