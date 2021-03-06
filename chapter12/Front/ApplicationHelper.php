<?php

require_once '../Registry/Registry.php';


class ApplicationHelper
{
    private string $config = __DIR__.'/data/woo_options.ini';
    private Registry $reg;

    public function __construct()
    {
        $this->reg = Registry::instance();
    }

    public function init()
    {
        $this->setupOptions();

        if (isset($_SERVER['REQUEST_METHOD']))
            $request = new HttpRequest();
        else
            $request = new CliRequest();

        $this->reg->setRequest($request);
    }

    private function setupOptions()
    {
        if (!file_exists($this->config))
            throw new AppException("Could not find options file");

        $options = parse_ini_file($this->config, true);

        $conf = new Conf($options['config']);
        $this->reg->setConf($conf);

        $commands = new Conf($options['command']);
        $this->reg->setCommands($commands);
    }
}