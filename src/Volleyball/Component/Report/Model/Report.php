<?php
namespace Volleyball\Component\Report\Model;

use Volleyball\Component\Report\Interfaces\ReportInterface;

class Report implements ReportInterface
{
    /**
     * Name
     * @var string
     */
    protected $name;
    
    /**
     * Template
     * @var string
     */
    protected $template;

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     * @param string $name
     * @return \Volleyball\Component\Report\Model\Report
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get template
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set template
     * @param string $template
     * @return \Volleyball\Component\Report\Model\Report
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    public function generate(array $options)
    {
        return false;
    }

    public function render(array $options)
    {
        return false;
    }
}
