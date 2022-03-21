<?php
    namespace xbweb\mailers;

    use xbweb\Error;
    use xbweb\Mailer;

    class SMTP extends Mailer {
        /**
         * @param $socket
         * @param $resp
         * @param string $str
         * @return bool
         * @throws Error
         */
        protected function _socket($socket, $resp, $str = '') {
            $sresp = null;
            while (@substr($sresp, 3, 1) != ' ')
                if (!($sresp = fgets($socket, 256))) throw new Error('SMTP error: '.$str);
            if (!(substr($sresp, 0, 3) == $resp)) throw new Error('SMTP error: '.$str);
            return true;
        }

        /**
         * @param $template
         * @param $subject
         * @param array $data
         * @param null $attach
         * @return bool
         * @throws Error
         */
        public function send($template, $subject, $data = array(), $attach = null) {
            $dto = new \DateTime();
            $bnd = "--".$this->_splitter."\r\n";

            $rec = array();
            foreach ($this->_to  as $email) $rec[] = $email;
            foreach ($this->_cc  as $email) $rec[] = $email;
            foreach ($this->_bcc as $email) $rec[] = $email;
            if (empty($rec)) throw new Error('No mail addresses');

            if (!$socket = fsockopen(
                $this->_config['host'],
                $this->_config['port'],
                $en, $es,
                $this->_config['timeout'])
            ) throw new Error('SMTP error: '.$es);
            $this->_socket($socket, '220', 'no socket');

            $lines = array(
                array('EHLO '.$this->_config['host'], '250', 'no response'),
                array('AUTH LOGIN', '334', 'no auth'),
                array(base64_encode($this->_config['user']), '334', 'no login'),
                array(base64_encode($this->_config['pass']), '235', 'no pass'),
                array('MAIL FROM'.$this->_from, '250', 'no from')
            );

            foreach ($rec as $mtoi) {
                $lines[] = array('RCPT TO: '.$mtoi, '250', 'invalid address');
            }

            $lines[] = array('DATA', '354', 'invalid data');

            $headers = $this->get_headers($subject);
            $data['config']  = $this->_config;
            $data['subject'] = $subject;
            $msg     = self::letter($template, $data)."\r\n";

            if (is_array($attach)) if (count($attach) > 0) {
                $headers["Content-Type"] = 'multipart/mixed; boundary="'.$bnd.'"';
                unset($headers["Content-Transfer-Encoding"]);
                $msg.= $bnd;
                $msg.= 'Content-Type: text/'.$this->_config['type'].'; charset="'.$this->_config['charset'].'"'."\r\n";
                $msg.= "Content-Transfer-Encoding: 8bit\r\n\r\n$msg\r\n\r\n$bnd";
                foreach ($attach as $fn) $msg.= $this->file($fn);
            }

            $_ = array('Date: '.$dto->format('D, d M Y H:i:s')." UT");
            foreach ($headers as $k => $v) $_[] = "$k: $v";
            $headers = implode("\r\n", $_)."\r\n";

            $lines[] = array("$headers\r\n$msg\r\n.", '250', 'mail not sent');

            foreach ($lines as $line) {
                fputs($socket, $line[0]."\r\n");
                if (!$this->_socket($socket, $line[1], $line[2])) {
                    fclose($socket);
                    return false;
                }
            }

            fputs($socket,"QUIT\r\n");
            fclose($socket);
            return true;
        }

        /**
         * @param $config
         * @return array
         * @throws Error
         */
        public function config($config) {
            if (!is_array($config)) throw new Error('Invalid SMTP config');
            $ret = array();
            foreach (array('host', 'user', 'pass') as $k) {
                if (empty($config[$k])) throw new Error('No SMTP '.$k);
                $ret[$k] = $config[$k];
            }
            $def = array('priority' => 3, 'port' => 25, 'timeout' => 30);
            foreach ($def as $k => $d) $ret[$k] = isset($config[$k]) ? $config[$k] : $d;
            return $ret;
        }
    }