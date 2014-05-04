<?php
namespace Volleyball\Component\Report\Renderer;

interface RendererInterface
{
    /**
     * Renders report
     * @param ReportInterface $report
     * @param array $options
     * @return string
     */
    public function render(ReportInterface $report, array $options = array());
}
