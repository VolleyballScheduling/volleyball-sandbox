<?php
namespace Volleyball\Component\Report\Renderer;

class TwigRenderer implements RendererInterface
{
    /**
     * @var \Twig_Environment
     */
    private $environment;
    private $matcher;
    private $defaultOptions;

    /**
     * @param \Twig_Environment $environment
     * @param string            $template
     * @param array             $defaultOptions
     */
    public function __construct(\Twig_Environment $environment, $template, array $defaultOptions = array())
    {
        $this->environment = $environment;
        $this->defaultOptions = array_merge(
            array(
                'template' => $template
            ),
            $defaultOptions
        );
    }

    public function render(reportInterface $report, array $options = array())
    {
        $options = array_merge($this->defaultOptions, $options);

        $html = $this->environment->render($options['template'], array('report' => $report, 'options' => $options));

        return $html;
    }
}
