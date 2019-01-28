<?php 
/**
 * Graph string analyzer form block
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph\blocks;

use app\modules\Codnitive\Core\blocks\Template;

class Result extends Template
{
    public function drawGraph(array $graphStatistics, array $nodes, string $html = ''): string
    {
        // dump($graphStatistics);
        // echo '<hr>';
        // dump($nodes);
        // echo '<hr>';
        // exit;
        if (empty($nodes)) {
            return $html;
        }

        foreach ($nodes as $node) {
            // $html .= '<div>' . $node;
            if (!empty($graphStatistics[$node]['before']) && isset($graphStatistics[$node])) {
                $childeren = array_unique($graphStatistics[$node]['before']);
                unset($graphStatistics[$node]);
                $html .= '<div>'.$this->drawGraph($graphStatistics, $childeren, $html);
            }
            else {
                $html .= $node.'</div>';
            }
        }
        return $html;

        // if (!empty($graphStatistics[$node]['before'])) {
        //     $html .= '<div>' . $node;
        //     $html .= $this->drawGraph($graphStatistics, $graphStatistics[$node]['before'], $html);
        //     $html .= '</div>';
        //     unset($graphStatistics[$node]);
        // }
        // return $html;

        // foreach ($nodes as $node) {
        //     if (!isset($graphStatistics[$node]) || empty($graphStatistics[$node]['before'])) {
        //         $html .= "<div class='row'>$node</div>";
        //     }
        //     else {
        //         $html .= $this->drawGraph($graphStatistics, $graphStatistics[$node]['before'], $html);
        //         unset($graphStatistics[$node]);
        //     }
        // }
        // return $html;
    }
}
