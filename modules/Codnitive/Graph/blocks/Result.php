<?php 
/**
 * Graph string analyzer result drow graph block
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph\blocks;

use app\modules\Codnitive\Core\blocks\Template;

class Result extends Template
{
    /**
     * Drow analyzed string graph html
     * 
     * @param array graph statistics
     * @return string
     */
    public function drawGraph(array $graphStatistics): string
    {
        $html = '';
        foreach ($graphStatistics as $character => $data) {
            $html .= '<div class="graph-block row col-12 text-center p-4 m-0"><div class="parent col-12 p-2 text-info">'.$character.'</div>';
            if (!empty($data['before'])) {
                $before = array_unique($data['before']);
                $width = 100 / count($before);
                foreach ($before as $node) {
                    $html .= '<div class="nodes p-1 text-success" style="width:'.$width.'%;">'.$node.'</div>';
                }
            }
            $html .= '</div>';
        }
        return $html;
    }
}
